<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Database\DB;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

const MIN_CATEGORIES_PER_PAGE = 3;
const MAX_CATEGORIES_PER_PAGE = 10;

function seedCategories(): void
{
    $categories = include 'categories.php';

    $count = 0;
    foreach ($categories as $category)
    {
        $title = $category['title'];
        $description = $category['description'];
        if (DB::instance()->execute("insert into categories (title, description) values ('$title', '$description')")) {
            $count++;
        }
    }

    echo "Added $count categories." . PHP_EOL;
}

function seedPosts(): void
{
    $posts = include 'posts.php';

    $count = 0;
    foreach ($posts as $post)
    {
        $title = $post['title'];
        $content = $post['content'];
        $description = substr($content, 0, 100) . '...';
        $createdAt = randDate();
        $viewCount = random_int(0, 100);

        if (DB::instance()->execute("
            insert into posts (title, description, content, view_count, created_at) 
            values ('$title', '$description', '$content', '$viewCount', '$createdAt')"
        )) {
            $count++;
        }
    }

    echo "Added $count posts." . PHP_EOL;
}

function seedPostCategories(): void
{
    $posts = DB::instance()->query('select id from posts');
    $categories = DB::instance()->query('select id from categories');

    $postIds = [];
    foreach ($posts as $post) {
        $postIds[] = $post['id'];
    }

    $categoryIds = [];
    foreach ($categories as $category) {
        $categoryIds[] = $category['id'];
    }


    $postCount = 0;
    $categoryCount = 0;

    foreach ($postIds as $postId) {
        $selectedCategoryIds = pickRandomCategories($categoryIds);

        foreach ($selectedCategoryIds as $selectedCategoryId) {
            if (DB::instance()->execute("insert into post_categories (post_id, category_id) values ('$postId', '$selectedCategoryId')")) {
                $categoryCount++;
            }
        }
        $postCount++;
    }

    echo "Assigned $categoryCount categories to $postCount posts." . PHP_EOL;
}

function pickRandomCategories($categoryIds): array
{
    $count = random_int(MIN_CATEGORIES_PER_PAGE, MAX_CATEGORIES_PER_PAGE);
    $selectedIds = [];

    while (count($selectedIds) < $count) {
        $randIndex = random_int(0, count($categoryIds) - 1);
        $randCategoryId = $categoryIds[$randIndex];

        if (!in_array($randCategoryId, $selectedIds)) {
            $selectedIds[] = $randCategoryId;
        }
    }

    return $selectedIds;
}

function randDate(): string
{
    $from = (new DateTimeImmutable('2026-01-01'))->getTimestamp();
    $to = (new DateTimeImmutable('today'))->getTimestamp();

    return (new DateTimeImmutable())->setTimestamp(random_int($from, $to))->format('Y-m-d H:i:s');
}

seedCategories();
seedPosts();
seedPostCategories();