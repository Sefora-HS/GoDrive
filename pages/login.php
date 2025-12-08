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
    <section class="login-section">
        <img src="../assets/images/logo.png" alt="logo site" class="login-img">
        <h2 class="login-title">Connexion</h2>
        <form action="login-traitement.php" method="post" class="login-form">
            <div class="form-container">
                <input type="text" name="identifiant" placeholder="Nom d'utilisateur : " class="login-input">
                <input type="password" name="password" placeholder="Mot de passe : " class="login-input">
            </div>

            <div class="connexion-2">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Se souvenir de moi</label>

                <a href="" class="link-signin">Pas de compte ? Je m'inscris !</a>
            </div>

            <button type="submit">Se connecter</button>
        </form>
    </section>
</main>
<?php
// Inclut le header
include('../templates/footer.php');
?>
</body>
</html>
