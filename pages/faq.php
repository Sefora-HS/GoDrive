<?php
require_once '../pages/config.php';
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
    <section class="faq-section">

        <h2>Foire aux questions</h2>

        <div class="faq">

            <details>
                <summary>Comment creer un compte sur GoDrive ?</summary>
                <p>Pour créer un compte, cliquez sur "S’inscrire" en haut de la page, <br>
                renseignez vos informations personnelles et validez votre adresse email. <br>
                Vous pourrez ensuite accéder à toutes les fonctionnalités du site.</p>
            </details>

            <details>
                <summary>Comment reserver une voiture en ligne ?</summary>
                <p>Vous pouvez réserver via la rubrique reservation rapide ou directement dans <br>
                la page de la voiture concerné dans le catalogue (à condition d'avoir un compte 😉)</p>
            </details>

            <details>
                <summary>Puis-je annuler ou modifier ma reservation ?</summary>
                <p>La reservation n'est pas modifiable mais elle peut tout a fait etre annulee</p>
            </details>

            <details>
                <summary>Puis-je reserver une voiture pour quelqu’un d’autre ?</summary>
                <p>Oui, a condition de remplir le formulaire avec vos informations</p>
            </details>

            <details>
                <summary>Comment choisir le type de voiture adapte a mes besoins ?</summary>
                <p>Vous pouvez configurer votre recherche via la page catalogue ou il est possible<br>
                de filtrer les voitures disponible</p>
            </details>

            <details>
                <summary>Quels sont les horaires de recuperation et de retour des vehicules ?</summary>
                <p>Vous pouvez recuperer et deposer vos voiture 24/7 avec nos services automatises</p>
            </details>

        </div>
    </section>
</main>
<?php
// Inclut le header
include('../templates/footer.php');
?>
</body>
</html>
