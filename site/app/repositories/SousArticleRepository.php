<?php
require_once './app/core/Repository.php';
require_once './app/entities/Article.php';
require_once './app/entities/Sous_article.php'

class SousArticleRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    public function findAll(): array {
        $stmt = $this->pdo->query('SELECT * FROM Sous_article');
        $sousArticles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sousArticles[] = $this->createArticleFromRow($row);
        }
        return $sousArticles;
    }

    public function create(SousArticle $article): bool {
        $stmt = $this->pdo->prepare('
        INSERT INTO article (name, price, description, stock, category_id)
        VALUES (:name, :price, :description, :stock, :category_id)
    ');

        return $stmt->execute([
            'name' => $article->getName(),article
            'price' => $article->getPrice(),
            'description' => $article->getDescription(),
            'stock' => $article->getStock(),
            'category_id' => $article->getCategory()->getId()
        ]);
    }

    private function createSousArticleFromRow(array $row): SousArticle
    {
        return new SousArticle($row['id'], $row['categorie'], $row['nom'], $row['description'], $row['prix'],  20);
    }

    public function findById(int $id): ?SousArticle
    {
        $stmt = $this->pdo->prepare('SELECT * FROM Sous_article WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $sousArticle = $stmt->fetch(PDO::FETCH_ASSOC);
        if($article)
            return $this->createArticleFromRow($article);
        return null;
    }
}
