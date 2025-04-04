<?php

require_once './app/core/Controller.php';
//require_once './app/repositories/CommandeRepository.php';
require_once './app/trait/FormTrait.php';
require_once './app/trait/AuthTrait.php';
require_once './app/services/AuthService.php';

class CommandeController extends Controller {

    use FormTrait;
    use AuthTrait;

    public function index() {
        //$repository = new CommandeRepository();
        //$Commandes = $repository->findAll();
		$Commandes = [];

		$authService = new AuthService();
		$utilisateurActif = $authService->getUtilisateur();

		if ($utilisateurActif === null || !$utilisateurActif->estAdmin()) {
			$this->redirectTo('index.php');
			return;
		}

        // Ensuite, affiche la vue
        $this->view('/commande/index.html.twig',  [
			'Commandes' => $Commandes, 
			'utilisateurActif' => $utilisateurActif
		]);
    }
}
