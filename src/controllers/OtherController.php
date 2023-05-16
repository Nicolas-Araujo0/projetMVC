<?php

namespace src\controllers;

use core\BaseController;
use src\models\Other;

class OtherController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Other;
    }
    public function getLogs(){
        $response = $this->model->getLogs();
        if (!empty($response)){
            $title = "Logs";
            $name = $_SESSION["username"];
            $this->render("logs.html.twig", array("title" => $title, "name" => $name, "logs" => $response));
        }
    }
}
