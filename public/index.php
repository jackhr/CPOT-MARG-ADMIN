<?php
require_once __DIR__ . '/../app/core/bootstrap.php';

use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;
use App\Core\Router;

$router = new Router();

// Public routes
$router->get('/', function () {
    echo "Welcome to the Home Page!";
});

$router->get('/users', function () {
    $userController = new UserController();
    $userController->listUsers();  // List all users
});

$router->group('/admin', function (Router $router) {
    $router->get('/login', function () {
        require_once __DIR__ . '/../app/views/admin/login.php';
    });

    $router->post('/login', function () {
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $password = htmlspecialchars(strip_tags($_POST['password']));

        $userController = new UserController();
        $userController->login($email, $password);
    });
});

$router->group('/admin', function (Router $router) {
    $router->get('/dashboard', [UserController::class, 'index']);
    $router->get('/logout', [UserController::class, 'logout']);
    $router->get('/users', [UserController::class, 'listUsers']);
}, [AuthMiddleware::class]);

// Dispatch the request to the appropriate route
$router->dispatch();
