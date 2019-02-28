<?php
    session_start();

include('../includes/bdd.php');

    if(isset($_SESSION['id']) AND !empty($_SESSION['id']) )
    {
        $getid = intval($_SESSION['id']);
        $reponse = $bdd -> query('SELECT * FROM ateliers WHERE id_cuisinier = '.$getid.'');
      

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Liste Ateliers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/style.css" />
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
    <!-- Affichage liste sous forme de tableaux -->
    <table class="table">

            <tr>
                <th class="orange" style="font-weight:bold">Titre</th>
                <th class="orange" style="font-weight:bold">Description</th>
                <th class="orange"style="font-weight:bold">Date</th>
                <th class="orange" style="font-weight:bold">Horaire de début</th>
                <th class="orange" style="font-weight:bold">Durée</th>
                <th class="orange" style="font-weight:bold">Places Disponibles</th>
                <th class="orange" style="font-weight:bold">Places Réservées</th>
                <th class="orange" style="font-weight:bold">Prix</th>
                <th class="orange" style="font-weight:bold">Editer</th>
                <th class="orange" style="font-weight:bold">Activités</th>
            </tr>

            <!-- Connexion BDD, table ateliers -->
            
            <?php while ($donnees = $reponse -> fetch())
            {?>

            <p>
                <!-- Affichage en php des données -->
                <tr>
                    <td><?php echo $donnees['titre'];?></td>
                    <td><?php echo $donnees['descriptif'];?></td>
                    <td><?php echo $donnees['date_atelier'];?></td>
                    <td><?php echo $donnees['debut'];?></td>
                    <td><?php echo $donnees['duree'];?></td>
                    <td><?php echo $donnees['places_dispo'];?></td>
                    <td><?php echo $donnees['places_reserver'];?></td>
                    <td><?php echo $donnees['prix'];?></td>
                    <td><a href="edit_atelier.php?edit=<?php echo $donnees['id'] ?>">Editer</a></td>
                    <td><a href="edit_atelier.php?edit=<?php echo $donnees['id'] ?>">Désactiver</a></td>
                    

                </tr>

            </p>

            <?php } ?>

    </table>
       
</body>
</html>
<?php 
    } 
?>