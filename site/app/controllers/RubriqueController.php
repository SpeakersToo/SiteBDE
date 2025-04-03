<?php

require_once './app/services/AuthService.php';
require_once './app/core/Controller.php';
require_once './app/repositories/RubriqueRepository.php';
require_once './app/trait/FormTrait.php';


class RubriqueController extends Controller{

    //use FormTrait;

    public function index() {
        //$this->checkAuth();

        $rubriqueRepo = new RubriqueRepository();

        $rubriques = $rubriqueRepo->findAll();


        $this->view('/rubrique/index.html.twig',  ['rubriques' => $rubriques]);
    }

    private function checkAuth() {
        $auth = new AuthService();
        if (!$auth->isLoggedIn()) {
            $this->redirectTo('login.php');
        }
    }

    public function showRubrique(int $id)
    {
        $rubriqueRepo = new RubriqueRepository();
        $rubrique = $rubriqueRepo->findById($id);

        if (!$rubrique) 
		{
            die("Rubrique introuvable.");
        }

        $this->view('/rubrique/rubrique_show.html.twig', ['rubrique' => $rubrique]);
    }
}