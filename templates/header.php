<?php
    //recuperation du nom de la page actuel
    $current_page = basename($_SERVER['PHP_SELF']);
    $isConnected = isset($_SESSION['user_id']);
?>
    <header class="header">
        <img src="../assets/images/logo.png" alt="logo voiture" class="logo">
        <nav class="navigation">
            <ul class="nav-items">
                <li class="item"><a href="../index.php" class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Accueil</a></li>
                <li class="item"><a href="../pages/catalogue.php" class="nav-link <?php echo ($current_page == 'catalogue.php') ? 'active' : ''; ?>">Notre Catalogue</a></li>
                <li class="item"><a href="../pages/reservation.php" class="nav-link <?php echo ($current_page == 'reservation.php') ? 'active' : ''; ?>">Reservation rapide</a></li>
                <li class="item"><a href="../pages/faq.php" class="nav-link <?php echo ($current_page == 'faq.php') ? 'active' : ''; ?>">FAQ</a></li>
                <li class="item"><a href="../pages/contact.php" class="nav-link <?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>">Contact</a></li>
            </ul>
        </nav>
        <div class="btn-container">
            <?php if($isConnected): ?>
                <a href="../pages/utilisateur.php" class="nav-btn">Mon compte</a>
                <a href="../pages/logout.php" class="nav-btn nav-btn-2">Deconnexion</a>
            <?php else: ?>
                <a href="../pages/login.php" class="nav-btn">Se connecter</a>
                <a href="../pages/signin.php" class="nav-btn nav-btn-2">S'inscrire</a>
            <?php endif; ?>
        </div>
    </header>