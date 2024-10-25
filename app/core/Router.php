<?php

namespace App\Core;

use App\Controllers\HttpErrorController;
use App\Helpers\GeneralHelper;

class Router
{
    private $routes;
    private $groupPrefix;
    private $middlewareStack;
    private $helper;

    public function __construct()
    {
        $this->routes = [];
        $this->groupPrefix = '';
        $this->middlewareStack = [];
        $this->helper = new GeneralHelper();
    }

    // redirects to the desired location
    public function redirect($location)
    {
        header("Location: $location");
        exit();
    }

    // Add middleware to the middleware stack
    public function middleware($middleware)
    {
        if (is_array($middleware)) {
            $this->middlewareStack = array_merge($this->middlewareStack, $middleware);
        } else {
            $this->middlewareStack[] = $middleware;
        }
    }

    public function group($prefix, $callback, $middleware = [])
    {
        // Save the current prefix and middleware stack
        $previousPrefix = $this->groupPrefix;
        $previousMiddleware = $this->middlewareStack;

        // $this->helper->dd([$previousPrefix, $prefix]);

        // Update prefix and merge new middleware with current stack
        $this->groupPrefix = $previousPrefix . $prefix;

        // Add any middleware provided for this group
        if (!empty($middleware)) {
            $this->middlewareStack = array_merge($this->middlewareStack, $middleware);
        }

        // Call the callback, which adds routes to the group
        $callback($this);

        // Restore previous prefix and middleware stack after group is done
        $this->groupPrefix = $previousPrefix;
        $this->middlewareStack = $previousMiddleware;
    }


    public function get($path, $callback)
    {
        $this->routes['GET'][$this->groupPrefix . $path] = [
            'callback' => $callback,
            'middleware' => $this->middlewareStack
        ];
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$this->groupPrefix . $path] = [
            'callback' => $callback,
            'middleware' => $this->middlewareStack
        ];
    }

    public function dispatch()
    {
        $requestUri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $requestUri = $requestUri === '' ? '/' : $requestUri;
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestMethod][$requestUri])) {
            $route = $this->routes[$requestMethod][$requestUri];
            $callback = $route['callback'];
            $middleware = array_merge($this->middlewareStack, $route['middleware']);


            // Run through middleware stack before calling the callback
            foreach ($middleware as $middlewareClass) {
                $middlewareInstance = new $middlewareClass();

                if (!$middlewareInstance->handle()) {
                    // If middleware returns false, stop further processing
                    $this->helper->dd('yup');
                    return;
                }
            }

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
            $controller = new HttpErrorController();
            $controller->render404Page();
        }
    }
}
