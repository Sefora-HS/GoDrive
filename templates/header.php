<?php
    //recuperation du nom de la page actuel
    $current_page = basename($_SERVER['PHP_SELF']);
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
    <header class="header">
        <img src="../assets/images/logo.png" alt="logo voiture" class="logo">
        <nav class="navigation">
            <ul class="nav-items">
                <li class="item"><a href="#" class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Accueil</a></li>
                <li class="item"><a href="#" class="nav-link <?php echo ($current_page == 'catalogue.php') ? 'active' : ''; ?>">Notre Catalogue</a></li>
                <li class="item"><a href="#" class="nav-link <?php echo ($current_page == 'reservation.php') ? 'active' : ''; ?>">Reservation rapide</a></li>
                <li class="item"><a href="#" class="nav-link <?php echo ($current_page == 'faq.php') ? 'active' : ''; ?>">FAQ</a></li>
                <li class="item"><a href="#" class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">Contact</a></li>
            </ul>
        </nav>
        <div class="btn-container">
            <a href="#" class="nav-btn">Se connecter</a>
            <a href="#" class="nav-btn nav-btn-2">S'inscrire</a>
        </div>
    </header>
</body>
</html>