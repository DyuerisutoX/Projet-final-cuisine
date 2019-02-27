<?php
session_start();

include('includes/bdd.php');

    if(isset($_SESSION['id']) AND !empty($_SESSION['id']) )
    {
        $getid = intval($_SESSION['id']);
        $requser = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
        $requser->execute(array($getid));
        $userinfo = $requser->fetch();
?>

<!doctype html>
<html lang="fr">

  <head>
    <meta charset="utf-8">
    <title>Profil</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  </head>

  <body>
    <div class="container">
    <div class="row">

      <nav>
        <ul>
          <li><a href="ateliers/profil.php?id='.$getid.'">Voir les ateliers</a></li>
          <li><a href="ateliers/index.php">Ajouter un atelier</a></li>
        </ul>
      </nav>
       <div class="jumbotron"> 
          <div class="col-md-12">
                <p class="form-title">Profil de <?php echo $userinfo['prenom'].' '.$userinfo['nom']; ?></p>
                <p>Prénom : <?php echo $userinfo['prenom']; ?></p>
                <p>Mail : <?php echo $userinfo['mail']; ?></p>

                <?php
                   if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'])
                   {
                ?>
                <p><a href="editionprofil.php">Editer mon profil</a></p>
                <p><a href="deconnexion.php">Se déconnecter</a></p>
                <?php
                   }else{
                    session_destroy();
                    header('Location: login.php'); }
                ?>

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