<?php

namespace core;

use src\controllers\HomeController;
use src\controllers\OtherController;
use src\controllers\ProductController;
use src\controllers\UserController;

session_start();

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
        } else if ($uri == "/api/user/login") {
            $controller = new UserController();
            $controller->userLogin();
        } elseif (isset($_SESSION["username"])) {

            // ------------------------------------------------------- PRODUCTS
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
            }
            // -------------------------------------------------------- RESTOCK
            else if ($uri == "/restock") {
                $controller = new ProductController();
                $controller->restock();
            } else if ($uri == "/restock/buyProducts") {
                $controller = new ProductController();
                $controller->restockDB();
            } else if ($uri == "/restock/history") {
                $controller = new ProductController();
                $controller->history();
            }
            // -------------------------------------------------------- USERS
            else if ($uri == "/users" && isset($_GET["searchBar"])) {
                $controller = new UserController();
                $controller->searchDB();
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
            } else if ($uri == "/commande") {
                $controller = new UserController();
                $controller->showStats();
            } else if ($uri == "/logs") {
                $controller = new OtherController();
                $controller->getLogs();
            }
            // -------------------------------------------------------- lOUGOUT
            else if ($uri == "/lougout") {
                $controller = new UserController();
                $controller->lougout();
            } else {
                http_response_code(404);
                //echo " Page introuvable";
            }
        } else if ($uri == "/api/products") {
            $controller = new ProductController();
            $controller->displayJSON();
        } else if ($uri == "/api/products/type") {
            $controller = new ProductController();
            $controller->displayTypeJSON();
        } else if ($uri == "/api/products/consume" && isset($_GET["id"],$_GET["userId"])) {
            $controller = new ProductController();
            $controller->consumeProducts();
            $controller = new OtherController();
            $controller->addHistory();
        } else if ($uri == "/api/historique" && isset($_GET["id"])) {
            $controller = new OtherController();
            $controller->userlogsJSON();
        } else if ($uri == "/api/favoris" && isset($_GET["id"])) {
            $controller = new OtherController();
            $controller->favorisJSON();
        } else if ($uri == "/api/favoris/add") {
            $controller = new OtherController();
            $controller->addFavoris();
        } else if ($uri == "/api/favoris/remove") {
            $controller = new OtherController();
            $controller->removeFavoris();
        }  else {
            header('location: /');
        }
    }
}
