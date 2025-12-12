<?php
require_once '../pages/config.php';
?>

<!-- Filtres pour la barre de filtre du catalogue -->
<?php 
    //on demande toutes les colonnes de la tables véhicules
    $sql = "SELECT * FROM vehicules WHERE 1=1";
    //initialisation du tableau parametres pour stockés les données renvoyés
    $parametres = [];

    //on recupere la valeur de marque et on effectue des tests (present, null)
    if(isset($_GET['marque']) && $_GET['marque'] !== "") {
        $sql .= " AND marque = :marque";
        $parametres[':marque'] = $_GET['marque'];
    }

    //on recupere la valeur de prix et effectuons les même tests
    if (isset($_GET['prix']) && $_GET['prix'] !== ""){
        if (is_numeric($_GET['prix'])) {
            $sql .= " AND prix_jour <= :prix";
            $parametres[':prix'] = $_GET['prix'];
        }
    }

    //on recupere la valeur de l'annee 
     if(isset($_GET['annee']) && $_GET['annee'] !== "") {
        $sql .= " AND annee_vehicule >= :annee";
        $parametres[':annee'] = $_GET['annee'];
    }

    //on recupere la valeur de nb_places et effectuons les même tests 
    if (isset($_GET['nb_places']) && $_GET['nb_places'] !== "") {
    $sql .= " AND nb_places = :nb";
    $parametres[':nb'] = $_GET['nb_places'];
    }

    if (!empty($_GET['date_debut']) && !empty($_GET['date_fin'])) {
    $sql .= "
        AND id NOT IN (
            SELECT id_vehicule
            FROM reservation
            WHERE NOT (
                :date_fin < date_debut
                OR :date_debut > date_fin
            )
        )
    ";
    $parametres[':date_debut'] = $_GET['date_debut'];
    $parametres[':date_fin'] = $_GET['date_fin'];
    }



    //preparation de la requete
    $requete = $bdd->prepare($sql); 
    //execution de la requete
    $requete->execute($parametres);
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

     <div class="barre-filtre-catalogue">

        <form class="barre-filtres" method="GET">

            <select name="marque" class="marque">
                <option value="">Marque</option>
                <option value="Renault">Renault</option>
                <option value="Peugeot">Peugeot</option>
                <option value="BMW">BMW</option>
                <option value="Mercedes">Mercedes</option>
                <option value="Nissan">Nissan</option>
            </select>

            <input type="number" name="annee" class="annee" placeholder="Annee min" value="<?php echo $_GET['annee'] ?? ''; ?>">

            <input type="date" name="date_debut" class="date" value="<?php echo $_GET['date_debut'] ?? ''; ?>" placeholder="Date début">

            <input type="date" name="date_fin" class="date" value="<?php echo $_GET['date_fin'] ?? ''; ?>" placeholder="Date fin">


            <input type="number" name="prix" class="prix" placeholder="Prix max (€)" value="<?php echo $_GET['prix'] ?? ''; ?>">

            <select name="nb_places" class="places">
                <option value="">Places</option>
                <option value="2">2 places</option>
                <option value="4">4 places</option>
                <option value="5">5 places</option>
                <option value="7">7 places</option>
            </select>

            <button type="submit" class="btn-filtre">Filtrer</button>
        </form>

     </div>

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

