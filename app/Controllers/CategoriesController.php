<?php

namespace App\Controllers;

use App\Database\CategoriesRepository;
use App\Database\PostsRepository;
use App\Renderers\Renderer;

class CategoriesController extends Controller
{
    private readonly PostsRepository $postsRepository;
    private readonly CategoriesRepository $categoriesRepository;

    const POSTS_PER_PAGE = 5;

    public function __construct(Renderer $renderer)
    {
        parent::__construct($renderer);

        $this->postsRepository = new PostsRepository();
        $this->categoriesRepository = new CategoriesRepository();
    }

    public function view()
    {
        $categoryId = (int) ($_GET['id'] ?? 0);
        $orderBy = $_GET['order'] ?? 'created_at';
        $page = max(1, (int)($_GET['page'] ?? 1));

        $category = $this->categoriesRepository->getCategory($categoryId);

        $pagesCount = (int)ceil($category['post_count'] / self::POSTS_PER_PAGE);

        if ($page > $pagesCount && $pagesCount > 0) {
            throw new \Exception('Page not found');
        }

        $offset = ($page - 1) * self::POSTS_PER_PAGE;

        $posts = $this->postsRepository->getPostsByCategory(
            $categoryId,
            $orderBy,
            self::POSTS_PER_PAGE,
            $offset
        );

        $this->renderer->view('category.tpl', [
            'category' => $category,
            'posts' => $posts,
            'pagesCount' => $pagesCount,
            'page' => $page,
            'orderBy' => $orderBy,
        ]);
    }
}