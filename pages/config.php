<?php

$user = 'root';
$mdp = '';

try {
    $bdd = new PDO('mysql:host=localhost;dbname=concessionnaire;charset=utf8', $user, $mdp);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
