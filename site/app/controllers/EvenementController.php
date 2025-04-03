<?php

require_once './app/services/AuthService.php';
require_once './app/core/Controller.php';
require_once './app/repositories/EvenementRepository.php';
require_once './app/trait/FormTrait.php';

class EvenementController extends Controller{

    //use FormTrait;

    public function index() {
        //$this->checkAuth();

		$authService = new AuthService();
		$utilisateurActif = $authService->getUtilisateur();

        $evenementRepo = new EvenementRepository();

        $evenements = $evenementRepo->findAll();


        $this->view('/evenement/index.html.twig',  [
			'evenements' => $evenements,
			'isAdmin' => $utilisateurActif && $utilisateurActif->estAdmin(),
			'utilisateurActif' => $utilisateurActif
		]);
    }

    private function checkAuth() {
        $auth = new AuthService();
        if (!$auth->isLoggedIn()) {
            $this->redirectTo('login.php');
        }
    }
    public function showEvenement(int $id)
    {
        $evenementRepo = new EvenementRepository();
        $evenement = $evenementRepo->findById($id);

        if (!$evenement) {
            die("Événement introuvable.");
        }

        $this->view('/evenement/evenement_show.html.twig', ['evenement' => $evenement]);
    }
	/*public function update()
    {
        $this->checkAuth();

        $id = $this->getQueryParam('id');

        if ($id === null) {
            throw new Exception('Evenement ID is required.');
        }
        $evenementRepo = new EvenementRepository();

        if ($evenement === null) {
            throw new Exception('Evenement not found');
        }

        $data = array_merge([
            'nom'=>$evenement->getNom(),
            'stock'=>$article->getStock(),
            'price'=>$article->getPrice(),
            'description'=>$article->getDescription(),
            'category_id'=>$article->getCategory()->getId()
        ],$this->getAllPostParams()); //Get submitted data


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