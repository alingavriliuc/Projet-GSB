<?php 
session_start();
include("db.php");
$_SESSION['activeRadio'] = 1;
$userID = $_SESSION['userID'];
?>
<?php
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
      <h1>Contact</h1>
      <p>Eaque accusamus magnam error unde nam, atque provident omnis fugiat quam necessitatibus vel nulla sed quibusdam fuga veritatis assumenda alias quidem asperiores?</p>
      <p><a href="#">Get in touch</a></p>
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
