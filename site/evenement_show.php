<?php
require_once './app/controllers/EvenementController.php';
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    (new EvenementController())->showEvenement($id);

}
