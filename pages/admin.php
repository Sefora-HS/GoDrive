<?php
require_once '../pages/config.php';

// rcuperation des elements du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter_vehicule'])) {
    $nom = htmlspecialchars($_POST['nom_vehicule']);
    $marque = htmlspecialchars($_POST['marque']);
    $annee = intval($_POST['annee_vehicule']);
    $description = htmlspecialchars($_POST['description']);
    $prix = floatval($_POST['prix_jour']);
    $places = intval($_POST['nb_places']);
    
    // Aide l'ia pour cette partie
    $image_name = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $filename = $_FILES['image']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($filetype), $allowed)) {
            $image_name = uniqid() . '.' . $filetype;
            move_uploaded_file($_FILES['image']['tmp_name'], '../assets/images/' . $image_name);
        }
    }
    
    //preparation de la requete pour inserer un nouveau vehicule
    $stmt = $bdd->prepare("INSERT INTO vehicules (nom_vehicule, marque, annee_vehicule, description, image, prix_jour, nb_places) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $marque, $annee, $description, $image_name, $prix, $places]);
    
    header('Location: admin.php?page=vehicules');
    exit;
}

//création de case pour chaque elements du menu et eviter d'avoir une page pour chaque lien
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

//fonction d'affichage de chaque page
function renderPage($page) {
    global $bdd;
    echo "<div class='admin-card'>";

    switch ($page) {
        //affichage dashboard
        case 'home':
            echo "<h2>Accueil</h2><p>Bienvenue dans l'administration.</p>";
            break;

            //affichage des vehicules du catalogue + formulaire d'ajout
        case 'vehicules':
            ?>
            <div class="header-with-button">
                <h2>Gestionnaire vehicules</h2>
                <button class="admin-btn" onclick="toggleForm()">+ Ajouter un vehicule</button>
            </div>

            <div id="form-ajout-vehicule" class="form-container-admin" style="display: none;">
                <h3>Ajouter un nouveau vehicule</h3>

                <!-- Formulaire pour ajouter un nouveau vehicule -->
                <form method="POST" enctype="multipart/form-data" class="form-admin">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nom du vehicule *</label>
                            <input type="text" name="nom_vehicule" required class="input-admin">
                        </div>
                        <div class="form-group">
                            <label>Marque *</label>
                            <input type="text" name="marque" required class="input-admin">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Annee *</label>
                            <input type="number" name="annee_vehicule" min="1900" max="2025" required class="input-admin">
                        </div>
                        <div class="form-group">
                            <label>Prix/jour (€) *</label>
                            <input type="number" name="prix_jour" step="0.01" required class="input-admin">
                        </div>
                        <div class="form-group">
                            <label>Nombre de places *</label>
                            <input type="number" name="nb_places" min="1" max="9" required class="input-admin">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" rows="3" class="input-admin"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Image du vehicule</label>
                        <input type="file" name="image" accept="image/*" class="input-file">
                    </div>

                    <div class="form-actions">
                        <button type="submit" name="ajouter_vehicule" class="admin-btn">Ajouter</button>
                        <button type="button" class="admin-btn-secondary" onclick="toggleForm()">Annuler</button>
                    </div>
                </form>
            </div>

           <!-- Affichage de toutes les voitures du catalogues sous forme de tableau -->
            <div class="table-wrapper">
                <?php
                $vehicules = $bdd->query("SELECT id, nom_vehicule, marque, annee_vehicule, description, image, prix_jour, nb_places FROM vehicules")->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <table class='admin-table'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Marque</th>
                            <th>Annee</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Prix/jour</th>
                            <th>Places</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vehicules as $v): ?>
                        <tr>
                            <td><?= $v['id'] ?></td>
                            <td><?= htmlspecialchars($v['nom_vehicule']) ?></td>
                            <td><?= htmlspecialchars($v['marque']) ?></td>
                            <td><?= $v['annee_vehicule'] ?></td>
                            <td><?= htmlspecialchars($v['description']) ?></td>
                            <td><img src='../assets/images/<?= htmlspecialchars($v['image']) ?>' alt='Vehicle' style='max-width: 100px;'></td>
                            <td><?= $v['prix_jour'] ?> €</td>
                            <td><?= $v['nb_places'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- script pour afficher ou masquer le formulaire d'ajout de vehicule -->
            <script>
            function toggleForm() {
                const form = document.getElementById('form-ajout-vehicule');
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            }
            </script>
            <?php
            break;

            //affichage des utilisateurs ayant un compte
        case 'users':
            echo "<h2>Utilisateurs</h2>";

            $users = $bdd->query("SELECT id, nom, email FROM utilisateurs")->fetchAll(PDO::FETCH_ASSOC);

            echo "<table class='admin-table'>
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
                        <td>" . htmlspecialchars($u['nom']) . "</td>
                        <td>" . htmlspecialchars($u['email']) . "</td>
                      </tr>";
            }
            echo "</tbody></table>";
            break;

            //affichage des reservations par utilisateur ayant un compte ou non
        case 'reservations':
        echo "<h2>Réservations</h2>";
        
        $reservations = $bdd->query("SELECT * FROM reservation ORDER BY date_debut DESC")->fetchAll(PDO::FETCH_ASSOC);
        
        $reservations_rapides = $bdd->query("SELECT * FROM reservation_rapide ORDER BY date_debut DESC")->fetchAll(PDO::FETCH_ASSOC);

        echo "<h3>Reservations avec compte</h3>";
        echo "<table class='admin-table'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID Vehicule</th>
                        <th>ID Utilisateur</th>
                        <th>Date Debut</th>
                        <th>Date Fin</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>";
        foreach ($reservations as $r) {
            echo "<tr>
                    <td>{$r['id']}</td>
                    <td>{$r['id_vehicule']}</td>
                    <td>{$r['id_utilisateur']}</td>
                    <td>{$r['date_debut']}</td>
                    <td>{$r['date_fin']}</td>
                    <td>{$r['total']} €</td>
                </tr>";
        }
        echo "</tbody></table>";

        echo "<br><br>";

        echo "<h3>Reservations rapides</h3>";
        echo "<table class='admin-table'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>ID Vehicule</th>
                        <th>Date Debut</th>
                        <th>Date Fin</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>";
        foreach ($reservations_rapides as $r) {
            echo "<tr>
                    <td>{$r['id']}</td>
                    <td>{$r['nom']} {$r['prenom']}</td>
                    <td>{$r['email']}</td>
                    <td>{$r['id_vehicule']}</td>
                    <td>{$r['date_debut']}</td>
                    <td>{$r['date_fin']}</td>
                    <td>{$r['total']} €</td>
                </tr>";
        }
        echo "</tbody></table>";
        
        break;

        //affichage des message du formulaire de contact
        case 'contact':
            echo "<h2>Messages de contact</h2>";
            
            $messages = $bdd->query("SELECT id, nom, email, message FROM contact")->fetchAll(PDO::FETCH_ASSOC);

            echo "<table class='admin-table'>
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
                        <td>" . htmlspecialchars($m['nom']) . "</td>
                        <td>" . htmlspecialchars($m['email']) . "</td>
                        <td>" . htmlspecialchars($m['message']) . "</td>
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
    <title>GoDrive - Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Koulen&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
<div class="admin-container">

    <!-- Menu administrateur -->
    <aside class="admin-sidebar">

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
                    <a href="admin.php?page=vehicules" class="<?= $page === 'vehicules' ? 'active' : '' ?>">
                        <img src="../assets/images/dashboard.png" class="icon" alt=""> Vehicules
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

        <!-- bouton de deconnexion -->
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