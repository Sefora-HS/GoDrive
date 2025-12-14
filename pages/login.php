<?php
require_once '../pages/config.php';

// Si l'utilisateur est déjà connecté, redirection vers l'accueil
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifiant = trim($_POST['identifiant']);
    $password = $_POST['password'];

    try {
        $stmt = $bdd->prepare("SELECT * FROM utilisateurs WHERE identifiant = :id");
        $stmt->execute([':id' => $identifiant]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // On verifie si le  mot de passe est hashé
            $passwordMatch = false;
            
            if (password_verify($password, $user['motdepasse'])) {
                $passwordMatch = true;
            } elseif ($password === $user['motdepasse']) {
                $passwordMatch = true;
                
                // Hashage du mot de passe
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $updateStmt = $bdd->prepare("UPDATE utilisateurs SET motdepasse = :pwd WHERE id = :id");
                $updateStmt->execute([':pwd' => $hashedPassword, ':id' => $user['id']]);
            }
            
            if ($passwordMatch) {
                // Etablir la connexion
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['prenom'] = $user['prenom'];

                // Redirection vers index ou admin en fonction du role
                if ($user['role'] === 'admin') {
                    header("Location: admin.php");
                } else {
                    header("Location: ../index.php");
                }
                exit;
            } else {
                $erreur = "Identifiants incorrects";
            }
        } else {
            $erreur = "Identifiants incorrects";
        }
    } catch (PDOException $e) {
        $erreur = "Erreur de connexion à la base de données";
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
    <title>GoDrive - Connexion</title>
</head>
<body>
<?php
// Inclure le header
include('../templates/header.php');
?>
<main>
    <section class="login-section">
        <img src="../assets/images/logo.png" alt="logo site" class="login-img">
        <h2 class="login-title">Connexion</h2>

        <?php if (isset($erreur)): ?>
            <div class="error-message">
                <?= htmlspecialchars($erreur) ?>
            </div>
        <?php endif; ?>

        <form action="" method="post" class="login-form">
            <div class="form-container">
                <input type="text" name="identifiant" placeholder="Nom d'utilisateur" class="login-input" required value="<?= isset($_POST['identifiant']) ? htmlspecialchars($_POST['identifiant']) : '' ?>">
                <input type="password" name="password" placeholder="Mot de passe" class="login-input" required>
            </div>

            <div class="connexion-2">
                <div>
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Se souvenir de moi</label>
                </div>

                <a href="inscription.php" class="link-signin">Pas de compte ? Je m'inscris !</a>
            </div>

            <button type="submit">Se connecter</button>
        </form>
    </section>
</main>
<?php
// Inclure le footer
include('../templates/footer.php');
?>
</body>
</html>