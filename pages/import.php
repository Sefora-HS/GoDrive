<?php

require_once 'config.php';

// Chemin vers le fichier SQL
$sqlFile = 'sql/concessionnaire.sql';

// On verifie que le fichier existe
if (!file_exists($sqlFile)) {
    die("Fichier SQL introuvable : $sqlFile");
}

// on lit le contenu du fichier sql
$sql = file_get_contents($sqlFile);

try {
    $bdd->exec($sql);
    echo "Base importée avec succès !";
} catch (PDOException $e) {
    die("Erreur à l'import : " . $e->getMessage());
}
?>
