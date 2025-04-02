<?php

require_once './app/core/Controller.php';
require_once './app/repositories/ArticleRepository.php';
require_once './app/repositories/CategoryRepository.php';
require_once './app/services/AuthService.php';

class BoutiqueController extends Controller
{
   public function index()
   {

	
		$articleRepo = new ArticleRepository();
		//$categoryRepo = new CategoryRepository();

		$articles = $articleRepo->findAll();

		/*foreach ($articles as $article) {
			$category = $categoryRepo->findByArticle($article);
			$article->setCategory($category);
		}*/

        if(session_status() == PHP_SESSION_NONE)
           session_start();

		$authService = new AuthService();
		$utilisateurActif = $authService->getUtilisateur();

       $this->view('/boutique/index.html.twig',  ['title' => 'Le site du BDE',
												  'articles' => $articles,
												  'isAdmin' => $utilisateurActif && $utilisateurActif->estAdmin(),
												  'utilisateurActif' => $utilisateurActif]);
   }
}
