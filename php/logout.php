<?php
session_start();
$_SESSION['userID'] = "";
$_SESSION['username'] = "";
$_SESSION['userEmail'] = "";
$_SESSION['userNom'] =  "";
$_SESSION['userPrenom'] = "";
$_SESSION['userAdresse'] = "";
$_SESSION['userCP'] = "";
if(empty($_SESSION['userID'])) header("location: ../index.php");
?>