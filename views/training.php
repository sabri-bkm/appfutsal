<?php
session_start();
include('../config/database.php');

// Vérifier si l'utilisateur est connecté et s'il est un administrateur
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupérer les sessions d'entraînement
$query = "SELECT * FROM trainings ORDER BY date ASC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$trainings = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestion des Entraînements - Club de Futsal</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .training-list {
    list-style: none;
    padding: 0;
}

.training-item {
    background-color: #f9f9f9;
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 5px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

.training-info {
    font-size: 16px;
    color: #333;
}

.btn-edit, .btn-delete {
    background-color: #000;
    color: white;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 5px;
    margin-left: 10px;
}

.btn-edit:hover, .btn-delete:hover {
    background-color: #C3AB70;
    color: black;
}

    </style>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">


</head>
<body>
<header>
      <img src="../img/fondgabb.png" alt="">  
    </header>
    
    <div class="navbar">
        <a href="dashboard.php">DASHBOARD</a>
        <a href="scores.php">SCORES</a>
        <a href="training.php">ENTRAINEMENTS</a>
        <a href="forum.php">DISCUSSIONS</a>
    </div>
    <h1>Gestion des Entraînements</h1>
    <h2>Sessions d'entraînement existantes</h2>
        <ul class="training-list">
            <?php foreach ($trainings as $training): ?>
                <li class="training-item">
                    <span class="training-info"><?php echo htmlspecialchars($training['date']) . ' à ' . htmlspecialchars($training['time']) . ' - ' . htmlspecialchars($training['location']); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <div class="footer">
        &copy; GOLD AND BLACK 2024
    </div>
</body>
</html>

