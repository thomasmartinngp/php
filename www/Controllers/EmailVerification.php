<?php

namespace App\Controller;

use App\Controller\Base;
use App\Service\EmailVerificationService;
use App\Service\AuthService;
use App\Controller\Auth;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

class EmailVerification extends Base
{

    private $errors = [];
    public function sendVerificationMail($email, $token){
        $activationLink = "http://localhost:8080/activation?email=".$email."&token=".$token;
        $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = 0;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'mailpit';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = false;                                   //Enable SMTP authentication
                $mail->Port       = 1025;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('from@example.com', 'Mailer');
                $mail->addAddress($email);     //Add a recipient

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Veuillez confirmer votre inscription';
                $mail->Body    = 'Cliquez sur ce lien : <a href="'.$activationLink.'">ici!</a>';
                $mail->AltBody = $activationLink;

                $mail->send();
                echo 'Un mail de confirmation vient de vous être envoyé';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
    }

    public function sendResetPwdMail($email){
        $auth = new Auth();
        $email = $auth->clearEmail($_POST['email']);
        $verifiyMail = new AuthService();
        if($verifiyMail->verifyEmail($email)){
            
        } else{
            $this->errors[]= "L'email n'existe déjà en bdd";
        }
    }

    public function activateAccount(){
        $token = $_GET["token"];
        $emailverificationService = new EmailVerificationService();
        $userId = $emailverificationService->getUserIdFromToken($token);
        if(!empty($userId)){
            $auth = new AuthService();
            $emailverificationService->activeAccount($userId);
            $userData = $auth->getUserDataFromId($userId);
            $this->setSessionData($userData);
        }
         $this->renderPage("dashboard");
    }
}
