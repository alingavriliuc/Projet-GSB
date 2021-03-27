<?php 
session_start();
require("db.php");
$_SESSION['activeRadio'] = 1;
$userID = $_SESSION['userID'];
?>
<?php
if(isset($_POST['ajout_fiche_frais_btn'])){ $_SESSION['ajout_fiche_frais_btn'] = $_POST['ajout_fiche_frais_btn']; require("controll_saisie.php"); $_SESSION['activeRadio'] = 3;}
if(isset($_POST['saisie_date_fiche_frais'])){ $_SESSION['saisie_date_fiche_frais'] = $_POST['saisie_date_fiche_frais'];}
if(isset($_POST['saisie_qte_etp'])){ $_SESSION['saisie_qte_etp'] = $_POST['saisie_qte_etp']; }
if(isset($_POST['saisie_nb_km'])){ $_SESSION['saisie_nb_km'] = $_POST['saisie_nb_km']; }
if(isset($_POST['saisie_nb_nui'])){ $_SESSION['saisie_nb_nui'] = $_POST['saisie_nb_nui']; }
if(isset($_POST['saisie_nb_repas'])){ $_SESSION['saisie_nb_repas'] = $_POST['saisie_nb_repas']; }
if(isset($_POST['saisie_libelle_txt'])){ $_SESSION['saisie_libelle_txt'] = $_POST['saisie_libelle_txt']; }
if(isset($_POST['saisie_montant'])){ $_SESSION['saisie_montant'] = $_POST['saisie_montant']; }

$msge = "";

if(isset($_POST["affiche_fiche_frais"])){
  $date_fiche_frais = $_POST["date_fiche_frais"];
  $etpID = "ETP";
  $kmID = "KM";
  $nuiteID = "NUI";
  $repasID = "REP";

  $_SESSION['activeRadio'] = 2;

  $fraisEtape = 0;
  $fraisKM = 0;
  $fraisNuite = 0;
  $fraisRepas = 0;
  
  $nbJustificatifs =0;
  $etatFicheFrais =0;


  $query_frais_etape = "select (prix*qte) as somme from ligne_frais_forfait join forfait on forfaitID = forfait.id join users on userid = users.id where forfait.id=:fraisid and userid=:userid and date=:date";
  $query_frais_km = "select (prix*qte) as somme from ligne_frais_forfait join forfait on forfaitID = forfait.id join users on userid = users.id where forfait.id=:fraisid and userid=:userid and date=:date";
  $query_frais_nuite = "select (prix*qte) as somme from ligne_frais_forfait join forfait on forfaitID = forfait.id join users on userid = users.id where forfait.id=:fraisid and userid=:userid and date=:date";
  $query_frais_repas =  "select (prix*qte) as somme from ligne_frais_forfait join forfait on forfaitID = forfait.id join users on userid = users.id where forfait.id=:fraisid and userid=:userid and date=:date";

  $query_nb_justificatifs = "select nbJustificatifs from fiche_frais where userid=:userid and date=:date";
  $query_etat_ffrais = "select idEtat from fiche_frais where userid=:userid and date=:date";

  try {
    $request = $db->prepare($query_frais_etape);
    $request->bindParam('fraisid', $etpID , PDO::PARAM_STR);
    $request->bindParam('userid', $userID, PDO::PARAM_STR);
    $request->bindParam('date', $date_fiche_frais, PDO::PARAM_STR);
    $request->execute();
    $res = $request->fetch(PDO::FETCH_ASSOC);
    if(!empty($res)) {
      $fraisEtape = $res['somme'];
    } else {
      $msge = "Fiche frais non trouvé ".$etpID." ".$userID." ".$date_fiche_frais;
    }
  } catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
  }

  try {
    $request = $db->prepare($query_frais_km);
    $request->bindParam('fraisid', $kmID , PDO::PARAM_STR);
    $request->bindParam('userid', $userID, PDO::PARAM_STR);
    $request->bindParam('date', $date_fiche_frais, PDO::PARAM_STR);
    $request->execute();
    $res = $request->fetch(PDO::FETCH_ASSOC);
    if(!empty($res)) {
      $fraisKM = $res['somme'];
    } else {
      $msge = "Fiche frais non trouvé ".$etpID." ".$userID." ".$date_fiche_frais;
    }
  } catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
  }

  try {
    $request = $db->prepare($query_frais_nuite);
    $request->bindParam('fraisid', $nuiteID , PDO::PARAM_STR);
    $request->bindParam('userid', $userID, PDO::PARAM_STR);
    $request->bindParam('date', $date_fiche_frais, PDO::PARAM_STR);
    $request->execute();
    $res = $request->fetch(PDO::FETCH_ASSOC);
    if(!empty($res)) {
      $fraisNuite = $res['somme'];
    } else {
      $msge = "Fiche frais non trouvé ".$etpID." ".$userID." ".$date_fiche_frais;
    }
  } catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
  }

  try {
    $request = $db->prepare($query_frais_repas);
    $request->bindParam('fraisid', $repasID , PDO::PARAM_STR);
    $request->bindParam('userid', $userID, PDO::PARAM_STR);
    $request->bindParam('date', $date_fiche_frais, PDO::PARAM_STR);
    $request->execute();
    $res = $request->fetch(PDO::FETCH_ASSOC);
    if(!empty($res)) {
      $fraisRepas = $res['somme'];
    } else {
      $msge = "Fiche frais non trouvé ".$etpID." ".$userID." ".$date_fiche_frais;
    }
  } catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
  }

  try {
    $request = $db->prepare($query_nb_justificatifs);
    $request->bindParam('userid', $userID, PDO::PARAM_STR);
    $request->bindParam('date', $date_fiche_frais, PDO::PARAM_STR);
    $request->execute();
    $res = $request->fetch(PDO::FETCH_ASSOC);
    if(!empty($res)) {
      $nbJustificatifs = $res['nbJustificatifs'];
    } else {
      $msge = "Fiche frais non trouvé ".$etpID." ".$userID." ".$date_fiche_frais;
    }
  } catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
  }

  
}
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>GSB</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="../css/homestyle.css">

