<?php include('includes/bdd.php');

$roles =$bdd->query('SELECT *FROM roles'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>AVD-inscription</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
</head>
<body>
<div align = "center">
    <form id="form-inscription" action="" method="post">

            <h1>Formulaire d'inscription</h1>
          
             <!-- prénom -->
            <div class="form-group">
                    <label>Prénom *</label>            
                    <input type="text" name="ajout_prenom">
            </div>            
                    <label>Nom *</label>            
                    <input type="text" name="ajout_nom">
                    
                    <label>Mail *</label>
            	    <input type="email" name="ajout_mail">
                    
                    <label>Mot de passe *</label>
                    <input type="password" name="ajout_mdp">

                    <label>Confirmation mot de passe *</label>
                    <input type="password" name="ajout_mdp2">

                    <label>Spécialités</label>
                    <input type="text" name="ajout_specialite"  >
            	    
                    <label>Numéro de téléphone</label>
                    <input type="tel" name="ajout_num"  >

                    <label>Rôle</label>
        	        <select name="ajout_role">
                    <?php while($ajout_role = $roles->fetch() ): ?>
                   <option value="<?= $ajout_role['id'] ;?>"><?= $ajout_role['label']; ?></option>
                    <?php endwhile; ?>    
                    </select>
                       
        	        <input type="submit" name ="form_inscription" value="S'inscrire" class="submit"/>
                   
       <p>Tous les éléments ayant * sont obligatoires.</p>
    </form>

</body>
</html>
<?php
    if(isset($_POST['form_inscription']))
    {   

        $prenom = htmlspecialchars($_POST['ajout_prenom']);
        $nom = htmlspecialchars($_POST['ajout_nom']);
        $mail = htmlspecialchars($_POST['ajout_mail']);
        $mdp = sha1 ($_POST['ajout_mdp']);
        $mdp2 =sha1 ($_POST['ajout_mdp2']);
        $tel = htmlspecialchars($_POST['ajout_num']);
        $specialite = htmlspecialchars($_POST['ajout_specialite']);
        $role = intval($_POST['ajout_role']);
        
        if (!empty($prenom) AND !empty($mail) AND !empty($nom) AND !empty($mdp) ANd !empty($mdp2) AND isset($tel) AND isset($specialite) AND !empty($role) )
                                      
        {
                        //vérification que le mail est valide
                        if(filter_var($mail,FILTER_VALIDATE_EMAIL))
                        {   
                            //vérification si l'email existe
                            $reqmail = $bdd -> prepare('SELECT * FROM utilisateurs where mail = ?');
                            $reqmail -> execute(array($mail));
                            $mailexist = $reqmail -> rowcount();
                            
                            if ($mailexist == 0)
                            {    
                                //vérification si les deux mots de passe sont identiques
                                if($mdp == $mdp2)
                                {

                                    $insertmbr = $bdd -> prepare('INSERT INTO utilisateurs (prenom, nom, mail, mdp, specialites,telephone ) VALUES (?, ?, ?, ?, ?, ?)');
                                    $insertmbr ->execute(array($prenom, $nom, $mail, $mdp, $specialite, $tel));

                                    $last_id = $bdd->lastInsertId();

                                    if($role != 0 ){

                                        $req_verif = $bdd -> prepare('SELECT id_utilisateur FROM utilisateurs_roles where id_utilisateur = ?');  
                                        $req_verif -> execute(array($last_id));
                                        $user_exist = $req_verif -> rowcount();
                                        
                                            if($user_exist == 0){

                                                $user_role = $bdd-> prepare('INSERT INTO utilisateurs_roles (id_utilisateur, id_role) VALUES (?,?)');
                                                
                                                //todo : gerer les rechargements de page foireux
                                                $user_role->execute(array($last_id, $role));
                                                
                                                $erreur ='Votre compte a bien été créé!'; 
                                            }
                                    }
                                    
                                }else{?>
                                     <script type="">
           
                                        //créer une div
                                        var div = document.createElement('div');
                                        
                                        //ajout de class sur la div 
                                        $(div).addClass('alert alert-danger');
                                        //créer du text
                                        var text = document.createTextNode("Vos mots de passe ne concordent pas.");  

                                        //manipulation HTML
                                        $(div).append(text); 
                                        $('#form-inscription').before(div);
                                           
                                    </script>
                                
                                <?php
                                }

                            }else{
                            ?>
                                <script type="">
           
                                        //créer une div
                                        var div = document.createElement('div');
                                        
                                        //ajout de class sur la div 
                                        $(div).addClass('alert alert-danger');
                                        //créer du text
                                        var text = document.createTextNode("Ce mail est déjà associè à un compte.");  

                                        //manipulation HTML
                                        $(div).append(text); 
                                        $('#form-inscription').before(div);
                                           
                                </script>
                            <?php
                            }

                        }else{
                        ?>
                             <script type="">
           
                                        //créer une div
                                        var div = document.createElement('div');
                                        
                                        //ajout de class sur la div 
                                        $(div).addClass('alert alert-danger');
                                        //créer du text
                                        var text = document.createTextNode("Mail invalide.");  

                                        //manipulation HTML
                                        $(div).append(text); 
                                        $('#form-inscription').before(div);
                                           
                            </script>
                           
                        <?php
                        }
                    
        }else{
        ?>
            <script type="">
           
                //créer une div
                var div = document.createElement('div');
                
                //ajout de class sur la div 
                $(div).addClass('alert alert-danger');
                //créer du text
                var text = document.createTextNode("Il manque une information.");  

                //manipulation HTML
                $(div).append(text); 
                $('#form-inscription').before(div);
                                           
            </script>
        <?php
        }
    }else
    {
    ?>
     <script type="">
           
                //créer une div
                var div = document.createElement('div');
                
                //ajout de class sur la div 
                $(div).addClass('alert alert-danger');
                //créer du text
                var text = document.createTextNode("Tous les champs doivent être complétés.");  

                //manipulation HTML
                $(div).append(text); 
                $('#form-inscription').before(div);
                                           
    </script>
    <?php
    }
?>