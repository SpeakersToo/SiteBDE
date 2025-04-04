<?php

require_once './app/services/AuthService.php';
require_once './app/services/EvenementService.php';
require_once './app/core/Controller.php';
require_once './app/repositories/EvenementRepository.php';
require_once './app/trait/FormTrait.php';

class EvenementController extends Controller{

    use FormTrait;

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

	public function create() 
	{
        //$this->checkAuth();

        $data = $this->getAllPostParams();
        $errors = [];

        if (!empty($data)) {
            try {
                $evenementService = new EvenementService();
                $evenementService->create($data);
                $this->redirectTo('evenements.php');
            } catch (Exception $e) {
                $errors = explode(', ', $e->getMessage());
            }
        }

		//var_dump($data); // array(0) { }  

        $this->view('/evenement/evenement_create.html.twig', [
            'data' => $data,
            'errors' => $errors,
			'title' => 'Création d\'un événement'
        ]);
    }

	public function delete()
	{
		$id = $this->getQueryParam('id');
	
		if ($id === null) {
			throw new Exception('Evenement ID is required.');
		}
	
		$repository = new EvenementRepository();
		$evenement = $repository->findById($id);
	
		if ($evenement === null) {
			throw new Exception('Evenement not found');
		}

	
		if (!$repository->delete($id)) {
			throw new Exception('Error deleting the evenement.');
		}
	
		$this->redirectTo('evenements.php');
	}
}