</head>
<body>


<div class="layout">

  <input name="nav" type="radio" class="nav home-radio" id="home" <?php if($_SESSION['activeRadio'] == 1){echo "checked";} ?>/>
  <div class="page home-page">
    <div class="page-contents">
      <h1>Bienvenue 
      <?php 
      if(isset($_SESSION['userPrenom'])){
        echo $_SESSION['userPrenom'];
      }
      ?>
      </h1>
    </div>
  </div>
  <label class="nav" for="home">
    <span>Accueil</span>
  </label>

  <input name="nav" type="radio" class="consulter-radio" id="consulter" <?php if($_SESSION['activeRadio'] == 2){echo "checked";} ?>/>
  <div class="page consulter-page">
    <div class="page-contents">
    <form class="input_date_form" method="post" id="loginForm" style="margin-bottom:0.2rem; float:right;">
      <div class="input_date" id="date_selector">
        <h4 for="fiche_frais_date">Sélectionner une date :
        <input type="date" id="date_fiche_frais" name="date_fiche_frais" required>
        <input type="submit" name="affiche_fiche_frais"></h4>
      </div>
    </form>
    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>Justificatifs</th>
          <th>Frais etape</th>
          <th>Frais Km</th>
          <th>frais nuitée</th>
          <th>Frais repas</th>
          <th>Hors forfait</th>
          <th>Total</th>
          <th>Etat</th>
        </tr>
      <thead>
      <tbody>
        <tr>
          <td><?php if(isset($date_fiche_frais)){echo $date_fiche_frais;} ?></td>
          <td><?php if(isset($nbJustificatifs)){echo $nbJustificatifs;} ?></td>
          <td><?php if(isset($fraisEtape)){echo $fraisEtape ."€ ";} ?></td>
          <td><?php if(isset($fraisKM)){echo $fraisKM ."€ ";} ?></td>
          <td><?php if(isset($fraisNuite)){echo $fraisNuite ."€ ";} ?></td>
          <td><?php if(isset($fraisRepas)){echo $fraisRepas ."€ ";} ?></td>
        </tr>
        
      </tbody>
    </table>
      </div>
  </div>
  <label class="nav" for="consulter">
    <span>Consulter</span>
    </label>

  <input name="nav" type="radio" class="saisir-radio" id="saisir" <?php if($_SESSION['activeRadio'] == 3){echo "checked";} ?> />
  <div class="page saisir-page">
    <div class="page-contents">
    
    <form action="" method="post">
    <?php if(isset($_SESSION['msg_saiie'])){echo $_SESSION['msg_saiie']."<br><br><br>";} ?>
    <div class="corpsForm">
          <input type="hidden" name="etape" value="validerAjoutLigneHF" />
          <fieldset>
            <legend>Nouvelle fiche
            </legend>
            <p>
              <label for="date_date">* Date : </label>
              <input type="date" id="txtDateHF" name="saisie_date_fiche_frais" size="12" maxlength="10" />
            </p>
            <p>
              <label for="qte_etp">* Qte. Etape : </label>
              <input type="text" id="txtMontantHF" name="saisie_qte_etp" size="12" maxlength="10" />
            </p>
            <p>
              <label for="qte_km">* Nb. KM : </label>
              <input type="text" id="txtMontantHF" name="saisie_nb_km" size="12" maxlength="10" />
            </p>
            <p>
              <label for="qte_nui">* Nb. Nuits : </label>
              <input type="text" id="txtMontantHF" name="saisie_nb_nui" size="12" maxlength="10" />
            </p>
            <p>
              <label for="qte_rep">* Nb. Repas : </label>
              <input type="text" id="txtMontantHF" name="saisie_nb_repas" size="12" maxlength="10" />
            </p>
          </fieldset>
      </div>
     <br>
      <div class="corpsForm">
          <input type="hidden" name="etape" value="validerAjoutLigneHF" />
          <fieldset>
            <legend>Nouvel élément hors forfait
            </legend>
            <p>
              <label for="txtLibelleHF">Libellé : </label>
              <input type="text" id="txtLibelleHF" name="saisie_libelle_txt" size="70" maxlength="100"/>
            </p>
            <p>
              <label for="txtMontantHF">Montant : </label>
              <input type="text" id="txtMontantHF" name="saisie_montant" size="12" maxlength="10"/>
            </p>
          </fieldset>
      </div>
      <div class="piedForm">
      <p>
        <input id="ajouter" type="submit" value="Ajouter" size="20" name="ajout_fiche_frais_btn"/>
      </p>
      </div>
    </form>

    </div>
  </div>
  <label class="nav" for="saisir">
    <span>Saisir</span>
  </label>

  <input name="nav" type="radio" class="logout-radio" id="logout" onclick="location.href='logout.php'"/>
  <label class="nav" for="logout" id="logout">
    <span><img src="/images/logout.png" alt="logout" style="height:20px; width:20px; opacity:0.8;"></span>
  </label>


</div>
</body>
</html>
