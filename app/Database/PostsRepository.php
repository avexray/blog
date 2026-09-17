<?php

namespace App\Database;

class PostsRepository
{
    public function getPost(int $postId): array
    {
        return DB::instance()->query('select * from posts where id = :post_id', [
            'post_id' => $postId
        ]);
    }

    public function getPostsByCategory(int $categoryId): array
    {
        $query = '
            select * from posts 
            inner join post_categories on posts.id = post_categories.post_id 
            where post_categories.category_id = :category_id
        ';

        return DB::instance()->query($query, [
            'category_id' => $categoryId
        ]);
    }
}
