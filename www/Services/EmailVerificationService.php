<?php

namespace App\Service;
use App\Core\Database;
use App\Model\EmailVerification;
use App\Model\User;

class EmailVerificationService
{

    public function createUserToken($data) {
        $emailVerification = new EmailVerification();
        $emailVerification->setUserID($data["user_id"]);
        $emailVerification->setToken($data["token"]);
        $pdo = Database::getInstance()->getConnection();
        $sql =  'INSERT INTO email_verification("user_id","token", "created_at")
                    VALUES (:user_id,:token,\''.date('Y-m-d').'\')';
        $queryPrepared = $pdo->prepare($sql);
        $queryPrepared->execute([
            "user_id"=> $emailVerification->getUserID(),
            "token"=> $emailVerification->getToken(),
        ]);
    }

    public function getUserIdFromToken($token){
        $pdo = Database::getInstance()->getConnection();
        $sql =  'SELECT "user_id" FROM email_verification WHERE token=:token';
        $queryPrepared = $pdo->prepare($sql);
        $queryPrepared->execute(["token" => $token]);
        return $queryPrepared->fetchColumn();
    }

    public function activeAccount($userId){
        $user = new User();
        $user->setIsActive(true);
        $pdo = Database::getInstance()->getConnection();
        $sql = 'UPDATE "user" SET is_active=:is_active WHERE id = :id';
        $queryPrepared = $pdo->prepare($sql);
        $queryPrepared->execute(["is_active" => $user->getIsActive(), "id" => $userId]);
    }
}