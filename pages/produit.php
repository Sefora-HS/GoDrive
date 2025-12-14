<?php
//connection
require_once '../pages/config.php';

// Si l'utilisateur n'est pas connecté → redirection
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Vérification que l'utilisateur existe encore dans la BDD
$verif = $bdd->prepare("SELECT id FROM utilisateurs WHERE id = :id");
$verif->execute([':id' => $_SESSION['user_id']]);
if ($verif->rowCount() == 0) {
    unset($_SESSION['user_id']);
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// ----------  Récupérer l'ID du produit dans l'URL ---------
if (!isset($_GET['id'])) {
    echo "Aucun produit sélectionné.";
    exit;
}

$vehicule_id = (int) $_GET['id']; // Sécurisation simple

// récupérer les informations du vehicule 
$stmt = $bdd->prepare("SELECT * FROM vehicules WHERE id = ?");
$stmt->execute([$vehicule_id]);
$vehicule = $stmt->fetch(PDO::FETCH_ASSOC);

// ---------- Vérifier si le produit existe ----------
if (!$vehicule) {
    echo "Vehicule introuvable.";
    exit;
}

$nb_places = $vehicule['nb_places'];

// ========== TRAITEMENT DE LA RÉSERVATION ==========
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
    try {
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $message = trim($_POST['message'] ?? '');
        
        // Validation des dates
        $dateDebutObj = new DateTime($date_debut);
        $dateFinObj = new DateTime($date_fin);
        $aujourdhui = new DateTime();
        $aujourdhui->setTime(0, 0, 0);
        
        // Vérifier que les dates sont dans le futur
        if ($dateDebutObj < $aujourdhui) {
            $error = "La date de début doit être aujourd'hui ou dans le futur.";
        } elseif ($dateFinObj <= $dateDebutObj) {
            $error = "La date de fin doit être après la date de début.";
        } else {
            // Calcul du nombre de jours et du total
            $interval = $dateDebutObj->diff($dateFinObj);
            $nbJours = $interval->days;
            $total = $nbJours * $vehicule['prix_jour'];
            
            // Insertion de la réservation
            $insertReservation = $bdd->prepare("
                INSERT INTO reservation (id_utilisateur, id_vehicule, date_debut, date_fin, total, message)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            
            $insertReservation->execute([
                $user_id,
                $vehicule_id,
                $date_debut,
                $date_fin,
                $total,
                $message
            ]);
            
            $success = "Votre réservation a été enregistrée avec succès ! Vous pouvez la consulter dans votre compte.";
        }
    } catch (PDOException $e) {
        $error = "Erreur lors de la réservation : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Koulen&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>GoDrive - <?= htmlspecialchars($vehicule['nom_vehicule']) ?></title>
</head>

<body>
    <?php
    // Inclut le header
    include('../templates/header.php');
    ?>
    <main class="main">

        <h1 class="h1-produit">
            <?= htmlspecialchars($vehicule['nom_vehicule']) ?>
        </h1>

        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <div class="container-prod">
            <div class="colonne-prod">
                <img src="../assets/images/<?= htmlspecialchars($vehicule['image']) ?>"
                    alt="<?= htmlspecialchars($vehicule['nom_vehicule']) ?>">
                
                <!-- Description voiture -->
                <div class="description">
                    <h3>Description</h3>
                    <p><?= htmlspecialchars($vehicule['description']) ?></p>
                    <p><strong>Nombre de places :</strong> <?= $nb_places ?></p>
                    <p><strong>Année :</strong> <?= htmlspecialchars($vehicule['annee_vehicule']) ?></p>
                    <p><strong>Marque :</strong> <?= htmlspecialchars($vehicule['marque']) ?></p>
                    <p><strong>Prix par jour :</strong> <?= htmlspecialchars($vehicule['prix_jour']) ?> €</p>
                </div>
            </div>

            <div class="colonne-prod">
                <div class="nom_vehicule_prod"> 
                    <?= htmlspecialchars($vehicule['marque'] . ' ' . $vehicule['nom_vehicule']) ?> 
                </div>

                <form action="" method="POST" class="form-reservation-produit">
                    <input type="hidden" name="vehicule_id" value="<?= $vehicule['id'] ?>">

                    <div class="reservation-grid">
                        <div class="date-wrapper">
                            <label for="dateDebut">Date de debut</label>
                            <input type="date" id="dateDebut" name="date_debut" min="<?= date('Y-m-d') ?>" required>
                        </div>

                        <div class="date-wrapper">
                            <label for="dateFin">Date de fin</label>
                            <input type="date" id="dateFin" name="date_fin" min="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>

                    <div class="message-wrapper">
                        <label for="message">Message (facultatif)</label>
                        <textarea id="message" name="message" rows="4" placeholder="Informations complémentaires..."></textarea>
                    </div>

                    <div class="total-section">
                        <span class="total-label">Total :</span>
                        <span class="total-prix"><span id="prix">—</span> €</span>
                    </div>

                    <p class="information">
                        Une fois votre réservation validée, retrouvez votre récapitulatif de commande sur votre compte dans la rubrique <a href="../pages/utilisateur.php">"Mon compte"</a>
                    </p>

                    <!-- Bouton réserver -->
                    <button type="submit" class="pill-btn" aria-label="Réserver">
                        Reserver
                    </button>

                </form>
            </div>
        </div>

    </main>

    <?php
    // Inclut le footer
    include('../templates/footer.php');
    ?>

    <script>
        // Avoir le prix qui s'affiche directement sur la page
        const prixJour = <?= $vehicule['prix_jour'] ?>;

        const debut = document.querySelector('[name="date_debut"]');
        const fin   = document.querySelector('[name="date_fin"]');
        const prix  = document.getElementById('prix');

        function calculPrix() {
            if (debut.value && fin.value) {
                const d1 = new Date(debut.value);
                const d2 = new Date(fin.value);
                const jours = Math.ceil((d2 - d1) / (1000 * 60 * 60 * 24));

                if (jours > 0) {
                    prix.textContent = (jours * prixJour).toFixed(2);
                } else {
                    prix.textContent = "—";
                }
            }
        }

        debut.addEventListener('change', calculPrix);
        fin.addEventListener('change', calculPrix);
        
        // Définir la date de fin minimum en fonction de la date de début
        debut.addEventListener('change', function() {
            fin.min = debut.value;
        });
    </script>

</body>

</html>