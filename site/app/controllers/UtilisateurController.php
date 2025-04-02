<?php

require_once './app/core/Controller.php';
require_once './app/repositories/UtilisateurRepository.php';
require_once './app/trait/FormTrait.php';
require_once './app/trait/AuthTrait.php';
require_once './app/services/AuthService.php';

class UtilisateurController extends Controller {

    use FormTrait;
    use AuthTrait;

    public function index() {
        $repository = new UtilisateurRepository();
        $utilisateurs = $repository->findAll();

		$authService = new AuthService();
		$utilisateurActif = $authService->getUtilisateur();

		if ($utilisateurActif === null || !$utilisateurActif->estAdmin()) {
			$this->redirectTo('index.php');
			return;
		}

        // Ensuite, affiche la vue
        $this->view('/utilisateur/index.html.twig',  [
			'utilisateurs' => $utilisateurs, 
			'utilisateurActif' => $utilisateurActif
		]);
    }

    public function create() {
        $data = $this->getAllPostParams(); // Récupération des données soumises
        $errors = [];

		$authService = new AuthService();
		$utilisateurActif = $authService->getUtilisateur();

        if (!empty($data)) {
            try {
                $errors = [];

                // Validation des données
				if (empty($data['numEtu']) || strlen($data['numEtu']) != 8) {
                    $errors[] = 'Un numéro étudiant valide est requis.';
                }
                if (empty($data['prenom'])) {
                    $errors[] = 'Le prénom est requis.';
                }
                if (empty($data['nom'])) {
                    $errors[] = 'Le nom est requis.';
                }
                if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'Un email valide est requis.';
                }
                if (empty($data['mdp']) || strlen($data['mdp']) < 6) {
                    $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
                }

                if (!empty($errors)) {
                    throw new Exception(implode(', ', $errors));
                }

                // Création de l'objet utilisateur
                $hashedPassword = $this->hash($data['mdp']);
                $utilisateur = new Utilisateur(
					null, 
					$data['numEtu'], 
					$data['estAdmin'] === 'on' ? 1 : 0,
					$data['newsletter'] === 'on' ? 1 : 0,
					$data['prenom'], 
					$data['nom'], 
					$data['email'],
					$hashedPassword
				);
				var_dump("estAdmin ".$data['estAdmin']);
				var_dump("newsletter ".$data['newsletter']);

                // Sauvegarde dans la base de données
                $utilisateurRepo = new UtilisateurRepository();
                if (!$utilisateurRepo->create($utilisateur)) {
                    throw new Exception('Erreur lors de l\'enregistrement de l\'utilisateur.');
                }

				if($utilisateurActif && $utilisateurActif->estAdmin())
					$this->redirectTo('utilisateurs.php');
				else
					$this->redirectTo('login.php');

            } catch (Exception $e) {
                $errors = explode(', ', $e->getMessage()); // Récupération des erreurs
            }
        }

        // Affichage du formulaire
        $this->view('/utilisateur/form.html.twig',  [
            'data' => $data,
            'errors' => $errors,
			'isAdmin' => $utilisateurActif && $utilisateurActif->estAdmin(),
			'utilisateurActif' => $utilisateurActif
        ]);
    }

    public function update()
    {
        $id = $this->getQueryParam('id');

        if ($id === null) {
            throw new Exception('Utilisateur ID is required.');
        }
        $repository = new UtilisateurRepository();
        $utilisateur = $repository->findById($id);

        if ($utilisateur === null) {
            throw new Exception('Utilisateur not found');
        }

        $data = array_merge([
			'numEtu'=>$utilisateur->getNumEtu(),
			'estAdmin'=>$utilisateur->estAdmin(),
			'newsletter'=>$utilisateur->newsletter(),
            'prenom'=>$utilisateur->getPrenom(),
            'nom'=>$utilisateur->getNom(),
            'email'=>$utilisateur->getEmail(),
        ],$this->getAllPostParams()); //Get submitted data
        $errors = [];

        if (!empty($this->getAllPostParams())) {
            try {
                $errors = [];

                // Validation des données
				if (empty($data['numEtu'])) {
                    $errors[] = 'Le numéro étudiant est requis.';
                }
                if (empty($data['prenom'])) {
                    $errors[] = 'Le prénom est requis.';
                }
                if (empty($data['nom'])) {
                    $errors[] = 'Le nom est requis.';
                }
                if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'Un email valide est requis.';
                }
                if (!empty($data['mdp']) && strlen($data['mdp']) < 6) {
                    $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
                }

                if (!empty($errors)) {
                    throw new Exception(implode(', ', $errors));
                }

                // Update utilisateur object
				$utilisateur->setNumEtu($data['numEtu']);
				$utilisateur->setAdmin($data['estAdmin'] === 'on' ? 1 : 0);
				$utilisateur->setNewsletter($data['newsletter'] === 'on' ? 1 : 0);
                $utilisateur->setPrenom($data['prenom']);
                $utilisateur->setNom($data['nom']);
                $utilisateur->setEmail($data['email']);

                // If password field is not empty, then update the password.
                if (!empty($data['mdp'])) {
                    $hashedPassword = $this->hash($data['mdp']);
                    $utilisateur->setMdp($hashedPassword);
                }

                // Save to database
                if (!$repository->update($utilisateur)) {
                    throw new Exception('Error updating the utilisateur.');
                }

                $this->redirectTo('utilisateurs.php'); // Redirect after update

            } catch (Exception $e) {
                $errors = explode(', ', $e->getMessage()); // Error retrieval
            }
        }

		$authService = new AuthService();
		$utilisateurActif = $authService->getUtilisateur();

        // Display update form
        $this->view('/utilisateur/form.html.twig',  [
			'data' => $data, 
			'errors' => $errors, 
			'id' => $id,
			'isAdmin' => $utilisateurActif && $utilisateurActif->estAdmin(),
			'utilisateurActif' => $utilisateurActif
		]);
    }

	public function delete()
	{
		$id = $this->getQueryParam('id');
	
		if ($id === null) {
			throw new Exception('Utilisateur ID is required.');
		}
	
		$repository = new UtilisateurRepository();
		$utilisateur = $repository->findById($id);
	
		if ($utilisateur === null) {
			throw new Exception('Utilisateur not found');
		}
	
		if (!$repository->delete($id)) {
			throw new Exception('Error deleting the utilisateur.');
		}
	
		$utilisateurActif = (new AuthService())->getUtilisateur();

		if($utilisateurActif && $utilisateurActif->estAdmin())	
			$this->redirectTo('utilisateurs.php');
		else
			$this->redirectTo('logout.php');
	}
}
