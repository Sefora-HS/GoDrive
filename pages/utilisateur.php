<?php
require_once '../pages/config.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Récupérer les informations de l'utilisateur
$stmt = $bdd->prepare("SELECT * FROM utilisateurs WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Récupérer les réservations de l'utilisateur avec les infos des véhicules
$reservations = $bdd->prepare("
    SELECT 
        r.id,
        r.date_debut,
        r.date_fin,
        r.total,
        r.message,
        v.nom_vehicule,
        v.marque,
        v.image,
        v.prix_jour
    FROM reservation r
    INNER JOIN vehicules v ON r.id_vehicule = v.id
    WHERE r.id_utilisateur = ?
    ORDER BY r.date_debut DESC
");
$reservations->execute([$user_id]);
$mesReservations = $reservations->fetchAll(PDO::FETCH_ASSOC);
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
    <title>GoDrive - Mon Compte</title>
</head>
<body>
<?php
// Inclut le header
include('../templates/header.php');
?>
<main>
    <h1 class="compte-h1">Mon Compte</h1>
    <hr class="compte-hr">

    <section class="moncompte-section">

        <div class="mes-reservations">
            <h2>Mes reservations</h2>
            
            <?php if (empty($mesReservations)): ?>
                <p>Vous n'avez aucune réservation pour le moment.</p>
            <?php else: ?>
                <?php foreach ($mesReservations as $reservation): ?>
                    <div class="reservation-card">
                        <?php if (!empty($reservation['image'])): ?>
                            <img src="../assets/images/<?= htmlspecialchars($reservation['image']) ?>" alt="<?= htmlspecialchars($reservation['nom_vehicule']) ?>">
                        <?php endif; ?>
                        
                        <div class="reservation-content">
                            <h3><?= htmlspecialchars($reservation['marque'] . ' ' . $reservation['nom_vehicule']) ?></h3>
                            
                            <p><strong>Du :</strong> <?= date('d/m/Y', strtotime($reservation['date_debut'])) ?></p>
                            <p><strong>Au :</strong> <?= date('d/m/Y', strtotime($reservation['date_fin'])) ?></p>
                            
                            <?php
                            $date1 = new DateTime($reservation['date_debut']);
                            $date2 = new DateTime($reservation['date_fin']);
                            $interval = $date1->diff($date2);
                            $nbJours = $interval->days;
                            ?>
                            
                            <p><strong>Durée :</strong> <?= $nbJours ?> jour<?= $nbJours > 1 ? 's' : '' ?></p>
                            <p><strong>Prix/jour :</strong> <?= htmlspecialchars($reservation['prix_jour']) ?> €</p>
                            <p><strong>Total :</strong> <?= htmlspecialchars($reservation['total']) ?> €</p>
                            
                            <?php if (!empty($reservation['message'])): ?>
                                <p><strong>Message :</strong> <?= htmlspecialchars($reservation['message']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </section>
</main>
<?php
// Inclut le footer
include('../templates/footer.php');
?>
</body>
</html>