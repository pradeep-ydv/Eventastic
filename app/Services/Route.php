<?php

namespace App\Services;

class Route
{
    private static $routes = [];
    private static $middlewareGroups = [];
    private static $controllerNamespace = "App\Controllers\\";
    private static $patterns = [
        '{id}' => '(\d+)',
        '{slug}' => '([a-zA-Z0-9-_]+)'
    ];

    public static function add($uri, $controller, $action, $method = "GET", $middleware = [])
    {
        // Replace placeholders with regex patterns
        foreach (self::$patterns as $placeholder => $pattern) {
            $uri = str_replace($placeholder, $pattern, $uri);
        }

        self::$routes[] = [
            "method" => $method,
            "uri" => "#^" . $uri . "$#",
            "controller" => $controller,
            "action" => $action,
            "middleware" => $middleware
        ];
    }

    // Methods to simplify route definitions
    public static function get($uri, $controller, $action, $middleware = [])
    {
        self::add($uri, $controller, $action, "GET", $middleware);
    }

    public static function post($uri, $controller, $action, $middleware = [])
    {
        self::add($uri, $controller, $action, "POST", $middleware);
    }

    public static function group($middleware, $callback)
    {
        self::$middlewareGroups[] = $middleware;
        call_user_func($callback);
        array_pop(self::$middlewareGroups);
    }

    private static function applyMiddleware($routeMiddleware)
    {
        foreach (self::$middlewareGroups as $groupMiddleware) {
            foreach ($groupMiddleware as $middleware) {
                $routeMiddleware[] = $middleware;
            }
        }
        return $routeMiddleware;
    }

    public static function handle()
    {
        $requestURI = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        foreach (self::$routes as $route) {
            if (preg_match($route["uri"], $requestURI, $matches) && $route["method"] === $requestMethod) {
                array_shift($matches); // Remove the full match from the array
                $controllerClass = self::$controllerNamespace . $route["controller"];
                $action = $route["action"];

                $routeMiddleware = self::applyMiddleware($route["middleware"]);

                // Run middleware if any
                foreach ($routeMiddleware as $middleware) {
                    if (class_exists($middleware)) {
                        $middlewareInstance = new $middleware();
                        $middlewareInstance->handle();
                    }
                }

                // Call the controller action with any matched parameters
                $controller = new $controllerClass();
                call_user_func_array([$controller, $action], $matches);
                return;
            }
        }
        http_response_code(404);
        echo "404 - Page not found";
    }
}
