?php
//connection
require_once '../pages/config.php';

/* ---------- Connexion à la base de données ----------
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=consessionnaire;charset=utf8",
        "root",
        ""
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

*/

// ----------  Récupérer l'ID du produit dans l'URL ----------
if (!isset($_GET['id'])) {
    echo "Aucun produit sélectionné.";
    exit;
}

$vehicules = (int) $_GET['id']; // Sécurisation simple



// récupérer les informtions du vehicule 
$stmt = $pdo->prepare("SELECT * FROM vehicules WHERE id = ?");
$stmt->execute([$vehicule_id]);
$vehicule = $stmt->fetch();


// ---------- 4. Vérifier si le produit existe ----------
if (!$vehicule) {
    echo "Vehicule introuvable.";
    exit;
}
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
    <title>GoDrive - <?= htmlspecialchars($vehicule['nom_vehicule']) ?></title>
</head>

<body>
    <?php
    // Inclut le header
    include('../templates/header.php');
    ?>
    <main>


        <h1>
            <?= htmlspecialchars($vehicule['nom_vehicule']) ?>
        </h1>


        <img src="images/<?= htmlspecialchars($vehicule['image']) ?>"
            alt="<?= htmlspecialchars($vehicule['nom_vehicule']) ?>">
        <div class="nom_vehicule_prod"> <?= htmlspecialchars($vehicule['nom_vehicule']) ?> </div>

        <div class="date-wrapper">
            <label for="dateDebut">Date début</label>
            <input type="date" id="dateDebut" name="dateDebut">
        </div>
        <div class="date-wrapper">
            <label for="dateFin">Date fin</label>
            <input type="date" id="dateFin" name="dateFin">
        </div>

        <div class="input-box">
            <select name="places" required>
                <option value="" disabled selected>NBR DE PLACES</option>

                <?php
                for ($i = 1; $i <= $nb_places; $i++) {
                    echo "<option value='$i'>$i place" . ($i > 1 ? 's' : '') . "</option>";
                }
                ?>
            </select>
        </div>

        <p class="description">
            <?= htmlspecialchars($vehicule['description']) ?>
        </p>

        <p class="prix">
            Total : <?= htmlspecialchars($vehicule['prix_jour']) ?> €
        </p>


        <p class="information">
            Une fois votre réservation validée, retrouvez votre récapitulatif de commande su votre compte dans la rubrique <a href="./mesreservations">"Mes réservations"</a>
        </p>


        <button class="pill-btn" aria-label="Réserver">
            Réserver
        </button>




    </main>
    <?php
    // Inclut le header
    include('../templates/footer.php');
    ?>
</body>


</html>
