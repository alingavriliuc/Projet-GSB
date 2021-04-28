<?php 
session_start();
require("./php/db.php");

$_SESSION['reset_succes'] = "";
$_SESSION['resetPSW_msg'] = "";
?>
<?php
$msg = ""; 
if(isset($_POST['submitButton'])) {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $user_visiteur = "visiteur";
  if($username != "" && $password != "") {
    try {
      $query = "select * from users where username=:username";
      $stmt = $db->prepare($query);
      $stmt->bindParam('username', $username, PDO::PARAM_STR);
      $stmt->execute();
      $count = $stmt->rowCount();
      $row   = $stmt->fetch(PDO::FETCH_ASSOC);
      if(password_verify($password, $row['password'])) {
		$_SESSION['userID'] = $row['id'];
        $_SESSION['username'] = $row['username'];
		$_SESSION['userEmail'] = $row['email'];
		$_SESSION['userNom'] =  ucfirst($row['nom']);
		$_SESSION['userPrenom'] =  ucfirst($row['prenom']);
		$_SESSION['userAdresse'] = $row['adresse'];
		$_SESSION['userCP'] = $row['cp'];
		$_SESSION['userFonction'] = $row['fonction'];
		if(isset($_SESSION['userFonction'])){
			if($_SESSION['userFonction'] === "visiteur"){header("Location: ./php/home.php");}else{header("Location: ./php/home_compta.php");}
		}
      } else {
        $msg = "Identifiant ou mot de passe incorrct";
      }
    } catch (PDOException $e) {
      echo "Error : ".$e->getMessage();
    }
  } else {
    $msg = "Both fields are required!";
  }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<title>GSB</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post" id="loginForm">
				<div style="color:red;text-align:center;">
				<?php echo '<center>'.$msg.'</center><br>';?>
				</div>
				<div style="color:green;text-align:center;">
					<?php 
					if(isset($_SESSION['msg_reg'])){
						echo '<center>'.$_SESSION['msg_reg'].'</center><br>';
					   } 
					?>
				</div>
					<span class="login100-form-title p-b-26">
						Bienvnue
					</span>
					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="username" required>
						<span class="focus-input100" data-placeholder="Identifiant" aria-required="true"></span>
					</div>

					<div class="wrap-input100 validate-input">
						<input class="input100" type="password" name="password" required>
						<span class="focus-input100" data-placeholder="Mot de passe"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit" form="loginForm" name="submitButton" value="Login">
								S'identifier
							</button>
						</div>
					</div>

					<div class="text-center p-t-115">
						<a class="txt2" href="php/inscription.php">
							Créer un nouveau compte ?
						</a>
						<br>
						<a class="txt2" href="pas_restore/restauration.php">
							Mot de passe oublié ?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>