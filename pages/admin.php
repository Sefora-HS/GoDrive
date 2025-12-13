<?php
require_once '../pages/config.php';
?>

<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

?>

<?php
function renderPage($page) {
    global $bdd;
    echo "<div class='admin-card'>";

    switch ($page) {
        case 'home':
            echo "<h2>Accueil</h2><p>Bienvenue dans l'administration.</p>";
            break;

        case 'users':
            echo "<h2>Utilisateurs</h2>";
            
            // Récupération des utilisateurs depuis la BDD
            global $bdd; // utilise la connexion PDO de config.php
            $users = $bdd->query("SELECT id, nom, email FROM utilisateurs")->fetchAll(PDO::FETCH_ASSOC);

            // Tableau HTML
            echo "<table border='1' class='admin-table'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>";
            foreach ($users as $u) {
                echo "<tr>
                        <td>{$u['id']}</td>
                        <td>{$u['nom']}</td>
                        <td>{$u['email']}</td>
                      </tr>";
            }
            echo "</tbody></table>";
            break;

        case 'reservations':
            echo "<h2>Réservations</h2>";
            
            // Exemple : récupérer les réservations
            $reservation = $bdd->query("SELECT id, id_vehicule,id_utilisateur, date_debut, date_fin, message, total FROM reservation")->fetchAll(PDO::FETCH_ASSOC);

            echo "<table border='1' class='admin-table'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Voiture</th>
                            <th>Date</th>
                            <th>Utilisateur ID</th>
                        </tr>
                    </thead>
                    <tbody>";
            foreach ($reservation as $r) {
                echo "<tr>
                        <td>{$r['id']}</td>
                        <td>{$r['voiture']}</td>
                        <td>{$r['date_reservation']}</td>
                        <td>{$r['utilisateur_id']}</td>
                      </tr>";
            }
            echo "</tbody></table>";
            break;

        case 'contact':
            echo "<h2>Messages de contact</h2>";
            
            $messages = $bdd->query("SELECT id, nom, email, message FROM contact")->fetchAll(PDO::FETCH_ASSOC);

            echo "<table border='1' class='admin-table'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>";
            foreach ($messages as $m) {
                echo "<tr>
                        <td>{$m['id']}</td>
                        <td>{$m['nom']}</td>
                        <td>{$m['email']}</td>
                        <td>{$m['message']}</td>
                      </tr>";
            }
            echo "</tbody></table>";
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
