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
include('templates/header.php');
?>
<main>
     <section class="section-index">
        <!--  -->
        <div class="hero-top">
            <!--  -->
            <div class="hero-left">
                <h1 class="hero-title">Vous avez besoin d'une voiture ?</h1>
                <h2 class="hero-subtitle">Reservez des maintenant votre voiture et profitez de la route</h2>

                <div class="buttons-hero">
                    <a href="#">Je reserve !</a>
                    <a href="#" class="clair">En savoir plus</a>
                </div>
            </div>
            <!--  -->
            <div class="hero-right">
                <img src="./assets/images/car-3d.png" alt="img voiture">
            </div>
        </div>

        
        <div class="hero-logos">
            <div class="logo-container">
                <img src="./assets/images/vw.png" alt="vw">
                <img src="./assets/images/audi.png" alt="audi">
                <img src="./assets/images/toyota.png" alt="toyota">
                <img src="./assets/images/renault.png" alt="renault">
                <img src="./assets/images/opel.png" alt="opel">
                <img src="./assets/images/nissan.png" alt="nissan">
                <img src="./assets/images/mercedes.png" alt="mercedes">
                <img src="./assets/images/fiat.png" alt="fiat">
                <img src="./assets/images/citroen.png" alt="citroen">
            </div>
        </div>
     </section>
</main>
<?php
// Inclut le header
include('templates/footer.php');
?>
</body>
</html>
