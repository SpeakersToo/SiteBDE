<?php

require_once './app/core/Controller.php';

class ContactController extends Controller
{
   public function index()
   {
        if(session_status() == PHP_SESSION_NONE)
           session_start();

       $this->view('/contact/index.html.twig',  ['title' => 'Le site du BDE']);
   }
}
