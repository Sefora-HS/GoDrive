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
    <section class="signin-section">
        <img src="../assets/images/logo.png" alt="logo site" class="login-img">
        <h2 class="login-title">Inscription</h2>
        <form action="" method="" class="signin-form">
            <div class="signin-inputs">
                <div class="bloc">
                    <input name="nom" type="text" placeholder="Nom : " class="signin-input" required>
                    <input name="id" type="text" placeholder="Identifiant : " class="signin-input" required>
                    <input name="password" type="password" placeholder="Mot de passe : " class="signin-input" required>
                </div>
                
                <div class="bloc">
                    <input name="prenom" type="text" placeholder="Prénom : " class="signin-input" required>
                    <input name="email" type="email" placeholder="Adresse mail : " class="signin-input" required>
                    <input name="password-confirm" type="password" placeholder="Mot de passe (confirmation) : " class="signin-input" required>
                </div>
            </div>

            <button type="submit">Je m'inscris</button>
        </form>
    </section>
</main>
<?php
// Inclut le header
include('../templates/footer.php');
?>
</body>
</html>
