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
    public function getLogs()
    {
        $response = $this->model->getLogs();
        if (!empty($response)) {
            $title = "Logs";
            $name = $_SESSION["username"];
            $this->render("logs.html.twig", array("title" => $title, "name" => $name, "logs" => $response));
        }
    }
    public function userlogsJSON()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        if (isset($_GET["id"])) {
            $result = $this->model->userLogs($_GET["id"]);
            if (!empty($result)) {
                echo json_encode($result);
            }
        }
    }
    public function addHistory()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        if (isset($_GET["id"], $_GET["userId"])) {
            $this->model->setSold($_GET,"");
        }
    }
    public function favorisJSON()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        if (isset($_GET["id"])) {
            $result = $this->model->getFavoris($_GET);
            if (!empty($result)) {
                echo json_encode($result);
            } else {
                echo json_encode("noFavs");
            }
        }
    }
    public function addFavoris()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");

        $json = file_get_contents('php://input');
        $data = json_decode($json);

        $this->model->addFavoris($data);
        $result = $this->model->getFavoris($data);
        echo $result ? json_encode($result) : json_encode("error");
    }
    public function removeFavoris()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");

        $json = file_get_contents('php://input');
        $data = json_decode($json);
        $this->model->removeFavoris($data);
        $result = $this->model->getFavoris($data);
        echo $result ? json_encode($result) : json_encode("error");
    }
    public function payCart()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-Type");

        $json = file_get_contents('php://input');
        $data = json_decode($json);
        if (isset($data->userId)) {
            $resultat = $this->model->totalPrice($data);
            if ($resultat) {
                foreach ($data->content as $element) {
                    $this->model->setSold($element,$data->userId);
                }
                $result = $this->model->payAll($data);
                if ($result) {
                    $solde = $this->model->getSolde($data);
                    if (!empty($solde)) {
                        echo json_encode($solde);
                    } else {
                        echo json_encode("failed to fetch");
                    }
                } else {
                    echo json_encode("error");
                }
            } else {
                echo json_encode("error -> prob prix");
            }
        } else {
            echo json_encode("error : prob userId");
        }
    }
}
