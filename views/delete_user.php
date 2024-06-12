<?php
session_start();
include('../config/database.php');

if (isset($_GET['id']) && isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'admin') {
    $id = $_GET['id'];

    // Supprimer l'utilisateur
    $query = "DELETE FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);

    header("Location: manage_users.php");
    exit();
}
?>
