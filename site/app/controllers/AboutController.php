<?php

require_once './app/core/Controller.php';

class AboutController extends Controller
{
   public function index()
   {
        if(session_status() == PHP_SESSION_NONE)
           session_start();

       $this->view('/about/index.html.twig',  ['title' => 'Le site du BDE']);
   }
}
