<?php
    session_start();

include('../includes/bdd.php');
	
	/**
	 * une fonction qui va regarder dans la table utilisateurs_ateliers si l'utilisateur n'a pas deja reservé.
	 * @param $user_id = int
	 * @return $present = bool
	 * @author Adeline
	 **/
	function check_user_reservation($user_id = null, $atelier_id = null){
		$present = false; //initilise la variable a faux, par defaut il n'est pas present

		//todo prendre $user_id et check si il y a une entree pour lui a $atelier_id
		//Faire une requette select pour chercher si on trouve un enregistrement
		//si il y a un enregistrement pour cet user pour cet atelier ça ve dire quil est inscrit
		//donc present = true

		//Si l'utilisateur est present on passe $present a vrai
		//$present = true;

		
		
		//on retourne le resultat
		return $present;
	}

	$reponse = $bdd -> query('SELECT * FROM ateliers');

    if(isset($_SESSION['id']) AND !empty($_SESSION['id']) )
    {

     if (isset($_GET['res']) AND !empty($_GET['res']) ) {

        $getid = intval($_SESSION['id']); //recup l id utilisateur
        $res = intval($_GET['res']); //id atelier

    	//Todo : check si l utilisateur n'est pas deja inscrit a l 'atelier
    	//on appel la fonction que verifi la presence
    	$present = check_user_reservation($getid, $res );//$present va contenir true ou false

        



        //On doit regarder dans l'atelier l'info places_reserver
        $atelier_selected =  $bdd ->prepare('SELECT places_reserver FROM ateliers WHERE id = ?');
        $atelier_selected->execute(array($res));

        //on recupere le int dans places_reserver
        $selected = $atelier_selected->fetchAll();
        //on met la valeur dans une variable
        $places_reserver = $selected[0]['places_reserver'];

        //on reserve pour l utilisateur que si il n'est pas present
        //on va utiliser : if($present) pour faire le try
        try{
        	$reservation = $bdd->prepare('INSERT INTO utilisateurs_ateliers (id_utilisateur, id_atelier) VALUES (? , ?) ');
        	//si la reservation ce passe bien on incremente places_reserver dans l'atelier concerné
        	if ($reservation->execute(array($getid, $res) )) {
        		//requette qui va mettre a jour le champ places_reserver avec la valeur passé + 1
        		$places_reserver_requette = $bdd->prepare('UPDATE ateliers SET places_reserver = ? WHERE id = ?');
        		
        		//var_dump($places_reserver);

        		//incrementation ici
        		$places_reserver++;
        		//var_dump($places_reserver);

        		//on execute la requette
        		$places_reserver_requette->execute(array($places_reserver, $res));

        		//on peu savoir que la requette a fonctioner en verifiant le nombre de ligne affecté par notre requette d'update
        		//si $updated = 0 => Pas bon, si $updated = 1 => bon
        		$updated = $places_reserver_requette->rowCount();

        		//var_dump($updated);
        	}
        	
        } catch (Exception $e){
        	//gerer les erreurs
        	print_r($e);
        }
        
    } 
  

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
		<li class="nav-item"><a class="nav-link" href="profil_u.php">Profil</a></li>
		<li class="nav-item"><a class=" nav-link" href="index.php">Voir les ateliers</a></li>
	</ul>		
</nav>
<main>
	<section>
		<article class="container-fluid">
			<?php while ($donnees = $reponse -> fetch() ) :
				if($donnees['actif'] == 1) :
            ?>
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
			    <a href="index.php?res=<?= $donnees['id']; ?>" class="btn btn-primary">s'inscrire</a>
			  </div>
			  
			</div>
			<?php endif; endwhile; ?>
		</article>
	</section>
</main>
  
       
</body>
</html>
<?php 
    } 
?>