<?php

namespace App\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\Sconce;

class SconceController extends Controller
{
    private $sconceModel;
    private $helper;

    public function __construct(GeneralHelper $helper)
    {
        $this->sconceModel = new Sconce();
        $this->helper = $helper;
    }

    public function listSconces()
    {
        $this->view("admin/sconces/list.php", [
            "user" => $_SESSION['user'],
            "sconces" => $this->sconceModel->readAll(),
            "title" => "Sconces"
        ]);
    }
}
