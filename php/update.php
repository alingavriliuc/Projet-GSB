<?php
require("db.php"); 
try {
    $request = $db->prepare('update fiche_frais set idEtat = "VA" where userid=:userid and date=:date');
    $request->bindParam('userid', $_GET['userid'] , PDO::PARAM_STR);
    $request->bindParam('date', $_GET['date'] , PDO::PARAM_STR);
    $request->execute();
    //var_dump($_GET);
    header("Location: home_compta.php");
} catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
}