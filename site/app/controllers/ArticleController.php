<?php

require_once './app/services/AuthService.php';
require_once './app/repositories/ArticleRepository.php';
require_once './app/repositories/SousArticleRepository.php';
require_once './app/core/Controller.php';
require_once './app/trait/FormTrait.php';

class ArticleController extends Controller{

    use FormTrait;

    public function index() {
        $this->checkAuth();
		
		$authService = new AuthService();
		$utilisateurActif = $authService->getUtilisateur();

        $articleRepo = new ArticleRepository();
        $sousArticleRepo = new SousArticleRepository();

        $sousArticles = $sousArticleRepo->findAll();
        //$articles = $articleRepo->findAll();

        var_dump($sousArticles);
        $this->view('/article/index.html.twig',  [
            
			'articles' => $sousArticles, 
			'isAdmin' => $utilisateurActif && $utilisateurActif->estAdmin(),
			'utilisateurActif' => $utilisateurActif
		]);
    }

    public function create() {
        $this->checkAuth();

		$authService = new AuthService();
		$utilisateurActif = $authService->getUtilisateur();

        $data = $this->getAllPostParams();
        $errors = [];

        if (!empty($data)) {
            try {

                $errors = [];

                // Validation des données
                if (empty($data['category_id'])) {
                    $errors[] = 'La catégorie est requise.';
                }
                if (empty($data['name'])) {
                    $errors[] = 'Le nom est requis.';
                }
                if (empty($data['price']) || $data['price'] <= 0) {
                    $errors[] = 'Le prix doit être supérieur à 0.';
                }
                if (empty($data['stock']) || $data['stock'] < 0) {
                    $errors[] = 'Le stock ne peut pas être négatif.';
                }

                if (!empty($errors)) {
                    throw new Exception(implode(', ', $errors));
                }

                //$article = new Article(
                //    null,
                //    $data['name'],
                //    (float)$data['price'],
                //    $data['description'] ?? '',
                //    (int)$data['stock']
                //);

                //$article->setCategory(new Category((int)$data['category_id'], ''));

                $repository = new ArticleRepository();
                //if (!$repository->create($article)) {
                 //   throw new Exception('Erreur lors de la création de l\'article.');
                //}

                $this->redirectTo('articles.php');
            } catch (Exception $e) {
                $errors = explode(', ', $e->getMessage());
            }
        }

        $this->view('/article/form.html.twig', [
            'categories' => $categories,
            'data' => $data,
            'errors' => $errors,
			'utilisateurActif' => $utilisateurActif
        ]);
    }

    private function checkAuth() {
        $auth = new AuthService();
        if (!$auth->isLoggedIn()) {
            $this->redirectTo('login.php');
        }
    }

    public function showArticle(int $id)
    {
        $articleRepo = new ArticleRepository();
        $article = $articleRepo->findById($id);
        if(!$article)
        {
            die("Article introuvable");
        }
        $this->view('/article/article_show.html.twig', ['article' => $article]);
    }
    

    /*public function update()
    {
        $this->checkAuth();

        $id = $this->getQueryParam('id');

        if ($id === null) {
            throw new Exception('Article ID is required.');
        }
        $repository = new ArticleRepository();
        $categoryRepo = new CategoryRepository();
        $article = $repository->findById($id);

        $category = $categoryRepo->findByArticle($article);
        $article->setCategory($category);

        if ($article === null) {
            throw new Exception('Article not found');
        }

        $data = array_merge([
            'name'=>$article->getName(),
            'stock'=>$article->getStock(),
            'price'=>$article->getPrice(),
            'description'=>$article->getDescription(),
            'category_id'=>$article->getCategory()->getId()
        ],$this->getAllPostParams()); //Get submitted data

        $categories =  $categoryRepo->findAll();

        $errors = [];

        if (!empty($this->getAllPostParams())) {
            try {

                $errors = [];

                // Validation des données
                if (empty($data['category_id'])) {
                    $errors[] = 'La catégorie est requise.';
                }
                if (empty($data['name'])) {
                    $errors[] = 'Le nom est requis.';
                }
                if (empty($data['price']) || $data['price'] <= 0) {
                    $errors[] = 'Le prix doit être supérieur à 0.';
                }
                if (empty($data['stock']) || $data['stock'] < 0) {
                    $errors[] = 'Le stock ne peut pas être négatif.';
                }

                if (!empty($errors)) {
                    throw new Exception(implode(', ', $errors));
                }

                $article = new Article(
                    null,
                    $data['name'],
                    (float)$data['price'],
                    $data['description'] ?? '',
                    (int)$data['stock']
                );

                $article->setCategory(new Category((int)$data['category_id'], ''));

                $repository = new ArticleRepository();
                if (!$repository->create($article)) {
                    throw new Exception('Erreur lors de la création de l\'article.');
                }

                $this->redirectTo('articles.php');
            } catch (Exception $e) {
                $errors = explode(', ', $e->getMessage());
            }
        }

        $this->view('/article/form.html.twig', [
            'categories' => $categories,
            'data' => $data,
            'errors' => $errors
        ]);
    }*/


}
