<?php 

namespace App\Core;

class Database
{
    public function __construct(){  
        try{
            $pdo = new \PDO("pgsql:host=db;port=;dbname=devdb","devuser", "devpass");
        }catch(\PDOException $e){
            die("Erreur ".$e->getMessage());
        }
    }
    
}