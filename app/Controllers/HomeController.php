<?php

namespace App\Controllers;

use App\Database\CategoriesRepository;
use App\Renderers\Renderer;

class HomeController extends Controller
{
    private readonly CategoriesRepository $categoriesRepository;

    public function __construct(Renderer $renderer)
    {
        parent::__construct($renderer);

        $this->categoriesRepository = new CategoriesRepository();
    }

    public function index()
    {
        $categories = $this->categoriesRepository->getCategoriesWithLatestPosts();

        $this->renderer->view('index.tpl', [
            'categories' => $categories
        ]);
    }
}