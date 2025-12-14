<?php
require_once '../pages/config.php';

// Si l'utilisateur est déjà connecté, redirection vers l'accueil
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

$erreur = "";
$succes = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // récupération et sécurisation des infos
    $nom        = trim($_POST['nom']);
    $prenom     = trim($_POST['prenom']);
    $identifiant= trim($_POST['id']);
    $email      = trim($_POST['email']);
    $password   = $_POST['password'];
    $password2  = $_POST['password-confirm'];

    // verification si champs vide
    if (empty($nom) || empty($prenom) || empty($identifiant) || empty($email) || empty($password) || empty($password2)) {
        $erreur = "Tous les champs sont obligatoires.";
    }

    // verification de l'email
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Adresse email invalide.";
    }

    // verification du mdp
    elseif (strlen($password) < 6) {
        $erreur = "Le mot de passe doit contenir au moins 6 caractères.";
    }

    // verification de la confirmation du mdp
    elseif ($password !== $password2) {
        $erreur = "Les mots de passe ne correspondent pas.";
    }

    // verifier si les id entrées existe deja
    else {
        try {
            $check = $bdd->prepare("SELECT id FROM utilisateurs WHERE identifiant = :identifiant OR email = :email");
            $check->execute([
                ':identifiant' => $identifiant,
                ':email' => $email
            ]);

            if ($check->rowCount() > 0) {
                $erreur = "Identifiant ou email déjà utilisé.";
            } else {

                // hashage du mdp
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                // insertion dans la bdd
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

                $succes = "Inscription réussie ! Redirection vers la page de connexion...";
                
                // redirection une fois inscrit vers la page login
                header("refresh:2;url=login.php");
            }
        } catch (PDOException $e) {
            $erreur = "Erreur lors de l'inscription : " . $e->getMessage();
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
    <title>GoDrive - Inscription</title>
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

        <?php if (!empty($erreur)): ?>
            <p class="error"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>

        <?php if (!empty($succes)): ?>
            <p class="success"><?= htmlspecialchars($succes) ?></p>
        <?php endif; ?>

        <form action="" method="post" class="signin-form">
            <div class="signin-inputs">
                <div class="bloc">
                    <input name="nom" type="text" placeholder="Nom" class="signin-input" required value="<?= isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '' ?>">
                    <input name="id" type="text" placeholder="Identifiant" class="signin-input" required value="<?= isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '' ?>">
                    <input name="password" type="password" placeholder="Mot de passe (min. 6 caractères)" class="signin-input" required>
                </div>
                
                <div class="bloc">
                    <input name="prenom" type="text" placeholder="Prénom" class="signin-input" required value="<?= isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '' ?>">
                    <input name="email" type="email" placeholder="Adresse mail" class="signin-input" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                    <input name="password-confirm" type="password" placeholder="Confirmer le mot de passe" class="signin-input" required>
                </div>
            </div>

            <button type="submit">Je m'inscris</button>
            
            <p class="signin-link">Déjà un compte ? <a href="login.php">Je me connecte</a></p>
        </form>
    </section>
</main>
<?php
// Inclut le footer
include('../templates/footer.php');
?>
</body>
</html>