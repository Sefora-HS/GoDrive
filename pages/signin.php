<?php
require_once '../pages/config.php';

$erreur = "";
$succes = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 1. Récupération et sécurisation
    $nom        = trim($_POST['nom']);
    $prenom     = trim($_POST['prenom']);
    $identifiant= trim($_POST['id']);
    $email      = trim($_POST['email']);
    $password   = $_POST['password'];
    $password2  = $_POST['password-confirm'];

    // 2. Vérification champs vides
    if (empty($nom) || empty($prenom) || empty($identifiant) || empty($email) || empty($password) || empty($password2)) {
        $erreur = "Tous les champs sont obligatoires.";
    }

    // 3. Vérification email
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Adresse email invalide.";
    }

    // 4. Vérification mots de passe
    elseif ($password !== $password2) {
        $erreur = "Les mots de passe ne correspondent pas.";
    }

    // 5. Vérifier si identifiant ou email existe déjà
    else {
        $check = $bdd->prepare("SELECT id FROM utilisateurs WHERE identifiant = :identifiant OR email = :email");
        $check->execute([
            ':identifiant' => $identifiant,
            ':email' => $email
        ]);

        if ($check->rowCount() > 0) {
            $erreur = "Identifiant ou email déjà utilisé.";
        } else {

            // 6. Hash du mot de passe
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // 7. Insertion
            $insert = $bdd->prepare("
                INSERT INTO utilisateurs 
                (identifiant, motdepasse, nom, prenom, email, adresse, ville, code_postal, role)
                VALUES 
                (:identifiant, :motdepasse, :nom, :prenom, :email, '', '', '', 'client')
            ");

            $insert->execute([
                ':identifiant' => $identifiant,
                ':motdepasse'  => $passwordHash,
                ':nom'         => $nom,
                ':prenom'      => $prenom,
                ':email'       => $email
            ]);

            $succes = "Inscription réussie ! Vous pouvez vous connecter.";
        }
    }
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
    <title>GoDrive</title>
</head>
<body>
<?php
// Inclut le header
include('../templates/header.php');
?>
<main>
    <section class="signin-section">
        <img src="../assets/images/logo.png" alt="logo site" class="login-img">
        <h2 class="login-title">Inscription</h2>
        <form action="" method="post" class="signin-form">
            <div class="signin-inputs">
                <div class="bloc">
                    <input name="nom" type="text" placeholder="Nom : " class="signin-input" required>
                    <input name="id" type="text" placeholder="Identifiant : " class="signin-input" required>
                    <input name="password" type="password" placeholder="Mot de passe : " class="signin-input" required>
                </div>
                
                <div class="bloc">
                    <input name="prenom" type="text" placeholder="Prénom : " class="signin-input" required>
                    <input name="email" type="email" placeholder="Adresse mail : " class="signin-input" required>
                    <input name="password-confirm" type="password" placeholder="Mot de passe (confirmation) : " class="signin-input" required>
                </div>
            </div>

            <button type="submit">Je m'inscris</button>
        </form>
        <?php if (!empty($erreur)): ?>
            <p class="error"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>

        <?php if (!empty($succes)): ?>
            <p class="success"><?= htmlspecialchars($succes) ?></p>
        <?php endif; ?>
    </section>
</main>
<?php
// Inclut le header
include('../templates/footer.php');
?>
</body>
</html>
