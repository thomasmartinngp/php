<?php

        if(!empty($errors)){
            echo "<pre>";
            print_r($errors);
            echo "</pre>";
        }
?>

<form method="POST" action="/addUser">
    <input type="text" value="<?= $_POST["firstname"] ?? "" ?>" name="name" placeholder="Votre prénom"><br>
    <input type="email" value="<?= $_POST["email"] ?? "" ?>" required name="email" placeholder="Votre email"><br>
    <input type="password" required name="pwd" placeholder="Votre mot de passe"><br>
    <input type="password" required name="pwdConfirm" placeholder="Confirmation du mot de passe"><br>
    <input type="submit" value="S'inscrire">
</form>