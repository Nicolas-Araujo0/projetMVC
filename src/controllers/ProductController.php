<?php

namespace src\controllers;

use core\BaseController;
use src\models\Product;

session_start();
$_SESSION["username"] = "Nicos";
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
}
