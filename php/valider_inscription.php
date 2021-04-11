<?php 
session_start();
require("db.php");

$userNOM = $_SESSION['nom'];
$userPRENOM = $_SESSION['prenom'];
$userADRS = $_SESSION['adresse'];
$userCP = $_SESSION['cp'];
$userEMAIL = $_SESSION['email'];
$userLOGIN = $_SESSION['login'];
//hashage du mdp pour inserrer dans la bd
$userPSWD = password_hash($_SESSION['password'], PASSWORD_DEFAULT);

//insertion nouveau utilisateur dans la base de données
try {
    $request = $db->prepare('insert into users (username, password, email, nom, prenom, adresse,  cp) values (:username, :password, :email, :nom, :prenom, :adresse, :cp)');
    $request->bindParam('username', $userLOGIN , PDO::PARAM_STR);
    $request->bindParam('password', $userPSWD , PDO::PARAM_STR);
    $request->bindParam('email', $userEMAIL , PDO::PARAM_STR);
    $request->bindParam('nom', $userNOM , PDO::PARAM_STR);
    $request->bindParam('prenom', $userPRENOM , PDO::PARAM_STR);
    $request->bindParam('adresse', $userADRS , PDO::PARAM_STR);
    $request->bindParam('cp', $userCP , PDO::PARAM_STR);
    $request->execute();
    //une fois utilisateur crée on envoye vers la page de connection
    $_SESSION['msg_reg'] = "votre compte à été crée avec succés";
    header("Location: ../index.php");
} catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
}

