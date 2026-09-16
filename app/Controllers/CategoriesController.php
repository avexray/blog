<?php

namespace App\Controllers;

class CategoriesController extends Controller
{
    public function view()
    {
        $this->renderer->view('category.tpl');
    }
}