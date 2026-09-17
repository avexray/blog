<?php

namespace App\Database;

class PostsRepository
{
    public function getPost(string $postId): array
    {
        $query = '
            select posts.id, posts.title, posts.content, posts.view_count, posts.created_at, 
                   categories.title as category_title, categories.id as category_id
            from posts 
            inner join post_categories on posts.id = post_categories.post_id 
            inner join categories on categories.id = post_categories.category_id
            where posts.id = :post_id
        ';

        $postResults = DB::instance()->query($query, [
            'post_id' => $postId
        ]);

        $post = [];

        foreach ($postResults as $postResult) {
            if (!isset($post['id'])) {
                $post['id'] = $postResult['id'];
                $post['title'] = $postResult['title'];
                $post['content'] = $postResult['content'];
                $post['view_count'] = $postResult['view_count'];
                $post['created_at'] = $postResult['created_at'];
            } else {
                $post['categories'][] = [
                    'id' => $postResult['category_id'],
                    'title' => $postResult['category_title'],
                ];
            }
        }

        return $post;
    }

    public function getPostRecommendations(string $postId) : array
    {
        $query = '
            select posts.id as id, posts.title as title, posts.description as description, posts.view_count as view_count, posts.created_at as created_at
            from post_categories
            inner join posts on post_categories.post_id = posts.id
            where post_categories.category_id in (select post_categories.category_id from post_categories where post_categories.post_id = :post_id)
            and posts.id != :post_id
            limit 3
        ';

        return DB::instance()->query($query, [
            'post_id' => $postId
        ]);
    }

    public function getPostsByCategory(string $categoryId, string $orderBy, int $limit, int $offset): array
    {
        $query = "
            select posts.id, posts.title, posts.description, posts.view_count, posts.created_at 
            from posts 
            inner join post_categories on posts.id = post_categories.post_id 
            where post_categories.category_id = :category_id
        ";

        if ($orderBy === 'created_at') {
            $query .= ' order by created_at desc';
        } else if ($orderBy === 'view_count') {
            $query .= ' order by view_count desc';
        }

        $query .= ' limit ' . $limit;
        $query .= ' offset ' . $offset;

        return DB::instance()->query($query, [
            'category_id' => $categoryId
        ]);
    }
}
