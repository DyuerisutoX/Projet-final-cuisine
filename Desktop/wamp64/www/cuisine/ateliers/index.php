<?php 
session_start();

include('../includes/bdd.php');
 $getid = intval($_SESSION['id']);
    if(isset($getid) AND !empty($getid) )
    {
       
        $requser = $bdd->prepare('SELECT id FROM utilisateurs WHERE id = ?');
        $requser->execute(array($getid));
        $userinfo = $requser->fetch();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ateliers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/style.css">

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
   <?php
    if(isset($_POST['form_ajout_ateliers']))
    {
        //stock mes valeurs des $_POST
        $titres = htmlspecialchars($_POST['ajout_titres']);
        $descriptif = htmlspecialchars($_POST['ajout_descriptif']);
        $date = htmlspecialchars(date("Y-m-d", strtotime($_POST['ajout_date'])));
       
        $times = htmlspecialchars($_POST['ajout_times']); //null; 
        $duree = htmlspecialchars($_POST['ajout_duree']); //null; 
        $dispo = htmlspecialchars($_POST['ajout_dispo']);
        $reserver = htmlspecialchars($_POST['ajout_reserver']);
        $prix = htmlspecialchars($_POST['ajout_prix']);

        
        //Vérifier existence et si non vide
        
        if (isset($titres) AND isset($descriptif) AND isset($date)
            AND isset($times) AND isset($duree) AND isset($dispo) AND isset($reserver) AND isset($prix) AND isset($getid)
            )                                    
        {          
            //prepare insert into pour envoyer des données dans la BDD
            $ateliers = $bdd -> prepare('INSERT INTO ateliers (titre, descriptif, date_atelier, debut, duree, places_dispo, places_reserver, prix, id_cuisinier) VALUES (?,?,?,?,?,?,?,?, ?)');
            $ateliers ->execute(array($titres, $descriptif, $date, $times, $duree, $dispo, $reserver, $prix, $getid));

            $message ='donnees bien enregistrer!';  
        }

        else
        {
                     $message ='Saisi incorrect.';
        }
    }
    else
    {
      $message = 'Tous les champs doivent être complétés.';
    }
    ?>
<form action=" " style="align:center" method="POST">
        <!-- Titre -->
        <div class="form-group">
            <label for="ajout_titres">Titre : </label>
            <input class="" type="text" name="ajout_titres" placeholder="titres">
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="ajout_descriptif">descriptif : </label>
            <input   type="text" name="ajout_descriptif" placeholder="descriptif">
        </div>

        <!-- Date -->
        <div class="form-group">
            <label for="ajout_date">Date : </label>
            <input type="text" name="ajout_date" placeholder="date">
        </div>

        <!-- Horaire de début -->
        <div class="form-group">
            <!-- to do : à rectifier le type de la date dans la BDD -->
            <label for="ajout_times">Horaire de debut : </label>
            <input type="text" name="ajout_times" placeholder="horaire du debut">
        </div>

        <!-- Durée -->
        <div class="form-group">
            <!-- to do : à rectifier le type de la date dans la BDD -->
            <label for="ajout_duree">Durée : </label>
            <input type="text" name="ajout_duree" placeholder="la duree">
        </div>

        <!-- Place Disponible -->
        <div class="form-group">
            <label for="ajout_dispo">Place Dispo. : </label>
            <input type="number" name="ajout_dispo" placeholder="place dispo">
        </div>

        <!-- Places Réserver -->
        <div class="form-group">
            <label for="ajout_reserver">Place Réserver : </label>
            <input type="number" name="ajout_reserver" placeholder="place reserver">
        </div>

        <!-- Prix -->
        <div class="form-group">
            <label for="ajout_prix">Prix : </label>
            <input type="number" name="ajout_prix" placeholder="prix">
        </div>

        <button type="submit" class="btn  mb-2 btn-o" name="form_ajout_ateliers" value="ajouter un ateliers">ajouter</button>
      
	</form>

    <?php if(isset($message)): ?>
         
        <span class="alert">
            <?php echo $message; ?>
        </span>
        <?php endif;?>

</body>
</html>
<?php 
    }else{
        session_destroy();
        header('Location: ../login.php'); 
    }  
?>