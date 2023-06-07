<?php

namespace src\models;

use core\BaseModel;
use PDO;
use PDOException;

class Other extends BaseModel
{
    public function __construct()
    {
        $this->table = "products";
        $this->getConnection();
    }

    public function getLogs()
    {
        $sql = "SELECT products.nom as pNom, users.nom, colonne,'date',content FROM logs LEFT OUTER JOIN products ON produit_id = products.id LEFT OUTER JOIN users ON user_id = users.id ORDER BY date DESC";
        $sth = $this->_connexion->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_OBJ);
    }
    public function userLogs($data)
    {
        $id = $data;
        $sql = "SELECT sold.dateAchat, products.nom as produitNom, products.prix_salarie as produitCouts FROM sold JOIN products ON sold.produit_id = products.id WHERE sold.user_id = :id ORDER BY sold.dateAchat DESC";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindParam(":id", $id);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_OBJ);
    }
    public function setSold($data,$userId)
    {
        if (gettype($data) == "array") {
            $productId = $data["id"];
            $userId = $data["userId"];
        } else {
            $productId = $data->id;
            $userId = $userId;
        }
        $sql = "INSERT INTO sold (produit_id,user_id) VALUES (:pId,:userId)";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindParam(":pId", $productId);
        $sth->bindParam(":userId", $userId);
        $sth->execute();
        return $sth->rowcount() > 0;
    }
    public function getFavoris($data)
    {
        if (gettype($data) == "array") {
            $id = $data["id"];
        } else {
            $id = $data->id;
        }
        $sql = "SELECT products.id, products.nom ,products.prix_salarie as prix , products.stock, 1 fav, products.image FROM favoris JOIN products ON favoris.product_id = products.id JOIN users ON favoris.user_id = users.id WHERE user_id = :userId";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindParam(":userId", $id);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_OBJ);
    }
    public function addFavoris($data)
    {
        $id = $data->id;
        $userId = $data->userId;
        $sql = "INSERT INTO favoris (product_id ,user_id) VALUES (:pId, :userId)";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindParam(":pId", $id);
        $sth->bindParam(":userId", $userId);
        $sth->execute();
        // return $sth->rowCount() > 0;
    }
    public function removeFavoris($data)
    {
        $id = $data->id;
        $userId = $data->userId;
        $sql = "DELETE FROM favoris WHERE product_id = :pId AND user_id = :userId";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindParam(":pId", $id);
        $sth->bindParam(":userId", $userId);
        $sth->execute();
        // return $sth->rowCount() > 0;
    }
    private $sqlRequest;
    public function totalPrice($data)
    {
        $userId = $data->userId;
        for ($a = 0; $a < count($data->content); $a++) {
            if ($a > 0) {
                $this->sqlRequest = $this->sqlRequest . " OR id = :id" . $a;
            } else {
                $this->sqlRequest = " id = :id" . $a;
            }
        }
        $sql = "UPDATE products SET stock = IF ( (SELECT users.budget FROM users WHERE users.id = :userId ) > ( SELECT SUM(prix_salarie) WHERE  $this->sqlRequest ), stock-1 , stock ) WHERE ( $this->sqlRequest )";
        $sth = $this->_connexion->prepare($sql);
        for ($i = 0; $i < count($data->content); $i++) {
            $text = ":id" . $i;
            $id = $data->content[$i]->id;
            $sth->bindValue($text, $id);
        }
        $sth->bindParam(":userId", $userId);
        $sth->execute();
        return $sth->rowCount() > 0;
    }
    public function payAll($data)
    {
        $userId = $data->userId;

        for ($a = 0; $a < count($data->content); $a++) {
            if ($a > 0) {
                $this->sqlRequest = $this->sqlRequest . " OR id = :id" . $a;
            } else {
                $this->sqlRequest = " id = :id" . $a;
            }
        }
        $sql = "UPDATE users SET budget = budget - ( SELECT SUM(prix_salarie) FROM products WHERE $this->sqlRequest ) WHERE id = :userId";
        $sth = $this->_connexion->prepare($sql);
        for ($i = 0; $i < count($data->content); $i++) {
            $text = ":id" . $i;
            $id = $data->content[$i]->id;
            $sth->bindValue($text, $id);
        }
        $sth->bindParam(":userId", $userId);
        $sth->execute();
        return $sth->rowCount() > 0;
    }

    public function getSolde($data)
    {
        $userId = $data->userId;

        $sql = "SELECT budget FROM users WHERE id = :userId";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindParam("userId", $userId);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_OBJ);
    }
}
/* 
METTRE A JOUR LE STOCK DES PRODUITS SI LE BUDGET UTILISATEUR EST SUFFISANT

UPDATE products SET stock = IF ( (SELECT users.budget FROM users WHERE users.id = 1 ) > ( SELECT SUM(prix_salarie) FROM products WHERE id = 1 ), stock-1 , stock )
WHERE ( id = 1);




METTRE A JOUR LE BUDGET UTILISATEUR EN PRELEVANT LE COUT DU PANIER 

UPDATE users SET budget = budget - ( SELECT SUM(prix_salarie) FROM products WHERE id = 1 OR id = 3) WHERE id = 1
*/