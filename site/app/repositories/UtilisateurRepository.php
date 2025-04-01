<?php
require_once './app/core/Repository.php';
require_once './app/entities/Utilisateur.php';

class UtilisateurRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Repository::getInstance()->getPDO();
    }

    public function findAll(): array {
        $stmt = $this->pdo->query('SELECT * FROM Utilisateur');
        $utilisateurs = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $utilisateurs[] = $this->createUtilisateurFromRow($row);
        }
		print_r($utilisateurs);
        return $utilisateurs;
    }

    private function createUtilisateurFromRow(array $row): Utilisateur
    {
        return new Utilisateur($row['id'], $row['num_etu'], (bool)$row['est_admin'], $row['prenom'], $row['nom'], $row['email'], $row['mdp']);
    }

    public function create(Utilisateur $utilisateur): bool {
        $stmt = $this->pdo->prepare('INSERT INTO Utilisateur (num_etu, est_admin, prenom, nom, email, mdp) VALUES (:numEtu, :estAdmin, :prenom, :nom, :email, :mdp)');
        return $stmt->execute([
			'numEtu' => $utilisateur->getNumEtu(),
			'estAdmin' => $utilisateur->getEstAdmin() ? 1 : 0,
            'prenom' => $utilisateur->getPrenom(),
            'nom' => $utilisateur->getNom(),
            'email' => $utilisateur->getEmail(),
            'mdp' => $utilisateur->getMdp(),
        ]);

		//$stmt = $this->pdo->prepare('DELETE FROM "User"');
		//$stmt->execute();
		//return true;
    }

    public function update(Utilisateur $utilisateur): bool
    {
        $stmt = $this->pdo->prepare('UPDATE Utilisateur SET num_etu = :newNumEtu, est_admin = :newEstAdmin, prenom = :newPrenom, nom = :newNom, email = :newEmail, mdp = :newPassword WHERE id = :id');
        return $stmt->execute([
			'newNumEtu' => $utilisateur->getNumEtu(),
			'newEstAdmin' => $utilisateur->getEstAdmin(),
            'newPrenom' => $utilisateur->getPrenom(),
            'newNom' => $utilisateur->getNom(),
            'newEmail' => $utilisateur->getEmail(),
            'newMdp' => $utilisateur->getMdp(),
            'id' => $utilisateur->getId(),
        ]);
    }

    public function findByEmail(string $email): ?Utilisateur {
        $stmt = $this->pdo->prepare('SELECT * FROM Utilisateur WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
        if($utilisateur)
            return $this->createUtilisateurFromRow($utilisateur);
        return null;
    }

    public function findById(int $id): ?Utilisateur {
        $stmt = $this->pdo->prepare('SELECT * FROM Utilisateur WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);
        if($utilisateur)
            return $this->createUtilisateurFromRow($utilisateur);
        return null;
    }
}
