<?php
class Rubrique {

    public function __construct(private ?int $id,
    private string $nom,
    private string $description,
    private ?string $image = null) {

    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getImage(): ?string {
        return $this->image;
    }


    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setImage(string $image): void {
        $this->image = $image;
    }

}
?>
