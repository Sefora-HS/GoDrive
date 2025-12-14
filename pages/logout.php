<?php
require_once '../pages/config.php';
//demarrage de la session
session_start();
//supprimer les variables stocké
session_unset();
//supprimer la session
session_destroy();

//redirection vers la page index quand connecté
header("Location: ../index.php");
exit();

?>
