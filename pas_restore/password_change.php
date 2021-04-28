<?php 
  session_start();
  require("../php/db.php");

  $email = $_SESSION['userMail'];
?>

<!doctype html>
<html lang="fr">
  <head>
    <title>Entrez un nouveau mot de passe</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
        <div class="container">
          <div class="col-11">
              <div class="card text-center m-4 shadow p-3 mb-5 bg-white rounded">
                <div class="card-body">
                  <h4 class="card-title p-3">Entrez un nouveau mot de passe :</h4>
                    <div class="form-group">
                        <form action="recover.php" method="POST">
                          <p class="font-weight-bold"><i><?php if(isset($email)){echo $email;} ?></i></p>
                          <br>
                          <input type="password" name="password" class="form-control" placeholder="Nouveau mot de passe" required />
                          <br />
                          <input type="password" name="password_repeat" class="form-control" placeholder="Repetez le mote de passe" required />
                          <br>
                          <button type="submit" class="btn btn-primary btn-lg m-3">Modifier -></button>
                        </form>

                        
                        <p class="text-danger"><?php if(isset($_SESSION['resetPSW_msg'])){echo $_SESSION['resetPSW_msg'];} ?></p>
                        <p class="text-success"><?php if(isset($_SESSION['reset_succes'])){echo $_SESSION['reset_succes']. "<br><a href=\"../index.php\"> Revenir à la page principale</a>";} ?></p>
                    </div>
                </div>
              </div>
          </div>
      </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>