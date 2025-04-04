<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ArticleRepository.php';
require_once './app/services/AuthService.php';

class BoutiqueController extends Controller
{
   public function index()
   {


	$articleRepo = new ArticleRepository();

	$articles = $articleRepo->findAll();

	if(session_status() == PHP_SESSION_NONE)
		session_start();


	foreach ($articles as $article) {;
		var_dump($article->getSousArticles()); // Affiche tous les sous-articles pour chaque article
	}
	$authService = new AuthService();
	$utilisateurActif = $authService->getUtilisateur();
	$this->view('/boutique/index.html.twig',  ['title' => 'Le site du BDE',
												'articles' => $articles,
												'isAdmin' => $utilisateurActif && $utilisateurActif->estAdmin(),
												'utilisateurActif' => $utilisateurActif]);
	}
}
