<?php

namespace App\Database;

class CategoriesRepository
{
    public function getCategories(): array
    {
        return DB::instance()->query('select * from categories');
    }

    public function getCategoriesWithLatestPosts(): array
    {
        return DB::instance()->query('
            select categories.id as category_id, categories.title as category_title, posts.id as post_id,
            posts.title as post_title
            from categories
            inner join post_categories pcj on categories.id = pcj.category_id
            inner join posts on posts.id = pcj.post_id order by created_at desc
        ');
    }
}