<?php

namespace App\Controllers;

class PostsController extends Controller
{
    public function view()
    {
        $this->renderer->view('post.tpl');
    }
}