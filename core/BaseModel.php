<?php

namespace core;

use PDO;
use PDOException;

abstract class BaseModel
{
    private $host = "localhost";
    private $db_name = "projetmvc";
    private $username = "root";
    private $password = "";
    protected $_connexion;
    public $table;
    public $id;

    public function getConnection()
    {
        $this->_connexion = null;
        try {
            $this->_connexion = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->_connexion->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }
    }
    public function getOne(){
        $sql = "SELECT * FROM  $this->table WHERE id =  $this->id";
        $sth = $this->_connexion->prepare($sql);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_ASSOC);
    }
    public function getAll(){
        $sql = "SELECT * FROM  . $this->table";
        $sth = $this->_connexion->prepare($sql);
        $sth->execute();
        return $sth->fetchAll();
    }
}
