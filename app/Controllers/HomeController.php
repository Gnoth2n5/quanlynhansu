<?php

namespace App\Controllers;

class HomeController extends Controller{
    public function home(){

        $this->render('welcome');
    }
}