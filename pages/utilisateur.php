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
    <h1>Mon Compte</h1>
    <hr>

    <section class="moncompte-section">

        <div class="moncompte-infos">
            <form action="" class="infos-compte">
                <input type="text" name="nom" placeholder="Nom :">
                <input type="text" name="prenom" placeholder="Prénom :">
                <input type="email" name="email" placeholder="Adresse Mail :">
                <input name="password" type="password" placeholder="Mot de passe : ">
                <input type="text" name="adresse" placeholder="Adresse :">
                <input type="text" name="ville" placeholder="Ville :">
                <input type="text" name="code_postal" placeholder="Code postal :">
            </form>
        </div>

        <div class="mes-reservations">

        </div>

    </section>
</main>
<?php
// Inclut le header
include('../templates/footer.php');
?>
</body>
</html>