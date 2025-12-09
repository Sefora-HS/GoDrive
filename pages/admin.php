<?php
require_once '../pages/config.php';
?>

<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

function renderPage($page) {
    echo "<div class='admin-card'>";

    switch ($page) {
        case 'home':
            echo "<h2>Accueil</h2><p>Bienvenue dans l'administration.</p>";
            break;
        case 'users':
            echo "<h2>Utilisateurs</h2><p>Gestion des utilisateurs</p>";
            break;
        case 'reservations':
            echo "<h2>Articles</h2><p>Création et gestion des articles.</p>";
            break;
        case 'contact':
            echo "<h2>Contact</h2><p>gestions du formulaire de contact.</p>";
            break;
        default:
            echo "<h2>404</h2><p>La page demandée n'existe pas.</p>";
            break;
    }

    echo "</div>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoDrive</title>

    <link href="https://fonts.googleapis.com/css2?family=Koulen&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
<div class="admin-container">

    <!-- Sidebar -->
    <aside class="admin-sidebar">

        <!-- Logo -->
        <div class="admin-logo">
            <img src="../assets/images/logo.png" alt="Logo" class="logo-img">
        </div>

        <nav>
            <ul>
                <li>
                    <a href="admin.php?page=home" class="<?= $page === 'home' ? 'active' : '' ?>">
                        <img src="../assets/images/dashboard.png" class="icon" alt=""> Dashboard
                    </a>
                </li>

                <li>
                    <a href="admin.php?page=users" class="<?= $page === 'users' ? 'active' : '' ?>">
                        <img src="../assets/images/client.png" class="icon" alt=""> Utilisateurs
                    </a>
                </li>

                <li>
                    <a href="admin.php?page=reservations" class="<?= $page === 'reservations' ? 'active' : '' ?>">
                        <img src="../assets/images/planning.png" class="icon" alt=""> Reservations
                    </a>
                </li>

                <li>
                    <a href="admin.php?page=contact" class="<?= $page === 'contact' ? 'active' : '' ?>">
                        <img src="../assets/images/courriel-de-contact.png" class="icon" alt=""> Contact
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Bouton Déconnexion -->
        <a href="logout.php" class="admin-logout">
            <img src="../assets/images/se-deconnecter.png" class="icon" alt=""> Deconnexion
        </a>
    </aside>

    <main class="admin-content">
        <header class="admin-header">
            <h1>Bienvenue sur le panel administrateur !</h1>
        </header>

        <?php renderPage($page); ?>
    </main>

</div>
</body>
</html>
