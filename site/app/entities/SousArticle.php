<?php
class SousArticle {

    public function __construct(
        private ?int $id,
        private int $article_id,
        private string $couleur,
        private ?string $taille,
        private int $stock
    ) {}

    public function getId(): ?int {
        return $this->id;
    }

    public function getArticleId(): int {
        return $this->article_id;
    }

    public function getCouleur(): ?string {
        return $this->couleur;
    }

    public function getTaille(): ?string {
        return $this->taille;
    }

    public function getStock(): int {
        return $this->stock;
    }

    public function setArticleId(int $article_id): void {
        $this->article_id = $article_id;
    }

    public function setCouleur(string $couleur): void {
        $this->couleur = $couleur;
    }

    public function setTaille(?string $taille): void {
        $this->taille = $taille;
    }

    public function setStock(int $stock): void {
        $this->stock = $stock;
    }
}
?>
