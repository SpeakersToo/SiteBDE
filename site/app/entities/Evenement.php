<?php
class Evenement {

    public function __construct(private ?int $id,
    private string $name,
    private string $date_heure,
    private string $description,
    private string $adresse,
    private int $nbPlaces,
    private ?string $image = null) {

    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDateHeure(): string {
        return $this->date_heure;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getAdresse(): string {
        return $this->adresse;
    }

    public function getNbPlaces(): int {
        return $this->nbPlaces;
    }

    public function getImage(): ?string {
        return $this->description;
    }


    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setDateHeure(string $date_heure): void {
        $this->date_heure = $date_heure;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setAdresse(string $adresse): void {
        $this->adresse = $adresse;
    }

    public function setNbPlaces(int $nbPlaces): void {
        $this->nbPlaces = $nbPlaces;
    }

    public function setImage(string $image): void {
        $this->image = $image;
    }

}
?>
