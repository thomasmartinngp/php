<?php 

namespace App\Core;

class Database
{
    private $pdo;
    public function __construct(){  
        try{
            $this->pdo = new \PDO("pgsql:host=db;port=5432;dbname=devdb","devuser", "devpass");
        }catch(\PDOException $e){
            die("Erreur ".$e->getMessage());
        }
    }
    public function getConnection(): \PDO{
        return $this->pdo;
    }
}