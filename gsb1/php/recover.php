<?php 
    require_once __DIR__.'/../php/db.php';

    if(!empty($_POST['email'])){
        $email = htmlspecialchars($_POST['email']);

        $check = $bdd->prepare('SELECT Token FROM users WHERE email = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $row = $check->rowCount();

        if($row){
            $token = bin2hex(openssl_random_pseudo_bytes(24));
            $token_user = $data['Token'];

            $insert = $bdd->prepare('INSERT INTO password_recover(token_users, token) VALUES(?,?)');
            $insert->execute(array($token_user, $token));

            $link = 'password_change.php?u='.base64_encode($token_user).'&token='.base64_encode($token);

            echo "<a href='$link'>Lien</a>";
        }else{
            echo "Compte non existant";
            #header('Location: ../index.php');
            #die();
        }
    }