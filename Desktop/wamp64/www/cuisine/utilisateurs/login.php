<?php
session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>AVD-connexion</title>
     <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  </head>

  <body class="text-center">

    <form id="form-login" action ="" method="post">
      
        <h1 class="orange robot">Login</h1>
          <label>Votre mail</label>
          <input type="email"  name ="mailconnect"  placeholder="Email address"><br>
          <label>Votre mot de passe</label>
          <input type="password"  name="mdpconnect" placeholder="Password"><br>
           
      <button name ="connection" type="submit">Se connecter</button>
    
 
    </form>
 </body>
</html>
<?php 
include('../includes/bdd.php');

if(isset($_POST['connection'])){

  $mailconnect = htmlspecialchars($_POST['mailconnect']);
  $mdpconnect = sha1($_POST['mdpconnect']);

  if(!empty($mailconnect) AND !empty($mdpconnect))
  {
    //vérification de l'existence de l'utilisateur et des bons mail et mdpp
    $requser = $bdd -> prepare('SELECT * FROM utilisateurs where mail = ? AND mdp = ?');
    $requser -> execute(array($mailconnect, $mdpconnect));
    
    $userexist = $requser -> rowcount();

    $role = $bdd->prepare('SELECT * FROM utilisateurs_roles '); 
    $role->execute();

      if($userexist == 1)
      {

        $userinfo = $requser -> fetch();
        $role_verif= $role-> fetch();
       
        $_SESSION['id'] = $userinfo ['id'] ;
        $_SESSION['prenom'] = $userinfo ['prenom'] ;
        $_SESSION['mail'] = $userinfo ['mail'];
        $_SESSION['id_role'] = $role_verif['id_role'];
  
      
        if($_SESSION['id_role'] == 1){
          header('location: profil.php?id='.$_SESSION['id']);
        }
        if($_SESSION['id_role'] == 2){
          header('location: index.php?id='.$_SESSION['id']);
        }

      }else {
      ?>
      <script type="">
           
    //créer une div
    var div = document.createElement('div');
    
    //ajout de class sur la div 
    $(div).addClass('alert alert-danger');
    //créer du text
    var text = document.createTextNode("Mail ou mot de passe incorrect.");  

    //manipulation HTML
    $(div).append(text); 
    $('#form-login').before(div);
       
    </script>
    <?php
      }
  }
  else { 
    ?>
    <script type="">
           
    //créer une div
    var div = document.createElement('div');
    
    //ajout de class sur la div 
    $(div).addClass('alert alert-danger');
    //créer du text
    var text = document.createTextNode("Il manque un élément ou plusieurs éléments.");  

    //manipulation HTML
    $(div).append(text); 
    $('#form-login').before(div);
       
    </script>

  <?php 
  }
}
?>