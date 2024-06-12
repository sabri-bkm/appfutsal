<?php
session_start();
include('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && $_SESSION['user_role'] == 'admin') {
    $id = $_POST['id'];

    // Supprimer le score
    $query = "DELETE FROM scores WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);

    header("Location: manage_content.php");
    exit();
}
?>
