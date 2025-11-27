<?php

namespace App\Controller;

use App\Core\Render;

class Base
{
    public function index() {
         $this->renderPage("home", "frontoffice");
    }
    protected function renderPage(string $view, string $template = "frontoffice", array $data = []):void{
        $render = new Render($view, $template);  
        if(!empty($data)){
            foreach ($data as $key => $value){
            $render->assign($key, $value);
            }
        }
        $render->render();
    }

    protected function renderHome(){
        $render = new Render("home", "frontoffice");
        $render->render();
    }

    public function setSessionData($userData){
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['name'] = $userData['name'];
        $_SESSION['email'] = $userData['email'];
        $_SESSION['is_active'] = $userData['is_active'];
    }
}