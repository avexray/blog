<?php

namespace App\Controllers;

use App\Database\PostsRepository;
use App\Exceptions\HttpNotFoundException;
use App\Renderers\Renderer;

class PostsController extends Controller
{
    public function __construct(
        Renderer $renderer,
        private readonly PostsRepository $postsRepository
    )
    {
        parent::__construct($renderer);
    }

    public function view()
    {
        $postId = $_GET['id'];

        if (!$postId) {
            throw new HttpNotFoundException();
        }

        $post = $this->postsRepository->getPost($postId);

        if (empty($post)) {
            throw new HttpNotFoundException();
        }
        $recommendedPosts = $this->postsRepository->getPostRecommendations($postId);

        $this->renderer->view('post.tpl', [
            'post' => $post,
            'recommendedPosts' => $recommendedPosts
        ]);
    }
}