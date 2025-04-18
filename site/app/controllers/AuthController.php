<?php

require_once './app/core/Controller.php';
require_once './app/services/AuthService.php';
require_once './app/trait/FormTrait.php';
require_once './app/trait/AuthTrait.php';

class AuthController extends Controller {
    use FormTrait;
    use AuthTrait;

    public function login() {
        $authService = new AuthService();

        // Récupérer les données POST nettoyées
        $postData = $this->getAllPostParams();
        $data = [];

        // Si aucune donnée n'est envoyée en POST ou si la connexion échoue, afficher le formulaire
        if (!empty($postData))
        {
            $userRepository = new UtilisateurRepository();

            $user = $userRepository->findByEmail($this->getPostParam('email'));

            if($user !== null && 
				$this->verify($this->getPostParam('password'),$user->getMdp()))
            {
                $authService->setUtilisateur($user);
                $this->redirectTo('index.php');
            }
			// si des données existent, elles ne sont pas valide
            $data= empty($postData) ? []:['error'=>'Email ou mot de passe invalide'];

        }

        $this->view('login.html.twig', $data ); // Affiche la vue login.php
    }
	
	public function logout() {
		$authService = new AuthService();
		$authService->logout();

		$this->redirectTo('index.php');
	}
}
