<?php

namespace src\models;

use core\BaseModel;
use PDO;
class User extends BaseModel
{
    public function __construct()
    {
        $this->table = "users";
        $this->getConnection();
    }

    public function insert($data)
    {
        $pass = password_hash($data["pass"], PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(nom, prenom, email, pass, admin) VALUES (:nom, :prenom, :email, :pass, :admin)";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindparam(":nom", $data["nom"]);
        $sth->bindparam(":prenom", $data["prenom"]);
        $sth->bindparam(":email", $data["email"]);
        $sth->bindparam(":pass", $pass);
        $sth->bindparam(":admin", $data["admin"]);
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
        $_SESSION["result"] = ["id" => $id, "column" => $column, "content" => $newContent, "name" => $productName, "oldContent" => $oldContent];
        return '{ "id": "' . $data->id . '" }';
    }
    public function search($data)
    {
        $search = $data["searchBar"];
        $sql = "SELECT * FROM $this->table WHERE INSTR(nom,:search)";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindparam(":search", $search);
        $sth->execute();
        return $sth->fetchAll();
    }
    public function connexion($data){
        $email = $data["email"];
        $pass = $data["pass"];

        $sql = "SELECT * FROM users WHERE email = :email";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindparam(":email", $email);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_OBJ);
    }
}
