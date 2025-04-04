<?php

require_once './app/core/Controller.php';
require_once './app/services/AuthService.php';

class ContactController extends Controller
{
   public function index()
   {
        if(session_status() == PHP_SESSION_NONE)
           session_start();

		$authService = new AuthService();
		$utilisateurActif = $authService->getUtilisateur();

       $this->view('/contact/index.html.twig',  [
		'title' => 'Le site du BDE',
		'isAdmin' => $utilisateurActif && $utilisateurActif->estAdmin(),
		'utilisateurActif' => $utilisateurActif
	]);
   }
}
