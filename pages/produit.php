<?php
//connection
require_once '../pages/config.php';

// Si l'utilisateur n'est pas connecté → redirection
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Vérification que l'utilisateur existe encore dans la BDD
$verif = $bdd->prepare("SELECT id FROM utilisateurs WHERE id = :id");
$verif->execute([':id' => $_SESSION['user_id']]);
if ($verif->rowCount() == 0) {
    unset($_SESSION['user_id']);
    header('Location: login.php');
    exit;
}

// ----------  Récupérer l'ID du produit dans l'URL ---------
if (!isset($_GET['id'])) {
    echo "Aucun produit sélectionné.";
    exit;
}

$vehicule_id = (int) $_GET['id']; // Sécurisation simple



// récupérer les informtions du vehicule 
$stmt = $bdd->prepare("SELECT * FROM vehicules WHERE id = ?");
$stmt->execute([$vehicule_id]);
$vehicule = $stmt->fetch(PDO::FETCH_ASSOC);
$nb_places = $vehicule['nb_places'];



// ---------- 4. Vérifier si le produit existe ----------
if (!$vehicule) {
    echo "Vehicule introuvable.";
    exit;
}
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
    <title>GoDrive - <?= htmlspecialchars($vehicule['nom_vehicule']) ?></title>
</head>

<body>
    <?php
    // Inclut le header
    include('../templates/header.php');
    ?>
    <main>


        <h1 class="h1-produit">
            <?= htmlspecialchars($vehicules['nom_vehicule']) ?>
        </h1>
<div class="container-prod">
    <div class="colonne-prod">

        <img src="images/<?= htmlspecialchars($vehicules['image']) ?>"
            alt="<?= htmlspecialchars($vehicules['nom_vehicule']) ?>">
    </div>
     <div class="colonne-prod">
        
        <div class="nom_vehicule_prod"> <?= htmlspecialchars($vehicules['nom_vehicule']) ?> </div>
<div class="container-prod">
       <div class="colonne-prod">


           
           <form action="reservation.php" method="POST">
               <input type="hidden" name="vehicule_id" value="<?= $vehicules['id'] ?>">

               
               <label> // Date de début location 
        <div class="date-wrapper">
        Date début
            <input type="date" id="dateDebut" name="dateDebut">
        </div>
                   </label>
       </div>
               <label> //Date fin location 
       <div class="colonne-prod">
        <div class="date-wrapper">
            <Date fin
            <input type="date" id="dateFin" name="dateFin">
        </div>
       </label>
       </div>

// description voiture 
        <p class="description">
         Prix total : <span id="prix">—</span> €
        </p>

    // prix voiture 
        <p class="prix">
            Total : <?= htmlspecialchars($vehicules['prix_jour']) ?> €
        </p>
         
     </div>
</div>
        <p class="information">
            Une fois votre réservation validée, retrouvez votre récapitulatif de commande su votre compte dans la rubrique <a href="./mesreservations">"Mes réservations"</a>
        </p>


    //bouton réserver
        <button type="submit" class="pill-btn" aria-label="Réserver">
            Réserver
        </button>
                   
</form>



    </main>
    <?php
    // Inclut le header
    include('../templates/footer.php');
    ?>

                <script> // avoir le prix qui s'affiche direct sure la page
                    
const prixJour = <?= $vehicule['prix_jour'] ?>;

const debut = document.querySelector('[name="date_debut"]');
const fin   = document.querySelector('[name="date_fin"]');
const prix  = document.getElementById('prix');

function calculPrix() {
  if (debut.value && fin.value) {
    const d1 = new Date(debut.value);
    const d2 = new Date(fin.value);
    const jours = (d2 - d1) / (1000 * 60 * 60 * 24);

    if (jours > 0) {
      prix.textContent = jours * prixJour;
    }
  }
}

debut.addEventListener('change', calculPrix);
fin.addEventListener('change', calculPrix);
</script>

</body>


</html>
