<?php
class Article {

    public function __construct(private ?int $id,
    private string $categorie,
    private string $nom,
    private string $description,
    private float $prix
    ) {

    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getCategorie(): string {
        return $this->categorie;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getPrix(): float {
        return $this->prix;
    }

    public function getDescription(): string {
        return $this->description;
    }
	
    public function setCategorie(string $categorie): void {
        $this->categorie = $categorie;
    }
    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function setPrix(float $prix): void {
        $this->prix = $prix;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }



}
?>
