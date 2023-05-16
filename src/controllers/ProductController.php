<?php

namespace src\controllers;

use core\BaseController;
use src\models\Product;

class ProductController extends BaseController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new Product;
    }
    public function index()
    {
        $result = "";
        if (isset($_SESSION["result"])) {
            $result = $_SESSION["result"];
            $_SESSION["result"] = "";
        }

        $title = "Products";
        $name = $_SESSION["username"];
        $placeholder = "product";
        $products =  $this->model->GetAll();
        $this->render("products.html.twig", array("title" => $title, "products" => $products, "name" => $name, "placeholder" => $placeholder, "result" => $result));
    }
    public function add()
    {
        $title = "Add Product";
        $name = $_SESSION["username"];
        $this->render("productsAdd.html.twig", array("title" => $title, "name" => $name));
    }
    public function addToDB()
    {
        if (isset($_POST["nom"], $_POST["prixSalarie"], $_POST["prixAchat"], $_POST["stock"])) {
            $nom = $_POST["nom"];
            $priceS = $_POST["prixSalarie"];
            $priceA = $_POST["prixAchat"];
            $stock = $_POST["stock"];

            if (((trim($nom)) != "") && (trim($priceA) != "") && (trim($priceS) != "") && (trim($stock) != "")) {
                $_SESSION["result"] = $this->model->insert($_POST);
            }
        }
        header("location:/products");
    }

    public function modifyDB()
    {

        $json = file_get_contents('php://input');
        $data = json_decode($json);
        $this->model->logs($data);
        $res = $this->model->modify($data);
        echo $res;
    }

    public function searchDB()
    {
        if (isset($_GET["searchBar"]) && trim($_GET["searchBar"]) != "") {
            $result = "";
            if (isset($_SESSION["result"])) {
                $result = $_SESSION["result"];
                $_SESSION["result"] = "";
            }
            $title = "Products";
            $name = $_SESSION["username"];
            $placeholder = "product";
            $products = $this->model->search($_GET);
            if ($products == []) {
                $result = 2;
            }

            $this->render("products.html.twig", array("title" => $title, "products" => $products, "name" => $name, "placeholder" => $placeholder, "result" => $result));
        } else {
            header("location:http://localhost:8000/products");
        }
    }
    public function restock()
    {
        if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
            $selectedID = $_GET["id"];
        } else {
            $selectedID = "";
        }
        $title = "Restock";
        $name = $_SESSION["username"];
        $products = $this->model->getAll();
        $this->render("restock.html.twig", array("title" => $title, "products" => $products, "name" => $name, "selectedID" => $selectedID));
    }
    public function restockDB()
    {
        if (isset($_POST["prods"], $_POST["quantity"])) {
            if (!empty(trim($_POST["prods"])) && !empty(trim($_POST["quantity"]))) {
                $quantity = $_POST["quantity"];
                $res = $this->model->restock($_POST);
                if ($res) {
                    $this->model->addLogs($_POST);
                    $_SESSION["result"] = ["success" => true, "quantity" => $quantity];
                    header("location: /products");
                } else {
                    $_SESSION["result"] = "error";
                }
            }
        }
    }
    public function history()
    {
        $title = "History";
        $name = $_SESSION["username"];
        $history = $this->model->getHistory();
        $this->render("restockHistory.html.twig", array("title" => $title, "history" => $history, "name" => $name));
    }

    public function displayJSON()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        $this->model->table = "products";
        $result = $this->model->getAll();
        if (!empty($result)) {
            echo json_encode($result);
        }
    }
    public function consumeProducts()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        if (!empty(trim($_GET["id"])) && is_numeric($_GET["id"])) {

            $resultat = $this->model->consume($_GET["id"]);
            if ($resultat) {
                $this->model->id = $_GET["id"];
                $result = $this->model->getOne();
                if (!empty($result)) {
                    echo json_encode($result);
                }
            } else {
                echo "erreur de la demande";
            }
        }
    }
}
