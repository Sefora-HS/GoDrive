<?php
require_once '../pages/config.php';

$erreurs = [];
$success = "";

// Récupérer et stocker les données  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // On recupere le nom et effectuons les tests de securité necessaire
    if (!empty($_POST["nom"])) {
        $nom = trim($_POST['nom']);
        $nom = htmlspecialchars($nom, ENT_QUOTES, 'UTF-8');
        
        if ($nom === '') {
            $erreurs[] = "Le nom est obligatoire";
        } elseif (strlen($nom) > 100) {
            $erreurs[] = "Le nom est trop long";
        } elseif (!preg_match("/^[a-zA-ZÀ-ÿ\s'-]+$/u", $nom)) {
            $erreurs[] = "Le nom contient des caractères invalides";
        }
    } else {
        $erreurs[] = "Attention le nom n'est pas valide. Veuillez saisir votre nom.";
        $nom = "";
    }

    // On recupere l'email et effectuons les tests de securité necessaire
    if (!empty($_POST["email"])) {
        $email = trim($_POST['email']);
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = '';
            $erreurs[] = "Attention le mail n'est pas valide. Veuillez saisir votre adresse électronique.";
        }
    } else {
        $erreurs[] = "Attention le mail n'est pas valide. Veuillez saisir votre adresse électronique.";
        $email = ''; 
    }

    // // On recupere le mesage et effectuons les tests de securité necessaire
    if (!empty($_POST["message"])) {
        $message = trim($_POST['message']);
        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
        
        if ($message === '') {
            $erreurs[] = "Veuillez saisir votre message.";
        }
    } else {
        $erreurs[] = "Veuillez saisir votre message.";
        $message = ''; 
    }

    // Si aucune erreur on envoie le formulaire
    if (empty($erreurs)) {
        try {
            // Insertion dans la base de données
            $stmt = $bdd->prepare("INSERT INTO contact (nom, email, message) VALUES (?, ?, ?)");
            $stmt->execute([$nom, $email, $message]);
            
            $success = "Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.";
            
            // Réinitialiser les variables apres avoir envoyé la requete
            $nom = $email = $message = "";
            
        } catch (PDOException $e) {
            $erreurs[] = "Erreur lors de l'enregistrement : " . $e->getMessage();
        }
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
    <title>GoDrive - Contact</title>
</head>
<body>
<?php
// Inclure le template header
include('../templates/header.php');
?>
<main>
    <section class="contact-title">
        <h1>Contact</h1>
    </section>
    
    <section class="form-contact-section">
        <h2>Formulaire de contact</h2>

        <!-- Affichage des erreurs -->
        <?php if (!empty($erreurs)): ?>
            <div class="error-messages">
                <?php foreach ($erreurs as $erreur): ?>
                    <p class="error"><?= htmlspecialchars($erreur) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <p class="success"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <!-- Formulaire contact -->
        <form action="" method="post" class="contact-form">
            <div class="contact-nom">
                <input type="text" name="nom" placeholder="Nom/Prénom" value="<?= isset($nom) ? htmlspecialchars($nom) : '' ?>" required>
                <input type="email" name="email" placeholder="Adresse mail" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required>
            </div>
            
            <textarea name="message" placeholder="Votre message..." class="input-msg" rows="6" required><?= isset($message) ? htmlspecialchars($message) : '' ?></textarea>

            <button type="submit">Nous contacter</button>
        </form>
    </section>
</main>
<?php
// Inclut le footer
include('../templates/footer.php');
?>
</body>
</html>