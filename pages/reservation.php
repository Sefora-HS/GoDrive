<?php
require_once '../pages/config.php';
// Si on vient depuis une page produit alors saisir les données de la page ( dates et id véhicule) sinon on laisse cet données vide 
$dateDebut = $_POST['date_debut'] ?? '';
$dateFin   = $_POST['date_fin'] ?? '';
$vehiculeId = $_POST['vehicule_id'] ?? '';
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
<main>
    <section class="title-section">
        <h1>Formulaire Reservation rapide</h1>
    </section>
    <section class="form-reservation-section">

        <form action="" class="form-reservation">

            <div class="right-reservation">

                <div class="row">
                    <input type="text" name="nom" placeholder="Nom :" class="input" required>
                    <input type="text" name="prenom" placeholder="Prénom :" class="input" required>
                </div>

                <div class="row">
                    <input type="email" name="email" placeholder="Adresse Mail :" class="input input-full" required>
                </div>

                <div class="row">
                    <input type="text" name="adresse" placeholder="Adresse :" class="input input-full" required>
                </div>

                <div class="row">
                    <input type="text" name="ville" placeholder="Ville :" class="input" required>
                    <input type="text" name="code_postal" placeholder="Code postal :" class="input" required>
                </div>

                <div class="row">
                    <input type="text" name="message" placeholder="Message (facultatif) :" class="input input-full input-msg">
                </div>
            </div>

            <div class="left-reservation">
                <?php 
  <input
      type="date"
      name="date_debut"
      value="<?= htmlspecialchars($dateDebut) ?>"
    >
      <input
      type="date"
      name="date_fin"
      value="<?= htmlspecialchars($dateFin) ?>"
    >
                    //affichage de la voiture et choix reservation
                 ?>
                <button type="submit">Reserver ➡</button>
            </div>

        </form>

    </section>
    <section class="background">
        <div class="chiffres-reservation">
            <div class="chiffres-reservation-item">
                <p class="chiffre">80</p>
                <p class="chiffre-desc">+80 destinations dans toutes la france</p>
            </div>
            <div class="chiffres-reservation-item">
                <p class="chiffre">100k</p>
                <p class="chiffre-desc">+100k visiteurs chaque semaine</p>
            </div>
            <div class="chiffres-reservation-item">
                <p class="chiffre">800</p>
                <p class="chiffre-desc">+800 modeles disponible a la location</p>
            </div>
            <div class="chiffres-reservation-item">
                <p class="chiffre">600</p>
                <p class="chiffre-desc">En moyenne 600 voitures loue chaque jour</p>
            </div>
        </div>
    </section>
</main>
<?php
// Inclut le header
include('../templates/footer.php');
?>
</body>
</html>
