<?php 
session_start();
require("db.php"); 
$_SESSION['activeRadio'] = 1;
$_SESSION['msg_reg'] ="";

$userName ="";
$tempUserID = 0;

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
              <td><?php echo $row['userid']; ?></td>
              <td><?php echo $row['date']; ?></td>
              <td><?php echo $row['nbJustificatifs']; ?></td>
              <td><?php echo $row['montantValide']. "€"; ?></td>
              <td><?php echo $row['idEtat']; ?></td>
              <?php 
                if($row['idEtat'] == "CR"){?>
                 <td><a href="update.php?userid=<?=$row['userid']?>&date=<?=$row['date']?>">Valider</a>
                 </td>
                  <?php }
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
    <span><img src="../images/logout.png" alt="logout" style="height:20px; width:20px; opacity:0.8;"></span>
  </label>


</div>
</body>
</html>
