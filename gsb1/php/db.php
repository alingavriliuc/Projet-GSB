<?php
try{
	$bdd = new PDO('mysql:host=localhost;dbname=gsb_db;charset=utf8mb4', 'root', 'root');
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  	$bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
}catch(PDOException $error){
	echo "Erreur de conection" . $error->getMessage();
}
?>