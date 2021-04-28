<?php 
   require_once __DIR__.'/../php/db.php';

if(!empty($_POST['password']) && !empty($_POST['password_repeat']) && !empty($_POST['token'])){
            $password = htmlspecialchars($_POST['password']);
            $password_repeat = htmlspecialchars($_POST['password_repeat']);
            $token = htmlspecialchars($_POST['token']);

            $check = $bdd->prepare('SELECT * FROM users WHERE Token = ?');
            $check->execute(array($token));
            $row = $check->rowCount();

            if($row){
                if($password === $password_repeat){
                    $cost = ['cost' => 12];
                    $password = password_hash($password, PASSWORD_BCRYPT, $cost);

                    $update = $bdd->prepare('UPDATE users SET password = ? WHERE Token = ?');
                    $update->execute(array($password, $token));
                    
                    $delete = $bdd->prepare('DELETE FROM password_recover WHERE token_users = ?');
                    $delete->execute(array($token));

                    echo "Le mot de passe a bien été modifie";
                }else{
                    echo "Les mots de passes ne sont pas identiques";
                }
            }else{
                echo "Compte non existant";
            }
        }else{
            echo "Merci de renseigner un mot de passe";
        }