<?php

require_once 'config.php'; // connexion PDO

// Chemin vers le fichier SQL
$sqlFile = 'sql/concessionnaire.sql';

// Vérifie que le fichier existe
if (!file_exists($sqlFile)) {
    die("Fichier SQL introuvable : $sqlFile");
}

// Lit le contenu du fichier SQL
$sql = file_get_contents($sqlFile);

try {
    // Exécute toutes les commandes SQL du fichier
    $pdo->exec($sql);
    echo "Base importée avec succès !";
} catch (PDOException $e) {
    die("Erreur à l'import : " . $e->getMessage());
}
?>
