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
        $query = '
        select * from (
            select pc.category_id, c.title as category_title, p.id as post_id, p.title, p.description, p.view_count, p.created_at,
            row_number() over (
            partition by pc.category_id
            order by created_at desc, p.id desc
            ) as row_num
        from post_categories as pc
        inner join posts as p on pc.post_id = p.id
        inner join categories as c on pc.category_id = c.id
        ) as ranked where row_num <= 3;
        ';

        $results = DB::instance()->query($query);

        foreach ($results as $result) {
            $categoryId = $result['category_id'];

            if (!isset($categories[$categoryId])) {
                $categories[$categoryId] = [
                    'id' => $result['category_id'],
                    'title' => $result['category_title'],
                    'posts' => [
                        [
                            'id' => $result['post_id'],
                            'title' => $result['title'],
                            'description' => $result['description'],
                            'view_count' => $result['view_count'],
                            'created_at' => $result['created_at']
                        ]
                    ]
                ];
            } else {
                $categories[$categoryId]['posts'][] = [
                    'id' => $result['post_id'],
                    'title' => $result['title'],
                    'description' => $result['description'],
                    'view_count' => $result['view_count'],
                    'created_at' => $result['created_at']
                ];
            }
        }

        return $categories;
    }
}