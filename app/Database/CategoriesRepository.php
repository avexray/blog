<?php

namespace App\Database;

class CategoriesRepository
{
    public function getCategory(string $categoryId): array|null
    {
        $query = '
            select *, (
                select count(*) 
                from posts 
                inner join post_categories on post_categories.category_id = :category_id
                where posts.id = post_categories.post_id
            ) as post_count
            from categories 
            where id = :category_id
        ';

        $results = DB::instance()->query($query, [
            'category_id' => $categoryId
        ]);

        return count($results) ? $results[0] : null;
    }

    public function getCategoriesWithLatestPosts(): array
    {
        $results = DB::instance()->query('
            select categories.id as category_id, categories.title as category_title,
                   posts.id as post_id, posts.title as post_title,
                   posts.description as post_description,
                   posts.view_count as view_count,
                   posts.created_at as post_created_at
            from categories
            inner join post_categories pcj on categories.id = pcj.category_id
            inner join posts on posts.id = pcj.post_id order by created_at desc
        ');

        $categories = [];

        foreach ($results as $result) {
            $categoryId = $result['category_id'];

            if (!isset($categories[$categoryId])) {
                $categories[$categoryId] = [
                    'id' => $result['category_id'],
                    'title' => $result['category_title'],
                    'posts' => [
                        [
                            'id' => $result['post_id'],
                            'title' => $result['post_title'],
                            'description' => $result['post_description'],
                            'view_count' => $result['view_count'],
                            'created_at' => $result['post_created_at']
                        ]
                    ]
                ];
            } else {
                $categories[$categoryId]['posts'][] = [
                    'id' => $result['post_id'],
                    'title' => $result['post_title'],
                    'description' => $result['post_description'],
                    'view_count' => $result['view_count'],
                    'created_at' => $result['post_created_at']
                ];
            }
        }

        return $categories;
    }
}