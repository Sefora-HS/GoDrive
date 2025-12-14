<?php
require_once '../pages/config.php';

// Envoie du formulaire et verification des champs
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom'])) {
    try {
        // Récupération et validation des données
        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $email = trim($_POST['email']);
        $adresse = trim($_POST['adresse']);
        $ville = trim($_POST['ville']);
        $code_postal = trim($_POST['code_postal']);
        $message = trim($_POST['message'] ?? '');
        $id_vehicule = intval($_POST['vehicule_id']);
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        
        // Calcul du total
        $vehicule = $bdd->prepare("SELECT prix_jour FROM vehicules WHERE id = ?");
        $vehicule->execute([$id_vehicule]);
        $vehiculeData = $vehicule->fetch(PDO::FETCH_ASSOC);
        
        if ($vehiculeData) {
            $dateDebutObj = new DateTime($date_debut);
            $dateFinObj = new DateTime($date_fin);
            $interval = $dateDebutObj->diff($dateFinObj);
            $nbJours = $interval->days;
            $total = $nbJours * $vehiculeData['prix_jour'];
            
            // Insertion dans la base de données
            $stmt = $bdd->prepare("INSERT INTO reservation_rapide (nom, prenom, email, adresse, ville, code_postal, id_vehicule, date_debut, date_fin, total, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            $stmt->execute([
                $nom,
                $prenom,
                $email,
                $adresse,
                $ville,
                $code_postal,
                $id_vehicule,
                $date_debut,
                $date_fin,
                $total,
                $message
            ]);
            
            $success = "Votre réservation a été enregistrée avec succès !";
        } else {
            $error = "Véhicule non trouvé.";
        }
    } catch (PDOException $e) {
        $error = "Erreur lors de l'enregistrement : " . $e->getMessage();
    }
}

// si on vient depuis une page produit alors saisir les données de la page (dates et id véhicule) sinon on laisse ces données vides 
$dateDebut = $_POST['date_debut'] ?? '';
$dateFin   = $_POST['date_fin'] ?? '';
$vehiculeId = $_POST['vehicule_id'] ?? '';

// récupération de la liste des véhicules pour le select
$vehicules = $bdd->query("SELECT id, nom_vehicule, marque, prix_jour FROM vehicules")->fetchAll(PDO::FETCH_ASSOC);

// si un véhicule est sélectionné, récupérer ses infos
$vehiculeSelectionne = null;
if ($vehiculeId) {
    $stmt = $bdd->prepare("SELECT * FROM vehicules WHERE id = ?");
    $stmt->execute([$vehiculeId]);
    $vehiculeSelectionne = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <title>GoDrive - Réservation Rapide</title>
</head>
<body>
<?php
// Inclure le header
include('../templates/header.php');
?>
<main>
    <section class="title-section">
        <h1>Formulaire Reservation rapide</h1>
    </section>

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

    <section class="form-reservation-section">

        <form action="" method="post" class="form-reservation">

            <div class="right-reservation">

                <div class="row">
                    <input type="text" name="nom" placeholder="Nom :" class="input" required>
                    <input type="text" name="prenom" placeholder="Prénom :" class="input" required>
                </div>

                <div class="row">
                    <input type="email" name="email" placeholder="Adresse Mail :" class="input input-full" required>
                </div>

                <div class="row">
                    <input type="text" name="adresse" placeholder="Adresse :" class="input input-full" required>
                </div>

                <div class="row">
                    <input type="text" name="ville" placeholder="Ville :" class="input" required>
                    <input type="text" name="code_postal" placeholder="Code postal :" class="input" required>
                </div>

                <div class="row">
                    <textarea name="message" placeholder="Message (facultatif) :" class="input input-full input-msg"></textarea>
                </div>
            </div>

            <div class="left-reservation">
                
                <!-- Sélection du véhicule -->
                <div class="row">
                    <label for="vehicule_id">Véhicule :</label>
                    <select name="vehicule_id" id="vehicule_id" class="input" required>
                        <option value="">-- Choisir un véhicule --</option>
                        <?php foreach ($vehicules as $v): ?>
                            <option value="<?= $v['id'] ?>" <?= $vehiculeId == $v['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($v['marque'] . ' ' . $v['nom_vehicule'] . ' - ' . $v['prix_jour'] . '€/jour') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if ($vehiculeSelectionne): ?>
                    <div class="vehicule-info">
                        <h3><?= htmlspecialchars($vehiculeSelectionne['marque'] . ' ' . $vehiculeSelectionne['nom_vehicule']) ?></h3>
                        <?php if (!empty($vehiculeSelectionne['image'])): ?>
                            <img src="../assets/images/<?= htmlspecialchars($vehiculeSelectionne['image']) ?>" alt="Véhicule" style="max-width: 100%; height: auto;">
                        <?php endif; ?>
                        <p><strong>Prix :</strong> <?= $vehiculeSelectionne['prix_jour'] ?>€/jour</p>
                        <p><strong>Places :</strong> <?= $vehiculeSelectionne['nb_places'] ?></p>
                    </div>
                <?php endif; ?>

                <!-- Dates de réservation -->
                <div class="row">
                    <label for="date_debut">Date de début :</label>
                    <input
                        type="date"
                        id="date_debut"
                        name="date_debut"
                        value="<?= htmlspecialchars($dateDebut) ?>"
                        min="<?= date('Y-m-d') ?>"
                        class="input"
                        required>
                </div>

                <div class="row">
                    <label for="date_fin">Date de fin :</label>
                    <input
                        type="date"
                        id="date_fin"
                        name="date_fin"
                        value="<?= htmlspecialchars($dateFin) ?>"
                        min="<?= date('Y-m-d') ?>"
                        class="input"
                        required>
                </div>

                <button type="submit">Reserver ➡</button>
            </div>

        </form>

    </section>
    <section class="background">
        <div class="chiffres-reservation">
            <div class="chiffres-reservation-item">
                <p class="chiffre">80</p>
                <p class="chiffre-desc">+80 destinations dans toute la France</p>
            </div>
            <div class="chiffres-reservation-item">
                <p class="chiffre">100k</p>
                <p class="chiffre-desc">+100k visiteurs chaque semaine</p>
            </div>
            <div class="chiffres-reservation-item">
                <p class="chiffre">800</p>
                <p class="chiffre-desc">+800 modeles disponibles a la location</p>
            </div>
            <div class="chiffres-reservation-item">
                <p class="chiffre">600</p>
                <p class="chiffre-desc">En moyenne 600 voitures louees chaque jour</p>
            </div>
        </div>
    </section>
</main>
<?php
// Inclure le footer
include('../templates/footer.php');
?>
</body>
</html>