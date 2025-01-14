<?php

namespace App\Controllers;

use App\Helpers\GeneralHelper;
use App\Models\AddOn;

class AddOnController extends Controller
{
    private $addOnModel;
    private $helper;

    public function __construct()
    {
        $this->addOnModel = new AddOn();
        $this->helper = new GeneralHelper();
    }

    public function getAll()
    {
        $add_ons = $this->addOnModel->readAll("", "add_on_id");
        $this->helper->respondToClient($add_ons);
    }
}
