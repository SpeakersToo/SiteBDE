<?php

require_once './app/core/Controller.php';
require_once './app/services/AuthService.php';

class HomeController extends Controller
{
   public function index()
   {
        if(session_status() == PHP_SESSION_NONE)
           session_start();

       $this->view('index.html.twig',  ['title' => 'Le site du BDE']);
   }

}
