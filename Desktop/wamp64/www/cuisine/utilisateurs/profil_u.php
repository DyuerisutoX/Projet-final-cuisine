<?php
session_start();

include('../includes/bdd.php');
//verification seession
    if(isset($_SESSION['id']) AND !empty($_SESSION['id']) )    {
        $getid = intval($_SESSION['id']);
        $requser = $bdd->prepare('SELECT id, prenom, nom, mail FROM utilisateurs WHERE id = ?');
        $requser->execute(array($getid));
        $userinfo = $requser->fetch();
?>

<!doctype html>
<html lang="fr">

  <head>
    <meta charset="utf-8">
    <title>Profil</title>
     <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
  </head>

  <body>

    <!--nav -->
    <nav class=" nav nav-dark " style="background-color: #d05c62 ;">
      <ul class="nav">
          <li class="navbar-brand"><img class="img-fluid" src="../img/logo.PNG" width="75px" height="75px" ></li>
          <li class="nav-item"><a class="nav-link" href="profil_u.php">Profil</a></li>
          <li class="nav-item"><a class=" nav-link" href="index.php">Voir les ateliers</a></li>
      </ul>       
  </nav>

   
    <div class="container">
    <div class="row">
       <!-- Profil -->
       <div class="jumbotron"> 
          <div class="col-md-12">
                <p class="form-title orange">Profil de <?php echo $userinfo['prenom'].' '.$userinfo['nom']; ?></p>
                <p>Prénom : <?php echo $userinfo['prenom']; ?></p>

               
            </div>
        </div>
    </div>
    </div>
  </body>

</html>

<?php 
    }else{
        session_destroy();
                    header('Location: login.php'); 
    }
?>