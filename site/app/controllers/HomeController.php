<?php

require_once './app/core/Controller.php';
require_once './app/repositories/RubriqueRepository.php';
require_once './app/repositories/EvenementRepository.php';
require_once './app/services/AuthService.php';
require_once './app/trait/FormTrait.php';

class HomeController extends Controller
{
	use FormTrait;
    public function index()
    {
	   $authService = new AuthService();
	   $utilisateurActif = $authService->getUtilisateur();

        if(session_status() == PHP_SESSION_NONE)
           session_start();
		   
		$evenementRepo = new EvenementRepository();
		$rubriqueRepo = new RubriqueRepository();

        $evenements = $evenementRepo->findAll();
		$rubriques = $rubriqueRepo->findAll();

		if (!$rubriques) 
		{
			die("Rubrique introuvable.");
		}

        $this->view('index.html.twig',  [
            'title' => 'Le site du BDE',
			'utilisateurActif' => $utilisateurActif,
			'rubriques' => $rubriques,
			'evenements' => $evenements
        ]);
    }
}
