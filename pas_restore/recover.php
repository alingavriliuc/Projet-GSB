<?php 
    session_start();
    require("../php/db.php");
    $email = $_SESSION['userMail'];
    $_SESSION['reset_succes'] = "";
    $_SESSION['resetPSW_msg'] = "";

    if(isset($_POST['password']) && isset($_POST['password_repeat'])){
        if(strcmp($_POST['password'], $_POST['password_repeat']) !== 0){
            $_SESSION['resetPSW_msg'] = "Les deux mot de passe ne sont pas identiques";
        }else{
            $userPSWD = password_hash($_POST['password'], PASSWORD_DEFAULT);
            try {
                $query_updateMDP = "UPDATE users SET password=:password where email=:email";
                $request = $db->prepare($query_updateMDP);
                $request->bindParam('password', $userPSWD , PDO::PARAM_STR);
                $request->bindParam('email', $email , PDO::PARAM_STR);
                $request->execute();
                $_SESSION['reset_succes'] = "Mot de passe changé";
            } catch (PDOException $e) {
                echo "Error : ".$e->getMessage();
            }
        }
    }else{
        $_SESSION['resetPSW_msg'] = "veillez remplir les deux champs";
    }

    header('Location: password_change.php');