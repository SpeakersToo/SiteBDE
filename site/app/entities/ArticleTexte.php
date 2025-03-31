<?php

// Les articles de texte accessible depuis l'accueil
class ArticleTexte {

    public function __construct(private ?int $id,
    private string $name,
    private string $description,) {

    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription(): string {
        return $this->description;
    }


    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

}
?>
