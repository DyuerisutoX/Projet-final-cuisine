<?php
    session_start();

include('../includes/bdd.php');

    if(isset($_GET['id']) AND $_GET['id'] > 0)
    {
        $getid = intval($_GET['id']);
        $requser = $bdd->prepare('SELECT id FROM utilisateurs WHERE id = ?');
        $requser->execute(array($getid));
        $userinfo = $requser->fetch();

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Liste Ateliers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
</head>
<body>


    <!-- Affichage liste sous forme de tableaux -->
    <table border="1">

            <tr>
                <th style="font-weight:bold">Titre</th>
                <th style="font-weight:bold">Description</th>
                <th style="font-weight:bold">Date</th>
                <th style="font-weight:bold">Horaire de début</th>
                <th style="font-weight:bold">Durée</th>
                <th style="font-weight:bold">Places Disponibles</th>
                <th style="font-weight:bold">Places Réservées</th>
                <th style="font-weight:bold">Prix</th>
            </tr>

            <!-- Connexion BDD, table ateliers -->
            
            <?php $reponse = $bdd -> query('SELECT * FROM ateliers WHERE id_cuisinier = '.$getid.'');
            while ($donnees = $reponse -> fetch())
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

                    

                </tr>

            </p>

            <?php } ?>

    </table>
       
</body>
</html>
<?php 
    } 
?>