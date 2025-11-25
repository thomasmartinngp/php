<?php

namespace App\Controller;

use App\Core\Render;
use App\Service\AuthService;
use App\Service\EmailVerificationService;
class Auth
{

    public function index(): void{
        var_dump("OUIII")  ;
    }

    public function login(): void{
    }

    public function signup(): void{
        $errors = [];
         if(
        isset($_POST['name']) &&
        !empty($_POST['email']) &&
        !empty($_POST['pwd']) &&
        !empty($_POST['pwdConfirm']) &&
        count($_POST) == 4
    ){
        //Nettoyage de la donnée
        $name = ucwords(strtolower(trim($_POST['name'])));
        $email = strtolower(trim($_POST['email']));

        if(!empty($name) && strlen($name)<2){
            $errors[]="Votre prénom doit faire au minimum 2 caractères";
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors[]="Votre email n'est pas correct";
        }else{
            $verifiyMail = new AuthService();
            if($verifiyMail->verifyEmail($email)){
                $errors[]= "L'email existe deja en bdd";
            }
        }
        if(strlen($_POST["pwd"]) < 8 ||
            !preg_match('/[a-z]/', $_POST["pwd"] ) ||
            !preg_match('/[A-Z]/', $_POST["pwd"]) ||
            !preg_match('/[0-9]/', $_POST["pwd"])
        ){
            $errors[]="Votre mot de passe doit faire au minimum 8 caractères avec min, maj, chiffres";
        }
        if($_POST["pwd"] != $_POST["pwdConfirm"]){
            $errors[]="Votre mot de passe de confirmation ne correspond pas";
        }  
        if(empty($errors)){
            $pwdHashed = password_hash($_POST["pwd"], PASSWORD_DEFAULT );
            $data = [
                "name"=> $name,
                "email"=> $email,
                "password"=> $pwdHashed
            ];
            $createUser = new AuthService();
            $userId = $createUser->createUser($data);
            if(!empty($userId)){
                $token = hash("sha256", bin2hex(random_bytes(32)));
                $data = [
                "user_id"=> $userId,
                "token"=> $token,
            ];
                $emailService = new EmailVerificationService();
                $emailService->createUserToken($data);    
            }
            $render = new Render("dashboard", "frontoffice") ;
            $render->render();
        }
    }else{
        echo "Tentative de XSS";
    }
    
    }
    public function render(): void{
        $render = new Render("signup", "frontoffice") ;
        $render->render();
    }
}

