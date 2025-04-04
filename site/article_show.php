<?php
require_once './app/controllers/ArticleController.php';
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    (new ArticleController())->showArticle($id);

}