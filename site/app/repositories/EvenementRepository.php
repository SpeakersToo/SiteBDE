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
        INSERT INTO Evenement 
		VALUES (:id, :nom, :date, :description, :adresse, :nb_places)
    ');

        return $stmt->execute([
			'id' => $this->getNumberOfEvenements()+1,
            'nom' => $evenement->getNom(),
            'date' => $evenement->getDate_heure(),
            'description' => $evenement->getDescription(),
            'adresse' => $evenement->getAdresse(),
            'nb_places' => $evenement->getNb_places()
        ]);
    }

    public function createEvenementFromRow(array $row)
    {
        return new Evenement($row['id'], $row['nom'], $row['date'], $row['description'], $row['adresse'], $row['nb_places']);
    }

    public function findById(int $id): ?Evenement {
        $stmt = $this->pdo->prepare('SELECT * FROM Evenement WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row ? $this->createEvenementFromRow($row) : null;
    }

	public function getNumberOfEvenements() : int
	{
        $stmt = $this->pdo->query('SELECT MAX(id) FROM Evenement');

		var_dump($stmt->fetch(PDO::FETCH_ASSOC));

		$row = $stmt->fetch(PDO::FETCH_ASSOC); 

		var_dump($row);

		$max = (int) $row["max"];
		return $max;
		
		
			
	}
    

}
