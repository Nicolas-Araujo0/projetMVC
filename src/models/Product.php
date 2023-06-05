<?php

namespace src\models;

use core\BaseModel;
use PDO;
use PDOException;

class Product extends BaseModel
{
    public function __construct()
    {
        $this->table = "products";
        $this->getConnection();
    }

    public function insert($data)
    {
        if (preg_match("/^[a-zA-Z]{4,}$/u", $data["nom"]) &&  preg_match("/^\d+$/u", $data["prixAchat"]) && preg_match("/^\d+$/u", $data["prixSalarie"]) && preg_match("/^\d+$/u", $data["stock"])) {
            $sql = "INSERT INTO products(nom, prix_salarie, prix_achat, stock,type) VALUES (:nom, :priceS, :priceA, :stock,:type)";
            $sth = $this->_connexion->prepare($sql);
            $sth->bindparam(":nom", $data["nom"]);
            $sth->bindparam(":priceS", $data["prixSalarie"]);
            $sth->bindparam(":priceA", $data["prixAchat"]);
            $sth->bindparam(":stock", $data["stock"]);
            $sth->bindParam(":type", $data["type"]);
            $sth->execute();
            return ($sth->rowcount() > 0);
        } else {
            return "non valide";
        }
    }
    public function modify($data)
    {
        //var_dump($data);
        $id = $data->id;
        $newContent = $data->content;
        $column = $data->column;
        $oldContent = $data->oldContent;
        $productName = $data->name;
        if ($column == "nom") {
            if (preg_match("/^\"[a-zA-Z]{4,}\"$/u", $newContent)) {
                $update = true;
            } else {
                $_SESSION["result"] = ["nonvalide" => "nom"];
            }
        } else if ($column == "prix_achat" || $column == "prix_salarie") {
            if (preg_match("/^\"(-?(\d*(.\d{2})?)|(.\d{2})?)\"$/u", $newContent)) {
                $update = true;
            } else {
                $_SESSION["result"] = ["nonvalide" => "number"];
            }
        } else {
            $update = false;
        }
        if ($update) {
            $sql = "UPDATE $this->table SET $column = $newContent WHERE id = $id";
            $sth = $this->_connexion->prepare($sql);
            $sth->execute();
            // return autre chose que du json
            $_SESSION["result"] = ["id" => $id, "column" => $column, "content" => $newContent, "name" => $productName, "oldContent" => $oldContent];
            return '{ "id": "' . $data->id . '" }';
        } else {
            return '{ "result": "error" }';
        }
    }
    public function logs($data)
    {
        try {
            $id = $data->id;
            $newContent = $data->content;
            $column = $data->column;
            $sql = "INSERT INTO logs (colonne, content, produit_id) VALUES (:colonne,:content, :id)";
            $sth = $this->_connexion->prepare($sql);
            $sth->bindParam(":colonne", $column, PDO::PARAM_STR_CHAR);
            $sth->bindParam(":content", $newContent, PDO::PARAM_STR_CHAR);
            $sth->bindParam(":id", $id, PDO::PARAM_INT);
            $sth->execute();
            return $sth->rowcount() > 0;
        } catch (PDOException $exception) {
            die("Erreur de connexion : " . $exception->getMessage());
        }
    }
    public function search($data)
    {
        $search = $data["searchBar"];
        $sql = "SELECT * FROM products WHERE INSTR(nom,:search)";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindparam(":search", $search);
        $sth->execute();
        return $sth->fetchAll();
    }
    public function restock($data)
    {
        $newStock = $data["quantity"];
        $id = $data["prods"];
        $sql = "UPDATE  $this->table SET stock = stock + :stock WHERE id = :id";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindparam(":stock", $newStock, PDO::PARAM_INT);
        $sth->bindparam(":id", $id, PDO::PARAM_INT);
        $sth->execute();
        return $sth->rowcount() > 0;
    }
    public function addLogs($data)
    {
        $prodId = $data["prods"];
        $stock = $data["quantity"];
        $price = $data["cost"];
        $userId = $_SESSION["userId"];
        $sql = "INSERT INTO restock (produit_id,user_id,quantite,cout) VALUES (:prodId,:userId,:stock,:price)";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindparam(":prodId", $prodId, PDO::PARAM_INT);
        $sth->bindparam(":stock", $stock, PDO::PARAM_INT);
        $sth->bindparam(":price", $price, PDO::PARAM_STR);
        $sth->bindparam(":userId", $userId, PDO::PARAM_INT);
        $sth->execute();
        return $sth->rowcount() > 0;
    }
    public function getHistory()
    {
        $sql = "SELECT users.nom, users.prenom, products.nom as pNom, quantite, date, cout FROM `restock` JOIN users ON user_id = users.id JOIN products ON produit_id = products.id ORDER BY date DESC";
        $sth = $this->_connexion->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function consume($data)
    {
        $id = $data;
        $minus = 1;
        $sql = "UPDATE $this->table SET stock = stock - :minus WHERE id = :id AND stock > 0 ";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindparam(":id", $id);
        $sth->bindparam(":minus", $minus);
        $sth->execute();
        return $sth->rowcount() > 0;
    }
    public function payArticle($data, $userId)
    {
        $price = $data["prix_salarie"];
        $userId = $userId;
        $sql = "UPDATE users SET budget = budget - :price WHERE id = :userId";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindParam(":price", $price);
        $sth->bindParam(":userId", $userId);
        $sth->execute();
        return $sth->rowcount() > 0;
    }

    public function getAllwithFavs($data)
    {
        $userId = $data["userId"];
        $sql = "SELECT nom, (CASE WHEN favoris.user_id IS NOT NULL THEN true ELSE false END) AS fav, stock, prix_salarie,products.id, products.type, products.image FROM `products` LEFT JOIN favoris ON favoris.product_id = products.id AND favoris.user_id = :userId";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindParam(":userId", $userId);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_OBJ);
    }
    public function getAllType()
    {
        $sql = "SELECT type FROM products GROUP BY type";
        $sth = $this->_connexion->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_OBJ);
    }

}
