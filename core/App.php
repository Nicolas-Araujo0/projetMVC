<?php

namespace core;

use src\controllers\HomeController;
use src\controllers\ProductController;
use src\controllers\UserController;


class App
{
    public function run()
    {
        $uri = strtok($_SERVER["REQUEST_URI"], "?");
        if ($uri == "/" || $uri == "/index") {
            $controller = new HomeController();
            $controller->index();
        } else if ($uri == "/login") {
            $controller = new UserController();
            $controller->login();
        }
        if (isset($_SESSION["username"])) {
            if ($uri == "/products" && isset($_GET["searchBar"])) {
                $controller = new ProductController();
                $controller->searchDB();
            } else if ($uri == "/products") {
                $controller = new ProductController();
                $controller->index();
            } else if ($uri == "/products/add") {
                $controller = new ProductController();
                $controller->add();
            } else if ($uri == "/products/addToDB") {
                $controller = new ProductController();
                $controller->addToDB();
            } else if ($uri == "/products/modifyDB") {
                $controller = new ProductController();
                $controller->modifyDB();
            } else if ($uri == "/users" && isset($_GET["searchBar"])) {
                $controller = new UserController();
                $controller->index();
            } else if ($uri == "/users") {
                $controller = new UserController();
                $controller->index();
            } else if ($uri == "/users/add") {
                $controller = new UserController();
                $controller->add();
            } else if ($uri == "/users/addToDB") {
                $controller = new UserController();
                $controller->addToDB();
            } else if ($uri == "/users/modifyDB") {
                $controller = new UserController();
                $controller->modifyDB();
            } else if ($uri == "/lougout") {
                $controller = new UserController();
                $controller->lougout();
            } else {
                http_response_code(404);
                echo " Page introuvable";
            }
        }
    }
}
