<?php
require_once './app/trait/AuthTrait.php';
require_once './app/trait/FormTrait.php';
require_once './app/repositories/UtilisateurRepository.php';
require_once './app/repositories/RubriqueRepository.php';
require_once './app/entities/Utilisateur.php';

class RubriqueService {

//    use AuthTrait;
	use FormTrait;

	
	public function create(array $data) : Rubrique
	{
        //$this->checkAuth();

        $errors = [];


		// Validation des données
		if (empty($data['nom'])) 
		{
			$errors[] = 'Le nom est requis.';
		}

		if (empty($data['description'])) 
		{
			$errors[] = 'La description est requise.';
		}
		
		if (!empty($errors)) {
			throw new Exception(implode(', ', $errors));
		}

		$rubrique = new Rubrique(
			null,
			$data['nom'],
			$data['description']
		);

		$repository = new RubriqueRepository();
		if (!$repository->create($rubrique)) {
			throw new Exception('Erreur lors de la création de la rubrique.');
		}


		return $rubrique;

    }
}
