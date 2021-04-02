<?php 
session_start();
require("db.php"); 
$_SESSION['activeRadio'] = 1;
$userID = $_SESSION['userID'];

$userName ="";
$tempUserID = 0;

?>
<?php
if(isset($_POST['ajout_fiche_frais_btn'])){$_SESSION['activeRadio'] = 3;require("controll_saisie.php");}
if(isset($_POST['saisie_date_fiche_frais'])){ $_SESSION['saisie_date_fiche_frais'] = $_POST['saisie_date_fiche_frais'];}
if(isset($_POST['saisie_qte_etp'])){ $_SESSION['saisie_qte_etp'] = $_POST['saisie_qte_etp']; }
if(isset($_POST['saisie_nb_km'])){ $_SESSION['saisie_nb_km'] = $_POST['saisie_nb_km']; }
if(isset($_POST['saisie_nb_nui'])){ $_SESSION['saisie_nb_nui'] = $_POST['saisie_nb_nui']; }
if(isset($_POST['saisie_nb_repas'])){ $_SESSION['saisie_nb_repas'] = $_POST['saisie_nb_repas']; }
if(isset($_POST['saisie_libelle_txt'])){ $_SESSION['saisie_libelle_txt'] = $_POST['saisie_libelle_txt']; }else{$_SESSION['saisie_libelle_txt'] = null;}
if(isset($_POST['saisie_montant'])){ $_SESSION['saisie_montant'] = $_POST['saisie_montant']; }else{$_SESSION['saisie_montant'] = null;}
if(isset($_POST['saisie_nb_justificatifs'])){ $_SESSION['saisie_nb_justificatifs'] = $_POST['saisie_nb_justificatifs']; }

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
  $nbJustificatifs = 0;
  $etatFicheFrais = 0;
  $montantHorsForfait = 0;


  $query_frais_etape = "select (prix*qte) as somme from ligne_frais_forfait join forfait on forfaitID = forfait.id join users on userid = users.id where forfait.id=:fraisid and userid=:userid and date=:date";
  $query_frais_km = "select (prix*qte) as somme from ligne_frais_forfait join forfait on forfaitID = forfait.id join users on userid = users.id where forfait.id=:fraisid and userid=:userid and date=:date";
  $query_frais_nuite = "select (prix*qte) as somme from ligne_frais_forfait join forfait on forfaitID = forfait.id join users on userid = users.id where forfait.id=:fraisid and userid=:userid and date=:date";
  $query_frais_repas =  "select (prix*qte) as somme from ligne_frais_forfait join forfait on forfaitID = forfait.id join users on userid = users.id where forfait.id=:fraisid and userid=:userid and date=:date";

  $query_nb_justificatifs = "select nbJustificatifs from fiche_frais where userid=:userid and date=:date";
  $query_etat_ffrais = "select idEtat from fiche_frais where userid=:userid and date=:date";

  $query_montant_hors_forfait = "select montant from ligne_frais_hors_forfait where userID=:userid and date=:date";

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

  try {
    $request = $db->prepare($query_etat_ffrais);
    $request->bindParam('userid', $userID, PDO::PARAM_STR);
    $request->bindParam('date', $date_fiche_frais, PDO::PARAM_STR);
    $request->execute();
    $res = $request->fetch(PDO::FETCH_ASSOC);
    if(!empty($res)) {
      $etatFicheFrais = $res['idEtat'];
    } else {
      $msge = "Fiche frais non trouvé ".$etpID." ".$userID." ".$date_fiche_frais;
    }
  } catch (PDOException $e) {
    echo "Error : ".$e->getMessage();
  }

  try {
    $request = $db->prepare($query_montant_hors_forfait);
    $request->bindParam('userid', $userID, PDO::PARAM_STR);
    $request->bindParam('date', $date_fiche_frais, PDO::PARAM_STR);
    $request->execute();
    $res = $request->fetch(PDO::FETCH_ASSOC);
    if(!empty($res)) {
      $montantHorsForfait = $res['montant'];
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
  <link rel="stylesheet" href="../css/homestyle_compta.css">

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
          <th>Nom </th>
          <th>Date</th>
          <th>Justificatifs</th>
          <th>Montant</th>
          <th>Etat</th>
          <th></th>
        </tr>
      <thead>
      <tbody>
        <tr>
          <?php
            $stmt = $db->query('Select * from fiche_frais'); 
            //$stmt = $db->query('Select * from fiche_frais where idEtat = "CR"');
            foreach($stmt as $row){
            ?>
            <tr>
              <?php 
                try {
                  $request = $db->prepare('select nom from fiche_frais join users on userid=users.id where userid=:userid');
                  $request->bindParam('userid', $row['userid'] , PDO::PARAM_STR);
                  $request->execute();
                  $res = $request->fetch(PDO::FETCH_ASSOC);
                  if(!empty($res)) {
                    $userName = $res['nom'];
                  } else {
                    $msge = "Fiche frais non trouvé ".$etpID." ".$userID." ".$date_fiche_frais;
                  }
                } catch (PDOException $e) {
                  echo "Error : ".$e->getMessage();
                }
              ?>
              <td><?php echo $userName; ?></td>
              <td><?php echo $row['date']; ?></td>
              <td><?php echo $row['nbJustificatifs']; ?></td>
              <td><?php echo $row['montantValide']; ?></td>
              <td><?php echo $row['idEtat']; ?></td>
              <?php 
                if($row['idEtat'] == "CR"){
                  echo '<form method="post"><td><input type="submit" name="valder_fiche" value="valider cette fiche"></td></form>';
                }
              ?>
            </tr>
            <?php
            }
          ?>
        </tr>
        
      </tbody>
    </table>
      </div>
  </div>
  <label class="nav" for="consulter">
    <span>Consulter</span>
    </label>


  <input name="nav" type="radio" class="logout-radio" id="logout" onclick="location.href='logout.php'"/>
  <label class="nav" for="logout" id="logout">
    <span><img src="/images/logout.png" alt="logout" style="height:20px; width:20px; opacity:0.8;"></span>
  </label>


</div>
</body>
</html>
