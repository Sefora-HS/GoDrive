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
    <main class="catalogue-container">

<?php
// Récupérer toutes les voitures
$stmt = $conn->prepare("SELECT * FROM voitures");
$stmt->execute();
$voitures = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si aucune voiture trouvée
if (!$voitures) {
    echo "<p class='message-vide'>Aucun véhicule disponible pour le moment.</p>";
}
?>

<section class="grille-catalogue">

<?php foreach ($voitures as $v): ?>
    <div class="carte-voiture">
        <img src="../assets/images/<?php echo $v['image']; ?>" alt="Image voiture" class="img-voiture">
        
        <h3 class="titre-voiture"><?php echo htmlspecialchars($v['marque'] . " " . $v['modele']); ?></h3>

        <p class="texte-voiture"> <?php echo htmlspecialchars($v['motorisation']); ?> – 
        <?php echo htmlspecialchars($v['puissance']); ?> ch</p>

        <p class="prix-voiture"><?php echo $v['prix_jour']; ?>€ / jour</p>

        <a href="produit.php?id=<?php echo $v['id']; ?>" class="btn-voiture">Voir plus</a>
    </div>
<?php endforeach; ?>

</section>
</main>

<?php
// Inclut le header
include('../templates/footer.php');
?>
</body>

</html>

