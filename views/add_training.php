<?php
session_start();
include('../config/database.php');

// Vérifier si l'utilisateur est connecté et s'il est un administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$error_message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];

    $query = "INSERT INTO trainings (date, time, location, capacity) VALUES (:date, :time, :location, :capacity)";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['date' => $date, 'time' => $time, 'location' => $location, 'capacity' => $capacity]);

    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une Séance d'Entraînement - Club de Futsal</title>
    <style>
        h1 {
    color: #333;
    margin-bottom: 20px;
    text-align:center;
}

    
    .container {
    padding: 20px;
    max-width: 800px;
    margin: auto;
    background-color: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    color: #333;
    margin-bottom: 20px;
    text-align:center;
}

.form-training {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: #333;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

.btn-submit {
    background-color: #000;
    color: white;
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin-top: 10px;
    cursor: pointer;
    border-radius: 5px;
}

.btn-submit:hover {
    background-color: #C3AB70;
}

.training-list {
    list-style-type: none;
    padding: 0;
}

.training-list li {
    background-color: #f9f9f9;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn-edit, .btn-delete {
    text-decoration: none;
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    margin-left: 10px;
}

.btn-edit {
    background-color: #4CAF50;
}

.btn-edit:hover {
    background-color: #45a049;
}

.btn-delete {
    background-color: #f44336;
}

.btn-delete:hover {
    background-color: #da190b;
}
</style>
    <link rel="stylesheet" type="text/css" href="styles.css">
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
    <div class="container">
        <h2>Créer une nouvelle session d'entraînement</h2>
        <form action="add_training.php" method="POST" class="form-training">
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="time">Heure:</label>
                <input type="time" id="time" name="time" required>
            </div>
            <div class="form-group">
                <label for="location">Lieu:</label>
                <input type="text" id="location" name="location" required>
            </div>
            <div class="form-group">
                <label for="capacity">Capacité:</label>
                <input type="number" id="capacity" name="capacity" required>
            </div>
            <button type="submit" class="btn-submit">Créer</button>
        </form>
</div>
    <div class="footer">
        &copy; GOLD AND BLACK 2024
    </div>
</body>
</html>
