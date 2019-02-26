<?php
//connexion bdd
try{
$bdd = New PDO('mysql:host=localhost;dbname=cuisine;charset=utf8', 'root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
$req=$bdd->query('SELECT * FROM ateliers');
//traitement formulaire
//var_dump($_POST);
if(isset($_POST['form_ajout_ateliers']))
    {
        //stock mes valeurs des $_POST
        $titres = htmlspecialchars($_POST['ajout_titres']);
        $descriptif = htmlspecialchars($_POST['ajout_descriptif']);
        $date = htmlspecialchars(date("Y-m-d", strtotime($_POST['ajout_date'])));
        /*var_dump($date);
        die();*/
        $times = htmlspecialchars($_POST['ajout_times']); //null; 
        $duree = htmlspecialchars($_POST['ajout_duree']); //null; 
        $dispo = htmlspecialchars($_POST['ajout_dispo']);
        $reserver = htmlspecialchars($_POST['ajout_reserver']);
        $prix = htmlspecialchars($_POST['ajout_prix']);

        /*$roles = htmlspecialchars($_POST['id']);*/
       // var_dump(isset($titres).isset($descriptif).isset($date).isset($times).isset($duree).isset($dispo).isset($reserver).isset($prix));
        //Vérifier existence et si non vide
        
        if (isset($titres) AND isset($descriptif) AND isset($date)
            AND isset($times) AND isset($duree) AND isset($dispo) AND isset($reserver) AND isset($prix)
            )                                    
        {          
            //prepare insert into pour envoyer des données dans la BDD
            $ateliers = $bdd -> prepare('INSERT INTO ateliers (titre, descriptif, date_atelier, debut, duree, places_dispo, places_reserver, prix) VALUES (?,?,?,?,?,?,?,?)');
            $ateliers ->execute(array($titres, $descriptif, $date, $times, $duree, $dispo, $reserver, $prix));
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