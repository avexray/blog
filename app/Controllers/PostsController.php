<?php

namespace App\Controllers;

use App\Database\PostsRepository;
use App\Exceptions\HttpNotFoundException;
use App\Renderers\Renderer;

class PostsController extends Controller
{
    private readonly PostsRepository $postsRepository;

    public function __construct(Renderer $renderer)
    {
        parent::__construct($renderer);
        $this->postsRepository = new PostsRepository();
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