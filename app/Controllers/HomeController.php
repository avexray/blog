<?php

namespace App\Controllers;

use App\Database\CategoriesRepository;
use App\Renderers\Renderer;

class HomeController extends Controller
{
    public function __construct(Renderer $renderer, private readonly CategoriesRepository $categoriesRepository)
    {
        parent::__construct($renderer);
    }

    public function index()
    {
        $categories = $this->categoriesRepository->getCategoriesWithLatestPosts();

        $this->renderer->view('index.tpl', [
            'categories' => $categories
        ]);
    }
}