<?php

require_once './app/core/Controller.php';
require_once './app/entities/Purchase.php';
require_once './app/repositories/ArticleRepository.php';
require_once './app/repositories/CategoryRepository.php';
require_once './app/trait/FormTrait.php';
require_once './app/services/AuthService.php';

class HomeController extends Controller
{
   use FormTrait;
   public function index()
   {
       $articleRepo = new ArticleRepository();
       $categoryRepo = new CategoryRepository();

       $articles = $articleRepo->findAll();

       foreach ($articles as $article) {
           $category = $categoryRepo->findByArticle($article);
           $article->setCategory($category);
       }

        if(session_status() == PHP_SESSION_NONE)
           session_start();

       $this->view('index.html.twig',  [
            'title' => 'Le site du BDE',
            'articles' => $articles,
            'purchases'=> array_map(static fn(string $purchase) => unserialize($purchase),$_SESSION['purchases']??[])
        ]);
   }

   public function purchase()
   {
       $articleRepo = new ArticleRepository();
       $article = $articleRepo->findById($this->getQueryParam('article_id'));

       $authService = new AuthService();
       $purchase = new Purchase(null,$article,$authService->getUser(),$this->getPostParam('quantity'));

       if(session_status() == PHP_SESSION_NONE)
           session_start();

       if(!isset($_SESSION['purchases']))
       {
           $_SESSION['purchases']=[];
       }

       $_SESSION['purchases'][] = serialize($purchase);

       $this->redirectTo('index.php');
   }
}
