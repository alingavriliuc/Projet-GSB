<?php 
session_start();
$msg ="";

//partie pour controller la saisie de la fiche d'enregistrement
if(isset($_POST['btn_register'])){
  if(strcmp($_POST['password'], $_POST['password2']) !== 0){
    
    $msg = "Les mote de passe ne correspondent pas";

  }else{    
    if(isset($_POST['nom'])){ $_SESSION['nom'] = $_POST['nom']; }
    if(isset($_POST['prenom'])){ $_SESSION['prenom'] = $_POST['prenom']; }
    if(isset($_POST['adresse'])){ $_SESSION['adresse'] = $_POST['adresse']; }
    if(isset($_POST['cp'])){ $_SESSION['cp'] = $_POST['cp']; }
    if(isset($_POST['email'])){ $_SESSION['email'] = $_POST['email']; }
    if(isset($_POST['username'])){ $_SESSION['login'] = $_POST['username']; }
    if(isset($_POST['password'])){ $_SESSION['password'] = $_POST['password']; }
    //une fois les informatiosn mises dans des variables de session on les envoye au fichier valider_inscription.php
    header("Location: valider_inscription.php");
  }
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/regist_style.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>

<body>
  <div class="container">
    <?php if(isset($msg)){echo $msg;} ?>
    <div id ="Inscription" class="title">Inscription</div>
    <div class="content">
      <form action="" method="post">
        <div class="user-details">

          <div class="input-box">
            <span class="details">Nom</span>
            <input name ="nom" type="text" placeholder="Votre nom" required>
          </div>

          <div class="input-box">
            <span class="details">Prénom</span>
            <input name ="prenom" type="text" placeholder="Votre prénom" required>
          </div>

          <div class="input-box">
            <span class="details">Adresse</span>
            <input name ="adresse" type="adress" placeholder="Votre adresse" required>
          </div>

          <div class="input-box">
            <span class="details">Code Postal</span>
            <input name ="cp" type="text" placeholder="Code postal" required>
          </div>

          <div class="input-box">
            <span class="details">Adresse-mail</span>
            <input name ="email" type="email" placeholder="Email" required>
          </div>
          <div class="input-box">
            <span class="details">Login</span>
            <input name ="username" type="login" placeholder="Votre login" required>
          </div>

          <div class="input-box">
            <span class="details">Mot de passe </span>
            <input name ="password" type="password" placeholder="mot de passe" required>
          </div>

          <div class="input-box">
            <span class="details">Repetez le mot de passe </span>
            <input name ="password2" type="password" placeholder="repetez votre mot de passe" required>
          </div>

  
        </div>
        <div class="button">
          <input type="submit" value="S'inscrire" name="btn_register">

        </div>

        <div class="go_home_btn">
          <a href="../index.php"> Retour page de connexion </a>
        </div>

      </form>
    </div>
  </div>
  </a>
 




  <script>

    let Inscription= document.getElementById("Inscription");
    Inscription.style.fontStyle="italic";
    Inscription.style.fontWeight="bold";

    </script>

</body>

</html>
