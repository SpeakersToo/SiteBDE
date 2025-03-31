<?php

require_once './app/core/Repository.php';
require_once './app/entities/Evenement.php';

class EvenementRepository {

    private $pdo;

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    public function findAll(): array {
        $stmt = $this->pdo->query('SELECT * FROM Evenement');
        $evenements = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $evenements[] = $this->createEvenementFromRow($row);
        }
        return $evenements;
    }

    public function create(Evenement $evenement): bool {
        $stmt = $this->pdo->prepare('
        INSERT INTO Evenement (nom, date_heure, description, stock, category_id)
        VALUES (:name, :price, :description, :stock, :category_id)
    ');

        return $stmt->execute([
            'nom' => $evenement->getNom(),
            'date_heure' => $evenement->getDateHeure(),
            'description' => $evenement->getDescription(),
            'adresse' => $evenement->getAdresse(),
            'nb_places' => $evenement->getNbPlaces()
        ]);
    }

    public function createEvenementFromRow(array $row)
    {
        return new Evenement($row['id'], $row['nom'], $row['date'], $row['description'], $row['adresse'], $row['nbPlaces']);
    }

}
