<?php

namespace App\core;

class Router {
    private array $routes = [];

    public function addRoute(string $method, string $path, array $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function route() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                $controller = new $route['handler'][0];
                $action = $route['handler'][1];
                return $controller->$action();
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Route non trouvée']);
    }
}