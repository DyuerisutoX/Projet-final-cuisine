<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ateliers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/bootstrap.min.css" />
    <script src="main.js"></script>
</head>
<body>
<form action="ateliers.php" style="align:center" method="POST">
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
            <input type="date" name="ajout_date" placeholder="date">
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

        <button type="submit" class="btn btn-primary mb-2" name="form_ajout_ateliers" value="ajouter un ateliers">ajouter</button>
      
	</form>

    <?php if(isset($message)): ?>
         
        <span class="alert">
            <?php echo $message; ?>
        </span>
        <?php endif;?>

</body>
</html>