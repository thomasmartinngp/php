<?php

namespace App\Service;
use App\Core\Database;
use App\Model\User;

class AuthService extends Database
{  
    public function createUser($data) {
        var_dump($data);
        $user = new User();
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);

        $pdo = $this->getConnection();
        $sql =  'INSERT INTO "user"("name","email","password","created_at")
                    VALUES (:name,:email,:password,\''.date('Y-m-d').'\')';
        $queryPrepared = $pdo->prepare($sql);
        if ($queryPrepared->execute([

            "name" => $user->getName(),
            "email" => $user->getEmail(),
            "password" => $user->getPassword()
        ]) 
        ) {
            $id = $pdo->lastInsertId();
            echo"Utilisateur ajouté !";
            return $id;
        } 
    }

    public function verifyEmail($email){
        $user = new User();
        $user->setEmail($email);
        $pdo = $this->getConnection();
         $sql = 'SELECT "id" FROM "user" WHERE email=:email';
            $queryPrepared = $pdo->prepare($sql);
            $queryPrepared->execute(["email"=>$user->getEmail()]);
            if($queryPrepared->fetch()){
                return true;
            }
        return false;
    }

    public function updateUser($data){
    }
}