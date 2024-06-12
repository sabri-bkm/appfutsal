<!-- index.php -->
<?php
// Point d'entrée principal de l'application
// Inclure les fichiers nécessaires et rediriger vers les bonnes pages

// Exemple simple de redirection
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'register':
            include('views/register.php');
            break;
        case 'login':
            include('views/login.php');
            break;
        default:
            include('views/home.php');
            break;
    }
} else {
    include('views/home.php');
}
?>
