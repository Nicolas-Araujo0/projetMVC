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

    public function getLogs(){
        $sql = "SELECT products.nom as pNom, users.nom, colonne,'date',content FROM logs LEFT OUTER JOIN products ON produit_id = products.id LEFT OUTER JOIN users ON user_id = users.id ORDER BY date DESC";
        $sth = $this->_connexion->prepare($sql);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_OBJ);
    }
}
