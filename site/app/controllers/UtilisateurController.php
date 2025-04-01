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

		//if ($utilisateurActif === null || !$utilisateurActif->getEstAdmin()) {
		//	$this->redirectTo('index.php');
		//	return;
		//}

        // Ensuite, affiche la vue
        $this->view('/utilisateur/index.html.twig',  ['utilisateurs' => $utilisateurs, 'utilisateurActif' => $utilisateurActif]);
    }

    public function create() {
        $data = $this->getAllPostParams(); // Récupération des données soumises
        $errors = [];

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
                $utilisateur = new Utilisateur(null, $data['numEtu'], false, $data['prenom'], $data['nom'], $data['email'],$hashedPassword);

                // Sauvegarde dans la base de données
                $utilisateurRepo = new UtilisateurRepository();
                if (!$utilisateurRepo->create($utilisateur)) {
                    throw new Exception('Erreur lors de l\'enregistrement de l\'utilisateur.');
                }

                $this->redirectTo('utilisateurs.php'); // Redirection après création
				//$this->redirectTo('login.php');
            } catch (Exception $e) {
                $errors = explode(', ', $e->getMessage()); // Récupération des erreurs
            }
        }

        // Affichage du formulaire
        $this->view('/utilisateur/form.html.twig',  [
            'data' => $data,
            'errors' => $errors,
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
			'estAdmin'=>$utilisateur->getEstAdmin(),
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
                if (empty($data['mdp']) || strlen($data['mdp']) < 6) {
                    $errors[] = 'Le mot de passe doit contenir au moins 6 caractères.';
                }

                if (!empty($errors)) {
                    throw new Exception(implode(', ', $errors));
                }

                // Update utilisateur object
				$utilisateur->setNumEtu($data['numEtu']);
				$utilisateur->setEstAdmin(false);
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

        // Display update form
        $this->view('/utilisateur/form.html.twig',  ['data' => $data, 'errors' => $errors, 'id' => $id]);
    }
}
