<?php
require_once __DIR__ . '/../app/core/bootstrap.php';

use App\Controllers\AddOnController;
use App\Controllers\CutoutController;
use App\Controllers\ShopItemController;
use App\Controllers\OrderController;
// use App\Controllers\RoleController;
use App\Controllers\SconceController;
use App\Controllers\OneOfAKindController;
use App\Controllers\UserController;
use App\Core\ControllerFactory;
use App\Middleware\AuthMiddleware;
use App\Core\Router;
use App\Helpers\GeneralHelper;
use App\Middleware\AdminMiddleware;

$helper = new GeneralHelper();
$router = new Router($helper);

$router->group('/', function (Router $router) {
    $router->get('', function () use ($router) {
        if (session_status() == PHP_SESSION_NONE) session_start();
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

    $router->group('users', function (Router $router) {
        $router->get('', [UserController::class, 'listUsers']);
        $router->post('', [UserController::class, 'create']);
        $router->put('/{id}', [UserController::class, 'update']);
        $router->delete('/{id}', [UserController::class, 'delete']);
    }, [AdminMiddleware::class]);

    // $router->group('roles', function (Router $router) {
    //     $router->get('', [RoleController::class, 'listRoles']);
    //     $router->post('', [RoleController::class, 'create']);
    //     $router->put('/{id}', [RoleController::class, 'update']);
    //     $router->delete('/{id}', [RoleController::class, 'delete']);
    // }, [AdminMiddleware::class]);

    $router->group('shop_items', function (Router $router) {
        $router->get('', [ShopItemController::class, 'listShopItems']);
        $router->get('/getAll', [ShopItemController::class, 'getAll']);
        $router->post('', [ShopItemController::class, 'create']);
        $router->post('/{id}/images', [ShopItemController::class, 'updateImages']);
        $router->put('/{id}', [ShopItemController::class, 'update']);
        $router->put('/{id}/restore', [ShopItemController::class, 'restore']);
        $router->delete('/{id}', [ShopItemController::class, 'delete']);
    });

    $router->group('sconces', function (Router $router) {
        $router->get('', [SconceController::class, 'listSconces']);
        $router->get('/cutouts', [SconceController::class, 'getCutouts']);
        $router->get('/getAll', [SconceController::class, 'getAll']);
        $router->post('', [SconceController::class, 'create']);
        $router->post('/{id}/images', [SconceController::class, 'updateImages']);
        $router->put('/{id}', [SconceController::class, 'update']);
        $router->put('/{id}/restore', [SconceController::class, 'restore']);
        $router->delete('/{id}', [SconceController::class, 'delete']);
    });

    $router->group('one-of-a-kind', function (Router $router) {
        $router->get('', [OneOfAKindController::class, 'listOneOfAKinds']);
        $router->get('/getAll', [OneOfAKindController::class, 'getAll']);
        $router->post('', [OneOfAKindController::class, 'create']);
        $router->post('/{id}/images', [OneOfAKindController::class, 'updateImages']);
        $router->put('/{id}', [OneOfAKindController::class, 'update']);
        $router->put('/{id}/restore', [OneOfAKindController::class, 'restore']);
        $router->delete('/{id}', [OneOfAKindController::class, 'delete']);
    });

    $router->group('cutouts', function (Router $router) {
        $router->get('', [CutoutController::class, 'listCutouts']);
        $router->get('/getAll', [CutoutController::class, 'getAll']);
        $router->post('', [CutoutController::class, 'create']);
        $router->post('/{id}/images', [CutoutController::class, 'updateImages']);
        $router->put('/{id}', [CutoutController::class, 'update']);
        $router->put('/{id}/restore', [CutoutController::class, 'restore']);
        $router->delete('/{id}', [CutoutController::class, 'delete']);
    });

    $router->group('orders', function (Router $router) {
        $router->get('', [OrderController::class, 'listOrders']);
        $router->get('/getAll', [OrderController::class, 'getAll']);
        $router->post('', [OrderController::class, 'create']);
        $router->put('/{id}/status', [OrderController::class, 'updateStatus']);
    });

    $router->group('add-ons', function (Router $router) {
        $router->get('/getAll', [AddOnController::class, 'getAll']);
    });
}, [AuthMiddleware::class]);

// Dispatch the request to the appropriate route
$router->dispatch();
