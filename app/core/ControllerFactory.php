<?php

namespace App\Core;

use App\Controllers\CutoutController;
use App\Controllers\UserController;
use App\Controllers\HttpErrorController;
use App\Controllers\OrderController;
use App\Controllers\RoleController;
use App\Controllers\SconceController;
use App\Controllers\UniqueCeramicController;
use App\Helpers\GeneralHelper;
use Exception;

class ControllerFactory
{
    public static function create($controllerName)
    {
        switch ($controllerName) {
            case OrderController::class:
                return new OrderController();
            case CutoutController::class:
                return new CutoutController();
            case UniqueCeramicController::class:
                return new UniqueCeramicController(new GeneralHelper());
            case SconceController::class:
                return new SconceController(new GeneralHelper());
            case RoleController::class:
                return new RoleController(new GeneralHelper());
            case UserController::class:
                return new UserController(new GeneralHelper());
            case HttpErrorController::class:
                return new HttpErrorController();
            default:
                throw new Exception("Controller not found: $controllerName");
        }
    }
}
