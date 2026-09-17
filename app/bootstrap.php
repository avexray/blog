<?php

use App\Controllers\CategoriesController;
use App\Controllers\ErrorController;
use App\Controllers\PostsController;
use App\Engine;
use App\ServiceContainer;
use App\Controllers\HomeController;
use App\Database\{CategoriesRepository, PostsRepository};
use App\Renderers\{Renderer, SmartyRenderer};

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$container = new ServiceContainer();

$container->singleton(Renderer::class, function (ServiceContainer $c) {
    return new SmartyRenderer();
});

$container->singleton(CategoriesRepository::class, function (ServiceContainer $container) {
    return new CategoriesRepository();
});

$container->singleton(PostsRepository::class, function (ServiceContainer $container) {
    return new PostsRepository();
});

$container->singleton(HomeController::class, function (ServiceContainer $container) {
    return new HomeController(
        $container->get(Renderer::class),
        $container->get(CategoriesRepository::class)
    );
});

$container->singleton(CategoriesController::class, function (ServiceContainer $container) {
    return new CategoriesController(
        $container->get(Renderer::class),
        $container->get(PostsRepository::class),
        $container->get(CategoriesRepository::class)
    );
});

$container->singleton(PostsController::class, function (ServiceContainer $container) {
    return new PostsController(
        $container->get(Renderer::class),
        $container->get(PostsRepository::class)
    );
});

$container->singleton(ErrorController::class, function (ServiceContainer $container) {
    return new ErrorController($container->get(Renderer::class));
});

$engine = new Engine($container);

$engine->run();