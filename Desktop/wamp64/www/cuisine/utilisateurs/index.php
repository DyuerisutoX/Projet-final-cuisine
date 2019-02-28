<?php
    session_start();

include('../includes/bdd.php');

    if(isset($_SESSION['id']) AND !empty($_SESSION['id']) )
    {
        $getid = intval($_SESSION['id']);
        $reponse = $bdd -> query('SELECT * FROM ateliers');
      

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Liste Ateliers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../css/style.css" />
   
</head>
<body>
<nav class=" nav nav-dark " style="background-color: #d05c62 ;">
	<ul class="nav">
		<li class="navbar-brand"><img class="img-fluid" src="../img/logo.PNG" width="75px" height="75px" ></li>
		<li class="nav-item"><a class="nav-link" href="profil.php">Profil</a></li>
		<li class="nav-item"><a class=" nav-link" href="index.php">Voir les ateliers</a></li>
	</ul>		
</nav>
<main>
	<section>
		<article class="container-fluid">
			<?php while ($donnees = $reponse -> fetch())
            {?>
			<div class="card text-center my-2">
			  <div class="card-header orange">
			    <?php echo $donnees['titre'];?>
			  </div>
			  <div class="card-body">
			    <h5 class="card-title"><?php echo $donnees['date_atelier'];?></h5>
			    <p class="card-text"><?php echo $donnees['descriptif'];?></p>
			    <p class="card-text">Débute à  :<?php echo $donnees['debut'];?></p>
			    <p class="card-text">Durée :<?php echo $donnees['duree'];?></p>
			    <p class="card-text">Places Disponibles : <?php echo $donnees['places_dispo'];?></p>
			    <p class="card-text">Places Réservées : <?php echo $donnees['places_reserver'];?></p>
			    <p class="card-text">Prix : <?php echo $donnees['prix'];?></p>
			    <a href="" class="btn btn-primary">Réserver</a>
			  </div>
			  
			</div>
			<?php } ?>
		</article>
	</section>
</main>
  
       
</body>
</html>
<?php 
    } 
?>