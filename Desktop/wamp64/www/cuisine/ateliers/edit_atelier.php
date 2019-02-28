<?php
session_start();

//on include BDD
include('../includes/bdd.php');

//vérification s'il y a une session 
  if(isset($_SESSION['id']) AND !empty($_SESSION['id']) )
    {
    //$getid ne peut être un chiffre      
    $getid = intval($_SESSION['id']);
    
    if(isset($_GET['edit']) AND !empty($_GET['id'])){

      $getedit = intval($_GET['edit']); 

      var_dump($getedit);
      die();
      //on sélectionne tous les ateliers créer par l'utilisateur 
      $edit_ateliers = $bdd->prepare('SELECT * FROM ateliers WHERE id = ?');
      $edit_ateliers->execute(array($getedit));

      }
        if( !empty($_POST['titre']) AND !empty($_POST['descriptif']) AND !empty($_POST['prix']) AND !empty($_POST['date_atelier']) AND !empty($_POST['duree']) AND !empty($_POST['places_dispo']) AND isset($_POST['places_reserver']) )
      {
        //tous les variables des données 
        $titre = htmlspecialchars($_POST['titre']); 
        $descriptif= htmlspecialchars($_POST['descriptif']);
        $prix = intval($_POST['prix']);
        $date_atelier = htmlspecialchars($_POST['date_atelier']);
        $heure = htmlspecialchars($_POST['duree']); 
        $dispo = intval($_POST['places_dispo']); 
        $reserver = intval($_POST['places_reserver']);

        //rêquete pour updater
        $update = $bdd->prepare('UPDATE ateliers SET titre = ?, descriptif = ?, date_atelier = ?, debut = ?,  places_dispo = ?,  places_reserver = ?,  prix = ? ');
        $update->execute(array($titre, $descriptif, $date_atelier, $heure, $dispo, $reserver, $prix));
        header('location: liste.php');
       
      }
    
   
   
?>
<!DOCTYPE html>

<head>
  <meta charset="utf-8">
  <title>EDITION ATELIER</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
</head>
 


<body>
  <nav class=" nav nav-dark " style="background-color: #d05c62 ;">
    <ul class="nav">
        <li class="navbar-brand"><img class="img-fluid" src="../img/logo.PNG" width="75px" height="75px" ></li>
        <li class="nav-item"><a class="nav-link" href="../utilisateurs/profil.php">Profil</a></li>
        <li class="nav-item"><a class=" nav-link" href="index.php">Ajouter un atelier</a></li>
        <li class="nav-item"><a class=" nav-link" href="liste.php">Voir les ateliers</a></li>
    </ul>       
</nav>
  <!-- Navigation-->
  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
        
          <h1>Edition d'atelier</h1>
          <?php while($donnee = $edit_ateliers->fetch()) :
          ?>
          <div class="form-group">
            <form id="form-edit" method="post" action="">
              <label for="titre">Titre :</label>
              <input rows="10" cols="80" class="form-control" type="textarea" placeholder="" value="<?php  echo $donnee['titre']; ?> " name="titre">
              <br>
              <label for="descriptif">descriptif:</label>
              <input rows="10" cols="80" class="form-control" type="textarea" placeholder=""  value="<?php  echo $donnee['descriptif']; ?> " name="descriptif">
              <br>
               <label for="prix">Date atelier :</label>
              <input  rows="10" cols="80" class="form-control" type="text" placeholder="" value="<?php  echo $donnee['date_atelier']; ?>" name="date_atelier">
              <br>

              <label for="duree">duree :</label>
              <input rows="10" cols="80" class="form-control" type="text" placeholder="" value=" <?php  echo $donnee['duree']; ?>"  name="duree">
              <br>
              
              <label for="places_dispo">places disponibles :</label>
              <input rows="10" cols="80" class="form-control" type="text" placeholder=""  value="<?php  echo $donnee['places_dispo'] ; ?> " name="places_dispo">
              <br>

              <label for="places_reserver">places réserver :</label>
              <input rows="10" cols="80" class="form-control" type="text" placeholder=""  value="<?php  echo $donnee['places_reserver']; ?> " name="places_reserver">
              <br>

              <label for="prix">Prix :</label>
              <input rows="10" cols="80" class="form-control" type="text" placeholder="" value="<?php  echo $donnee['prix']; ?> "  name="prix">
              <br>
              
              
              <div class="text-right">
              <input type="submit" class="btn btn-info" value="Editer">
              </div>
            </form> 
          </div>
          <?php 
          endwhile;
          ?>
        </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->

  </div>
</body>

</html>

<?php }else{
session_destroy();
header('location: login.php');
}
  ?>
