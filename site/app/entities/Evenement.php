<?php
class Evenement {

    public function __construct(private ?int $id,
    private string $nom,
    private string $date_heure,
    private string $description,
    private string $adresse,
    private int $nb_places,
    private ?string $nom_image = '') {

    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getDate_heure(): string {
        return $this->date_heure;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getAdresse(): string {
        return $this->adresse;
    }

    public function getNb_places(): int {
        return $this->nb_places;
    }

    public function getNom_image(): string {
        return $this->nom_image;
    }


    public function setNom(string $nom): void {
        $this->nom = $nom;
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

    public function setNbPlaces(int $nb_places): void {
        $this->nb_places = $nb_places;
    }

    public function setNom_image(string $nom_image): void {
        $this->nom_image = $nom_image;
    }

}
?>
