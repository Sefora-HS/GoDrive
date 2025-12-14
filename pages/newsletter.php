
<?php
require_once '../pages/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email']);

    // verification de sécurité email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../index.php?newsletter=invalid");
        exit;
    }

    // verification si l'email deja inscrit dans la base de donnée
    $check = $bdd->prepare("SELECT id FROM newsletter WHERE email = :email");
    $check->execute([':email' => $email]);

    if ($check->rowCount() > 0) {
        header("Location: ../index.php?newsletter=exists");
        exit;
    }

    // Insertion
    $insert = $bdd->prepare("INSERT INTO newsletter (email) VALUES (:email)");
    $insert->execute([':email' => $email]);

    header("Location: ../index.php?newsletter=success");
    exit;
}
?>

<?php
if (isset($_GET['newsletter'])) {
    if ($_GET['newsletter'] === 'success') echo "<p class='success'>Inscription à la newsletter réussie</p>";
    if ($_GET['newsletter'] === 'exists') echo "<p class='error'>Email déjà inscrit</p>";
    if ($_GET['newsletter'] === 'invalid') echo "<p class='error'>Email invalide</p>";
}
?>