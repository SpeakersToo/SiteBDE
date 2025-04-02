<?php

require_once './app/core/Controller.php';
require_once './app/services/AuthService.php';
require_once './app/trait/FormTrait.php';

class HomeController extends Controller
{
	use FormTrait;
   public function index()
   {
	   $authService = new AuthService();
	   $utilisateurActif = $authService->getUtilisateur();

       $this->view('index.html.twig',  [
            'title' => 'Le site du BDE',
			'utilisateurActif' => $utilisateurActif
        ]);
   }
}
