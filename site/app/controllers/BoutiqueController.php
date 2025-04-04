<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ArticleRepository.php';
require_once './app/repositories/SousArticleRepository.php';
require_once './app/services/AuthService.php';

class BoutiqueController extends Controller
{
	public function index()
	{
		$articleRepo = new ArticleRepository();
		$articles = $articleRepo->findAll();
	
		$saRepo = new SousArticleRepository();
		$sousArticles = $saRepo->findAll();
	
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
	
		$authService = new AuthService();
		$utilisateurActif = $authService->getUtilisateur();

		$articlesSousArticles = [];
	
		foreach ($articles as $article) {
			$articlesSousArticles[$article->getId()] = $saRepo->findByArticleId($article->getId());
		}
	
		$this->view('/boutique/index.html.twig', [
			'title' => 'Le site du BDE',
			'articles' => $articles,
			'articlesSousArticles' => $articlesSousArticles,
			'isAdmin' => $utilisateurActif && $utilisateurActif->estAdmin(),
			'utilisateurActif' => $utilisateurActif
		]);
	}
}
