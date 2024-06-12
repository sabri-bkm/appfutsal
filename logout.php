<?php
session_start();
session_destroy();
header("Location: ./views/login.php"); // Redirige vers la page de connexion après déconnexion
exit();
?>
