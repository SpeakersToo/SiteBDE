<?php
require_once './app/core/Repository.php';
require_once './app/entities/SousArticle.php';
require_once './app/repositories/ArticleRepository.php';

class SousArticleRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    public function findAll(): array {
        $stmt = $this->pdo->query('SELECT * FROM Sous_article');
        $sousArticles = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sousArticles[] = $this->createSousArticleFromRow($row);
        }
        return $sousArticles;
    }

    /*public function create(SousArticle $sousArticle): bool {
        $ac = new ArticleRepository();
        $stmt = $this->pdo->prepare('
        INSERT INTO Sous_article (article_id, couleur, taille, stock)
        VALUES (:article_id, :couleur, :taille, :stock)
    ');

        return $stmt->execute([
            'article_id' => $sousArticle->getArticleId(),
            'couleur' => $sousArticle->getCouleur(),
            'taille' => $sousArticle->getTaille(),
            'stock' => $sousArticle->getStock()
        ]);
    }*/

    private function createSousArticleFromRow(array $row): SousArticle {
        $ac = new ArticleRepository();
        $article = $ac->findById($row['article_id']);

        $sousArticle = new SousArticle(
            $row['id'], 
            $article,
            $row['couleur'], 
            $row['taille'], 
            $row['stock']
        );

        if (!in_array($sousArticle, $article->getSousArticles())) {
            $article->addSousArticle($sousArticle);
        }
        return $sousArticle;
    }

    public function findById(int $id): ?SousArticle
    {
        $stmt = $this->pdo->prepare('SELECT * FROM Sous_article WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $sousArticle = $stmt->fetch(PDO::FETCH_ASSOC);
        if($sousArticle)
            return $this->createSousArticleFromRow($sousArticle);
        return null;
    }
}
?>