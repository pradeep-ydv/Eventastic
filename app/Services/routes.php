<?php

namespace App\Services;

class Route
{
    static $routes = [];
    private static $controllerNamespace = "App\Controllers\\";
    public static function add($url, $controller, $action, $method = "GET", $middleware = array())
    {

        self::$routes[] = [
            "method" => $method,
            "url" => $url,
            "controller" => $controller,
            "action" => $action,
            "middleware" => $middleware
        ];
    }

    public static function handle()
    {

        $requestURI = $_SERVER["REQUEST_URI"];
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        foreach (self::$routes as $route) {

            if ($route["url"] === $requestURI && $route["method"] === $requestMethod) {
                $controllerClass = self::$controllerNamespace . $route["controller"];
                $action = $route["action"];

                $controller = new $controllerClass();

                $controller->$route["method"];
                return;
            }
            echo "404 - Page not found";
        }
    }
}
