<?php

namespace src\models;

use core\BaseModel;
use PDO;
use PDOException;

class User extends BaseModel
{
    public function __construct()
    {
        $this->table = "users";
        $this->getConnection();
    }

    public function insert($data)
    {
        if (preg_match("/^[a-zA-Z]{4,}$/u", $data["nom"]) && preg_match("/^[a-zA-Z]{4,}$/u", $data["prenom"]) && preg_match("/^[A-Z]{1}\w{5,}@{1}\w{3,}.\w{2,4}$/u", $data["email"])  && preg_match("/^(yes|no|1|0)$/u", $data["admin"])) {
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
        if ($column == "nom" || $column == "prenom") {
            if (preg_match("/^\"[a-zA-Z]{4,}\"$/u", $newContent)) {
                $update = true;
            } else {
                 $_SESSION["result"] = ["nonvalide"=> "nom"];
            }
        } else if ($column == "email") {
            if (preg_match("/^\"[A-Z]{1}\w{5,}@{1}\w{3,}.\w{2,4}\"$/u", $newContent)) {
                $update = true;
            } else {
                 $_SESSION["result"] = ["nonvalide"=> "email"];
            }
        } else if ($column == "admin") {
            if (preg_match("/^\"(yes|no|1|0)\"$/u", $newContent)) {
                $update = true;
                if($newContent == '"1"'){
                    $newContent = "no";
                } else if ($newContent == '"2'){
                    $newContent = "yes";
                }
            } else {
                 $_SESSION["result"] = ["nonvalide"=> "admin"];
            }
        } else if ($column == "budget") {
            if (preg_match("/^\"\d{0,3}\"$/u", $newContent)) {
                $update = true;
            } else {
                 $_SESSION["result"] = ["nonvalide"=> "budget"];
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
            $sql = "INSERT INTO logs (colonne, content, user_id) VALUES (:colonne,:content, :id)";
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
        $sql = "SELECT * FROM $this->table WHERE INSTR(nom,:search) OR INSTR(prenom,:search) OR INSTR(email,:search)";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindparam(":search", $search);
        $sth->execute();
        return $sth->fetchAll();
    }
    public function connexion($data)
    {
        $email = $data["email"];
        $sql = "SELECT * FROM users WHERE email = :email AND admin = 1";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindparam(":email", $email);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_OBJ);
    }
    public function getCommande()
    {
        $sql = "SELECT users.nom,users.prenom, t.howmany quantity_eaten, products.nom Favorite_Food FROM 
        (SELECT user_id, users.email, produit_id, count(*) as `howmany`
        FROM sold
        JOIN users on sold.user_id = users.id
        GROUP BY produit_id, user_id
        ORDER BY `howmany` DESC) t JOIN users ON user_id = users.id JOIN products ON t.produit_id = products.id GROUP BY t.user_id;";
        $sth = $this->_connexion->prepare($sql);
        $sth->execute();
        return $sth->fetchAll();
    }
    public function getStats($column, $table)
    {
        $sql = "SELECT * from ':table' ORDER BY :column DESC LIMIT 1";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindParam(":column", $column, PDO::PARAM_STR_CHAR);
        $sth->bindParam(":table", $table, PDO::PARAM_STR_CHAR);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_OBJ);
    }
    public function countStat($column, $table, $id)
    {
        $sql = "SELECT count(*) from ':table' WHERE id = :id";
        $sth = $this->_connexion->prepare($sql);
        $sth->bindParam(":column", $column, PDO::PARAM_STR_CHAR);
        $sth->bindParam(":table", $table, PDO::PARAM_STR_CHAR);
        $sth->bindParam(":id", $id, PDO::PARAM_INT);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_OBJ);
    }
    public function biggestBuyer()
    {
        $sql = "SELECT count(*),user.nom, user.prenom FROM sold JOIN users ON user_id = users.id GROUP BY user_id DESC LIMIT 1";
        $sth = $this->_connexion->prepare($sql);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_OBJ);
    }
}
