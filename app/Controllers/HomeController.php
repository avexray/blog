<?php

namespace App\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $this->renderer->view('index.tpl');
    }
}