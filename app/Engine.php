<?php

namespace App;

use App\Exceptions\HttpNotFoundException;
use App\Controllers\{CategoriesController, ErrorController, HomeController, PostsController};

readonly class Engine
{
    /**
     * @var Route[]
     */
    private array $routes;

    public function __construct(private readonly ServiceContainer $container)
    {
        $this->routes = [
            new Route('/', 'GET', HomeController::class, 'index'),
            new Route('/categories', 'GET', CategoriesController::class, 'view'),
            new Route('/posts', 'GET', PostsController::class, 'view'),
        ];
    }

    public function run(): void
    {
        $route = $this->findRoute();

        try {
            if ($route) {
                $this->generateResponse($route);
            } else {
                throw new HttpNotFoundException();
            }
        }
        catch (\Exception $e) {
            $errorController = $this->container->get(ErrorController::class);

            $message = $e->getMessage();
            $code = $e->getCode();

            if ($e instanceof \PDOException) {
                $message = 'Database Connection Error';
                $code = 500;
            }
            $errorController->error($message, $code);
        }
    }

    private function generateResponse(Route $route): void
    {
        $controllerName = $route->getController();
        $functionName = $route->getFunction();

        $controller = $this->container->get($controllerName);
        $controller->$functionName();
    }

    private function findRoute(): Route|null
    {
        $path = $this->getPath();
        $method = $_SERVER['REQUEST_METHOD'];

        $route = null;
        for ($i = 0; $i < count($this->routes) && !$route; $i++) {
            $currentRoute = $this->routes[$i];
            if ($currentRoute->getHttpPath() === $path && $currentRoute->getHttpMethod() == $method) {
                $route = $currentRoute;
            }
        }
        return $route;
    }

    private function getPath(): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $length = strlen($path);

        if ($length > 1 && str_ends_with($path, '/')) {
            $path = substr($path, 0, $length - 1);
        }
        return $path;
    }
}