<?php 

$userID = $_SESSION['userID'];

$etat_par_defaut = "CR";

$saisie_date_fiche_frais = "";
$saisie_qte_etp = "";
$saisie_nb_km = "";
$saisie_nb_nui = "";
$saisie_nb_repas = "";
$saisie_libelle_txt = "";
$saisie_montant = "";
$saisie_nb_justificatifs = "";

$etpID = "ETP";
$kmID = "KM";
$nuiteID = "NUI";
$repasID = "REP";

$query_fiche_frais ="insert into fiche_frais values (:userid, :date, :nbjustificatifs, :montant, :dateModif, :etat)";
$query_ligne_frais_hors_forfait = "insert into ligne_frais_hors_forfait (userID, libelle, date, montant) values (:userid, :libelle, :date, :montant)";
$query_ligne_frais_forfait = "insert into ligne_frais_forfait values (:userid, :date, :forfaitID, :qte)";

    
$saisie_date_fiche_frais = $_SESSION['saisie_date_fiche_frais'];
$saisie_qte_etp = $_SESSION['saisie_qte_etp'];
$saisie_nb_km = $_SESSION['saisie_nb_km'];
$saisie_nb_nui = $_SESSION['saisie_nb_nui'];
$saisie_nb_repas = $_SESSION['saisie_nb_repas'];
$saisie_libelle_txt = $_SESSION['saisie_libelle_txt'];
$saisie_montant = $_SESSION['saisie_montant'];
$saisie_nb_justificatifs = $_SESSION['saisie_nb_justificatifs'];

try{
    $request = $db->prepare($query_fiche_frais); //INSERTION POUR LA TABLE FICHE_FRAIS
    $request->bindParam('userid', $userID , PDO::PARAM_STR);
    $request->bindParam('date', $saisie_date_fiche_frais, PDO::PARAM_STR);
    $request->bindParam('nbjustificatifs', $saisie_nb_justificatifs, PDO::PARAM_STR);
    $request->bindParam('montant', $saisie_montant, PDO::PARAM_STR);
    $request->bindParam('dateModif', $saisie_date_fiche_frais, PDO::PARAM_STR);
    $request->bindParam('etat', $etat_par_defaut, PDO::PARAM_STR);
    $request->execute();
}catch (PDOException $e) {
    $e->getMessage();
}

try{
    $request = $db->prepare($query_ligne_frais_hors_forfait); //INSERTION POUR LA TABLE FICHE_FRAIS_HORS_FORFAIT
    $request->bindParam('userid', $userID , PDO::PARAM_STR);
    $request->bindParam('libelle', $saisie_libelle_txt, PDO::PARAM_STR);
    $request->bindParam('date', $saisie_date_fiche_frais, PDO::PARAM_STR);
    $request->bindParam('montant', $saisie_montant, PDO::PARAM_STR);
    $request->execute();
}catch (PDOException $e) {
    $e->getMessage();
}

//insertion pour chaque etape
try{
    $request = $db->prepare($query_ligne_frais_forfait); //INSERTION POUR LA TABLE FICHE_FRAIS_FORFAIT_ETP
    $request->bindParam('userid', $userID , PDO::PARAM_STR);
    $request->bindParam('date', $saisie_date_fiche_frais, PDO::PARAM_STR);
    $request->bindParam('forfaitID', $etpID, PDO::PARAM_STR);
    $request->bindParam('qte', $saisie_qte_etp, PDO::PARAM_STR);
    $request->execute();
}catch (PDOException $e) {
    $e->getMessage();
}

try{
    $request = $db->prepare($query_ligne_frais_forfait); //INSERTION POUR LA TABLE FICHE_FRAIS_FORFAIT_KM
    $request->bindParam('userid', $userID , PDO::PARAM_STR);
    $request->bindParam('date', $saisie_date_fiche_frais, PDO::PARAM_STR);
    $request->bindParam('forfaitID', $kmID, PDO::PARAM_STR);
    $request->bindParam('qte', $saisie_nb_km, PDO::PARAM_STR);
    $request->execute();
}catch (PDOException $e) {
    $e->getMessage();
}

try{
    $request = $db->prepare($query_ligne_frais_forfait); //INSERTION POUR LA TABLE FICHE_FRAIS_FORFAIT_NUI
    $request->bindParam('userid', $userID , PDO::PARAM_STR);
    $request->bindParam('date', $saisie_date_fiche_frais, PDO::PARAM_STR);
    $request->bindParam('forfaitID', $nuiteID, PDO::PARAM_STR);
    $request->bindParam('qte', $saisie_nb_nui, PDO::PARAM_STR);
    $request->execute();
}catch (PDOException $e) {
    $e->getMessage();
}

try{
    $request = $db->prepare($query_ligne_frais_forfait); //INSERTION POUR LA TABLE FICHE_FRAIS_FORFAIT_REP
    $request->bindParam('userid', $userID , PDO::PARAM_STR);
    $request->bindParam('date', $saisie_date_fiche_frais, PDO::PARAM_STR);
    $request->bindParam('forfaitID', $repasID, PDO::PARAM_STR);
    $request->bindParam('qte', $saisie_nb_repas, PDO::PARAM_STR);
    $request->execute();
}catch (PDOException $e) {
    $e->getMessage();
}

$_SESSION['saisie_date_fiche_frais'] = "";
$_SESSION['saisie_qte_etp'] = "";
$_SESSION['saisie_nb_km'] = "";
$_SESSION['saisie_nb_nui'] = "";
$_SESSION['saisie_nb_repas'] = "";
$_SESSION['saisie_libelle_txt'] = "";
$_SESSION['saisie_montant'] = "";
$_SESSION['saisie_nb_justificatifs'] = "";

header("home.php");
