<?php
require_once '../pages/config.php';

// securisations éléments 
// 1-Nom 
echo htmlspecialchars($nom, ENT_QUOTES, 'UTF-8');

if ($nom === '') {
    $erreurs[] = "Le nom est obligatoire";
}
if (strlen($nom) > 100) {
    $erreurs[] = "Le nom est trop long";
}
if (!preg_match("/^[a-zA-ZÀ-ÿ\s'-]+$/u", $nom)) {
    $erreurs[] = "Le nom contient des caractères invalides";
}

//mail 
if (!filter_var($email, FILTER_VALIDATE_EMAIL){
    echo "Attention, adresse email invalide"; 
$email=""
    }



//envoyer par mail à l'entreprise le contenu du message envoyer par la page 
if ($_SERVER['REQUEST_METHOD']==='POST'){

    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if ( $nom && filter_var(*email, FILTER_VALIDATE_EMAIL) && $message) {
        
 // le message laissé dans la page est envoyé au mail pro de l'entreprise
        mail(
            "aya.treyaoui@etu.unilim.fr" , // contact d'un membre de l'équipe pour tester et exploiter les fonctionnalités mais le véritable mail doit être le pro de l'entreprise
            " Message laissé par $nom ($email), 
            "Message laissé: <br> $message ", 
            ); 

            echo 
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
    <section class="contact-title">
        <h1>Contact</h1>
    </section>
    <section class="form-contact-section">

    <h2>Formulaire de contact</h2>

    <form action="" method="post" class="contact-form">
        <div class="contact-nom">
            <input type="text" name="nom" placeholder="Nom/Prenom :" required>
            <input type="email" name="email" placeholder="Adresse mail :" required>
        </div>
        
        <input type="text" name="message" placeholder="Message :" class="input-msg" required>

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
