<?php

require_once './app/core/Controller.php';
require_once './app/repositories/EvenementRepository.php';
require_once './app/trait/FormTrait.php';


class EvenementController extends Controller{

    use FormTrait;

    public function index() {
        $this->checkAuth();

        $evenementRepo = new EvenementRepository();

        $evenements = $evenementRepo->findAll();


        $this->view('/evenements/index.html.twig',  ['evenements' => $evenements]);
    }

    private function checkAuth() {
        $auth = new AuthService();
        if (!$auth->isLoggedIn()) {
            $this->redirectTo('login.php');
        }
    }
}