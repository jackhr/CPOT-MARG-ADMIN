<?php

namespace App\Controllers;

class HttpErrorController
{
    public function render404Page()
    {
        require_once __DIR__ . "/../views/errors/404.php";
    }
}
