<?php
require_once '../pages/config.php';
?>

<!-- Filtres pour la barre de filtre du catalogue -->
<?php 
    //on demande toutes les colonnes de la tables véhicules
    $sql = "SELECT * FROM vehicules WHERE 1=1";
    //initialisation du tableau parametres pour stockés les données renvoyés
    $parametres = [];

    //on recupere la valeur de marque et on effectue des tests (present, vide)
    if(isset($_GET['marque']) && $_GET['marque'] !== "") {
        $sql .= "AND marque = :marque";
        $parametres[':marque'] = $_GET['marque'];
    }

    //on recupere la valeur de prix et effectuons les même tests
    if (isset($_GET['prix']) && $_GET['prix'] !== ""){
        if (is_numeric($_GET['prix'])) {
            $sql .= "AND prix_jour <= :prix";
            $parametres[':prix'] = $prix;
        }
    }

    

    //on recupere la valeur de nb_places et effectuons les même tests 
    if (isset($_GET['nb_places']) && $_GET['nb_places'] !== "") {
    $sql .= " AND nb_places = :nb";
    $params[':nb'] = $_GET['nb_places'];
    }

    //preparation de la requete
    $requete = $bdd->prepare($sql); 
    //execution de la requete
    $requete->execute($params);
    //retourne sous forme de tableau associatif pour l'insertion 
    $vehicules = $requete->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>GoDrive</title>
</head>
<body>
<?php
// Inclut le header
include('../templates/header.php');
?>

<main class="catalogue-container">
     <h1 class="titre-page">Notre catalogue de vehicules</h1>

     <div class="separator"></div>

    <?php
    $requete = $bdd->prepare("SELECT * FROM vehicules ORDER BY prix_jour ASC");
    $requete->execute();
    $vehicules = $requete->fetchAll(PDO::FETCH_ASSOC);

    if (!$vehicules) {
        echo "<p class='message-vide'>Aucun véhicule disponible pour le moment.</p>";
    }
    ?>

    <section class="grille-catalogue">

        <?php foreach ($vehicules as $v): ?>

            <?php  
            // image : si vide → image par défaut
            $image = (!empty($v['image'])) ? $v['image'] : "default.png";
            ?>

            <div class="carte-vehicule">

                <img src="../assets/images/<?php echo $image; ?>" 
                     alt="<?php echo htmlspecialchars($v['nom_vehicule']); ?>" 
                     class="img-vehicule">

                <h3 class="titre-vehicule"><?php echo htmlspecialchars($v['nom_vehicule']); ?></h3>

                <p class="infos-vehicule">
                    Marque : <?php echo htmlspecialchars($v['marque']); ?><br>
                    Année : <?php echo $v['annee_vehicule']; ?><br>
                    Places : <?php echo $v['nb_places']; ?>
                </p>

                <p class="prix-vehicule"><?php echo $v['prix_jour']; ?> € / jour</p>

                <a href="produit.php?id=<?php echo $v['id']; ?>" class="btn-vehicule">
                    Voir le vehicule
                </a>

            </div>

        <?php endforeach; ?>

    </section>


</main>

<?php
// Inclut le header
include('../templates/footer.php');
?>
</body>

</html>

