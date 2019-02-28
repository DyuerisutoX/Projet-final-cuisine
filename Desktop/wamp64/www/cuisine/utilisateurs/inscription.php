<?php 
//inclus la connexion BDD
include('../includes/bdd.php');

$roles =$bdd->query('SELECT *FROM roles'); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Inscription</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script type="text/javascript" src="../js/jquery-3.3.1.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">

                 <div class="jumbotron">

                    <form id="form-inscription" action="" method="post">
                            <a class="btn btn-o" href="../index.php">Retour</a>
                            <h1>Formulaire d'inscription</h1>
                        
                            <!-- prénom -->
                            <div class=" row form-group ">
                                <div class="col">
                                     <label for="ajout_prenom">Prénom *</label>            
                                    <input class="form-control" type="text" name="ajout_prenom">
                                </div>
                                   
                             
                            <!-- nom --> 
                                <div class="col">
                                    <label for="ajout_nomm">Nom *</label>            
                                    <input class="form-control" type="text" name="ajout_nom">
                                </div>         
                                    
                             </div>

                             <!-- mail --> 
                            <div class=" row form-group ">
                                <div class="col">        
                                    <label for="ajout_mail">Mail *</label>
                                    <input type="email" class="form-control" name="ajout_mail">
                                </div>
                            <!--Role-->
                                <div class="col">
                                    <label for="ajout_role">Rôle</label>
                                    
                                    <select class="form-control" name="ajout_role">
                                    <?php while($ajout_role = $roles->fetch() ): ?>
                                    <option value="<?= $ajout_role['id'] ;?>"><?= $ajout_role['label']; ?></option>
                                    <?php endwhile; ?>    
                                    </select> 
                                </div>
                            </div>

                            <!-- mdp --> 
                            <div class=" row form-group ">
                                <div class="col">      
                                    <label for="ajout_mdp">Mot de passe *</label>
                                    <input type="password" class="form-control" name="ajout_mdp">
                                </div>
                            <!--MDP confirme-->
                                <div class="col">
                                    <label for="ajout_mdp2">Confirmation mot de passe *</label>
                                    <input type="password" class="form-control" name="ajout_mdp2">
                                </div>
                            </div>
                            <!--Spécialités-->
                            <div class="row form-group">
                                <div class="col">
                                   <label for="ajout_specialite">Spécialités</label>
                                    <input type="text" class="form-control" name="ajout_specialite"  > 
                                </div>
                                <!--tel-->
                                <div class="col">
                                    <label for="ajout_num">Numéro de téléphone</label>
                                    <input type="tel" class="form-control" name="ajout_num"  >
                                </div>
                            </div>

                            <input type="submit" class="btn btn-o" name ="form_inscription" value="S'inscrire" class="submit"/>
                                
                                <p>Tous les éléments ayant * sont obligatoires.</p>
                    </form>
                   
                </div><!-- FIN jumbotron--> 
            </div> <!-- FIN col-->      
        </div>
       
    </div>
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