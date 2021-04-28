<?php 
    session_start();
    require("../php/db.php");
    $_SESSION['userMail'] = htmlspecialchars($_POST['email']);


    if(!empty($_POST['email'])){
        if(isset($_SESSION['userMail'])){
            $email = $_SESSION['userMail'];
            $query = "SELECT email FROM users WHERE email =:mail";
            $request = $db->prepare($query);
            $request->bindParam('mail', $email, PDO::PARAM_STR);
            $request->execute();
            $data = $request->fetch();
            $row = $request->rowCount();
    }

        if($row){
            $_SESSION['msg'] = "";
            header('Location: password_change.php');
        }else{
            $_SESSION['msg'] = "Email incorrect !";
            header('Location: restauration.php');
        }
    }