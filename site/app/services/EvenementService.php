<?php
require_once './app/trait/AuthTrait.php';
require_once './app/trait/FormTrait.php';
require_once './app/repositories/UtilisateurRepository.php';
require_once './app/entities/Utilisateur.php';

class EvenementService {

//    use AuthTrait;
	use FormTrait;

	
	public function create(array $data) : Evenement
	{
        //$this->checkAuth();

        $errors = [];


		// Validation des données
		if (empty($data['nom'])) 
		{
			$errors[] = 'Le nom est requis.';
		}

		if (empty($data['date_heure'])) 
		{
			$errors[] = 'La date et l\'heure est requise.';
		}

		if (empty($data['description'])) 
		{
			$errors[] = 'La description est requise.';
		}

		if (empty($data['adresse'])) 
		{
			$errors[] = 'La description est requise.';
		}

		if (empty($data['nb_places']) || $data['nb_places'] < 0) 
		{
			$errors[] = 'Le nombre de places ne peut pas être négatif.';
		}

		if (empty($data['nom_image'])) 
		{
			$errors[] = 'Une image est requise.';
		}

		
		if (!empty($errors)) {
			throw new Exception(implode(', ', $errors));
		}

		$evenement = new Evenement(
			null,
			$data['nom'],
			$data['date_heure'],
			$data['description'] ?? '',
			$data['adresse'],
			(int)$data['nb_places'],
			$data['nom_image'] ?? ''
		);

		$repository = new EvenementRepository();
		if (!$repository->create($evenement)) {
			throw new Exception('Erreur lors de la création de l\'evenement.');
		}

		/* Gardé au cas-où si on veut faire fonctionner les images
		$nom_image = $data['nom_image'];
		$chemin_fichier = './assets/images/evenement/' . $evenement->getNom_image();

		file_put_contents( $chemin_fichier, fopen($nom_image, 'r'));*/

		return $evenement;

    }
}
