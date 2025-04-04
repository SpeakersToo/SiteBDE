<?php

require_once './app/core/Repository.php';
require_once './app/entities/Rubrique.php';

class RubriqueRepository {

    private $pdo;

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    public function findAll(): array {
        $stmt = $this->pdo->query('SELECT * FROM Rubrique');
        $rubriques = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $rubriques[] = $this->createRubriqueFromRow($row);
			
        }
        return $rubriques;
    }

    public function create(Rubrique $rubrique): bool {
        $stmt = $this->pdo->prepare('
        INSERT INTO Rubrique (nom, description) 
		VALUES (:nom, :description)
    ');


        return $stmt->execute([
            'nom' => $rubrique->getNom(),
            'description' => $rubrique->getDescription()
        ]);
    }

    public function createRubriqueFromRow(array $row)
    {
        return new Rubrique($row['id'], $row['nom'], $row['description']);
    }

    public function findById(int $id): ?Rubrique {
        $stmt = $this->pdo->prepare('SELECT * FROM Rubrique WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row ? $this->createRubriqueFromRow($row) : null;
    }
    
	public function delete(int $id): bool {
		$stmt = $this->pdo->prepare('DELETE FROM Rubrique WHERE id = :id');
		return $stmt->execute(['id' => $id]);
	}
}
