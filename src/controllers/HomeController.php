<?php
namespace src\controllers;

use core\BaseController;

session_start();
class HomeController extends BaseController{
    public function index(){
        unset($_SESSION["username"]);
        $notification = "";
        if (isset($_SESSION["notification"])){
            $notification = $_SESSION["notification"];
            $_SESSION["notification"] = "";
        }
        $title = "Login";
        $this->render("index.html.twig", ["title" => $title, "notification" => $notification]);
    }
}