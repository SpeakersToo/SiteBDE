<?php

require_once './app/core/Controller.php';
require_once './app/services/AuthService.php';

class AboutController extends Controller
{
   public function index()
   {
        if(session_status() == PHP_SESSION_NONE)
           session_start();

		$authService = new AuthService();
		$utilisateurActif = $authService->getUtilisateur();

       $this->view('/about/index.html.twig',  ['title' => 'Le site du BDE', 'utilisateurActif' => $utilisateurActif,]);
   }
}
