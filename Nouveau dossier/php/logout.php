<?php
session_start();
$_SESSION['userID'] = "";
$_SESSION['username'] = "";
$_SESSION['userEmail'] = "";
$_SESSION['userNom'] =  "";
$_SESSION['userPrenom'] = "";
$_SESSION['userAdresse'] = "";
$_SESSION['userCP'] = "";
$_SESSION['activeRadio'] = "";
$_SESSION['msg_saiie'] = "";
$_SESSION['ajout_fiche_frais_btn'] = "";
$_SESSION['saisie_date_fiche_frais'] = "";
$_SESSION['saisie_qte_etp'] = "";
$_SESSION['saisie_nb_km'] = "";
$_SESSION['saisie_nb_nui'] = "";
$_SESSION['saisie_nb_repas'] = "";
$_SESSION['saisie_libelle_txt'] = "";
$_SESSION['saisie_montant'] = "";


if(empty($_SESSION['userID'])) header("location: ../index.php");
?>