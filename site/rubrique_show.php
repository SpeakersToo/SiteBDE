<?php
require_once './app/controllers/RubriqueController.php';
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    (new RubriqueController())->showRubrique($id);

    
}
