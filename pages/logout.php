<?php
require_once '../pages/config.php';
session_start();   // session démarée
session_unset();   // supprime toutes les variables stockées dans la session
session_destroy(); // supprime la session


header("Location: ../index.php"); // une fois déconnecté redirection auto vers la page index ( location ici veut dire vers ou on est redirigé )
exit(); // fin script

?>
