<?php

namespace src\models;

use core\BaseModel;

class Product extends BaseModel
{
    public function __construct()
    {
        $this->table = "products";
        $this->getConnection();
    }

    public function insert($data)
    {
        $sql = "INSERT INTO products(nom, prix_salarie, prix_achat, stock) VALUES (:nom, :priceS, :priceA, :stock)";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindparam(":nom", $data["nom"]);
        $sth->bindparam(":priceS", $data["prixSalarie"]);
        $sth->bindparam(":priceA", $data["prixAchat"]);
        $sth->bindparam(":stock", $data["stock"]);
        $sth->execute();
        return ($sth->rowcount() > 0);
    }
    public function modify($data)
    {
        //var_dump($data);
        $id = $data->id;
        $newContent = $data->content;
        $column = $data->column;
        $oldContent = $data->oldContent;
        $productName = $data->name;
        
        $sql = "UPDATE $this->table SET $column = $newContent WHERE id = $id";
        $sth = $this->_connexion->prepare($sql);
        $sth->execute();
        // return autre chose que du json
        $_SESSION["result"] = ["id" => $id, "column" => $column, "content" => $newContent, "name"=> $productName, "oldContent" => $oldContent];
        return '{ "id": "'. $data->id .'" }';
    }

    public function search($data){
        $search = $data["searchBar"];
        $sql = "SELECT * FROM products WHERE INSTR(nom,:search)";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindparam(":search", $search);
        $sth->execute();
        return $sth->fetchAll();
    }
}
