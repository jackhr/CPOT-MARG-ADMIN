<?php

namespace Core;

class Router
{
    private $routes;
    private $groupPrefix;

    public function __construct()
    {
        $this->routes = [];
        $this->groupPrefix = '';
    }

    public function group($prefix, $callback)
    {
        $previousPrefix = $this->groupPrefix;
        $this->groupPrefix = $previousPrefix . $prefix;
        $callback($this);
        $this->groupPrefix = $previousPrefix;
    }

    public function get($path, $callback)
    {
        $this->routes['GET'][$this->groupPrefix . $path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$this->groupPrefix . $path] = $callback;
    }

    public function dispatch()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestMethod][$requestUri])) {
            $callback = $this->routes[$requestMethod][$requestUri];

            // If callback is an array (controller and method)
            if (is_array($callback) && count($callback) == 2) {

                // Instantiate the controller class and call the method
                list($controllerName, $methodName) = $callback;
                $controller = new $controllerName();
                $controller->$methodName();
            } elseif (is_callable($callback)) {

                // If it's a callable function
                call_user_func($callback);
            } else {
                header("HTTP/1.0 500 Internal Server Error");
                echo "Invalid route callback.";
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found brooooo";
        }
    }
}
