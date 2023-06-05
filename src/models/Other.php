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
    public function setSold($data)
    {
        $productId = $data["id"];
        $userId = $data["userId"];
        $sql = "INSERT INTO sold (produit_id,user_id) VALUES (:pId,:userId)";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindParam(":pId", $productId);
        $sth->bindParam(":userId", $userId);
        $sth->execute();
        return $sth->rowcount() > 0;
    }
    public function getFavoris($data)
    {
        if(gettype($data) == "array"){
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
}
