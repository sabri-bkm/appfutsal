<?php
session_start();
include('../config/database.php');

// Vérifier si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Vérifier si l'ID de la session d'entraînement est fourni
if (!isset($_POST['id'])) {
    header("Location: manage_content.php");
    exit();
}

$id = $_POST['id'];

// Supprimer la session d'entraînement
$query = "DELETE FROM trainings WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $id]);

header("Location: manage_content.php");
exit();
?>
