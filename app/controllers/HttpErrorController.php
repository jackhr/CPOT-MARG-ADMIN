<?php

namespace App\Controllers;

class HttpErrorController extends Controller
{
    public function render404Page()
    {
        $this->view("errors/404.php");
    }
}
