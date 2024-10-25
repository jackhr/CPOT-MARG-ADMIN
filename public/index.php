<?php
require_once __DIR__ . '/../app/core/bootstrap.php';

use App\Controllers\UserController;
use App\Core\ControllerFactory;
use App\Middleware\AuthMiddleware;
use App\Core\Router;
use App\Helpers\GeneralHelper;

$helper = new GeneralHelper();
$router = new Router($helper);

$router->group('/', function (Router $router) {
    $router->get('', function () use ($router) {
        session_start();
        if (isset($_SESSION['user'])) {
            $router->redirect("/dashboard");
        } else {
            require_once __DIR__ . '/../app/views/admin/login.php';
        }
    });

    $router->post('login', function () {
        $email = htmlspecialchars(strip_tags($_POST['email']));
        $password = htmlspecialchars(strip_tags($_POST['password']));

        $userController = ControllerFactory::create(UserController::class);
        $userController->login($email, $password);
    });
});

$router->group('/', function (Router $router) {
    $router->get('dashboard', [UserController::class, 'index']);
    $router->get('logout', [UserController::class, 'logout']);
    $router->get('users', [UserController::class, 'listUsers']);
}, [AuthMiddleware::class]);

// Dispatch the request to the appropriate route
$router->dispatch();
