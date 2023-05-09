<?php

namespace src\controllers;

use core\BaseController;
use src\models\User;

session_start();

class UserController extends BaseController
{
    private $model;
    public $name;
    public function __construct()
    {
        parent::__construct();
        $this->model = new User;
    }
    public function index()
    {
        $result = "";
        if (isset($_SESSION["result"])) {
            $result = $_SESSION["result"];
            $_SESSION["result"] = "";
        }

        $title = "Users";
        $name = $_SESSION["username"];
        $placeholder = "user";
        $user =  $this->model->GetAll();
        $this->render("users.html.twig", array("user" => $user, "title" => $title, "name" => $name, "placeholder" => $placeholder, "result" => $result));
    }

    public function login()
    {
        if (isset($_POST["email"], $_POST["pass"])) {
            if (trim($_POST["email"]) != "" && trim($_POST["pass"]) != "") {
                $pass = $_POST["pass"];
                $response = $this->model->connexion($_POST);
                if($response){
                    password_verify($pass, $response->pass);
                    $_SESSION["username"] = $response->nom . " ". $response->prenom;
                    header("location:/users");
                } else {
                    header("location:../");
                    $_SESSION["notification"] = "error";
                }
            };
        };
    }
    public function lougout(){
        session_destroy();
        header("http://localhost:8000");
    }


    public function add()
    {
        $title = "Add User";
        $name = $_SESSION["username"];
        $this->render("usersAdd.html.twig", array("title" => $title, "name" => $name));
    }
    public function addToDB()
    {
        if (isset($_POST["prenom"], $_POST["nom"], $_POST["email"], $_POST["pass"], $_POST["admin"])) {
            $prenom = $_POST["prenom"];
            $nom = $_POST["nom"];
            $email = $_POST["email"];
            $pass = $_POST["pass"];
            $admin = $_POST["admin"];

            if (((trim($prenom)) != "") && (trim($nom) != "") && (trim($email) != "") && (trim($pass) != "") && (trim($admin) != "")) {
                $_SESSION["result"] = $this->model->insert($_POST);
            }
        }
        header("location:/users");
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

            $this->render("users.html.twig", array("title" => $title, "products" => $products, "name" => $name, "placeholder" => $placeholder, "result" => $result));
        } else {
            header("location:http://localhost:8000/products");
        }
    }
}
