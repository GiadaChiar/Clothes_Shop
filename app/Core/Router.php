<?php

namespace App\Core;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => [],
    ];

    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function put($uri, $action)
    {
        $this->routes['PUT'][$uri] = $action;
    }

    public function delete($uri, $action)
    {
        $this->routes['DELETE'][$uri] = $action;
    }

    public function dispatch(string $uri, $db): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        $uri = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes[$method] as $route => $action) {

            $pattern = preg_replace('#\{[\w]+\}#', '(\d+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {

                array_shift($matches);

                [$controllerClass, $methodName] = $action;

                $controller = new $controllerClass($db);

                call_user_func_array([$controller, $methodName], $matches);

                return;
            }
        }

        http_response_code(404);
        echo json_encode([
            "success" => false,
            "error" => "Route not found"
        ]);
    }
}
