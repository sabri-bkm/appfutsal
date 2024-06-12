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
    $team1 = $_POST['team1'];
    $score1 = $_POST['score1'];
    $team2 = $_POST['team2'];
    $score2 = $_POST['score2'];
    $match_date = $_POST['match_date'];

    $query = "INSERT INTO scores (team1, score1, team2, score2, match_date) VALUES (:team1, :score1, :team2, :score2, :match_date)";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['team1' => $team1, 'score1' => $score1, 'team2' => $team2, 'score2' => $score2, 'match_date' => $match_date]);

    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un Score - Club de Futsal</title>
    <style>
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
}

.form-score {
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

.score-list {
    list-style-type: none;
    padding: 0;
}

.score-list li {
    background-color: #f9f9f9;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    margin-bottom: 10px;
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
    <h2>Ajouter un Score</h2>
    <?php if ($error_message): ?>
        <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
    <div class="container">
        <h2>Scores des Matchs</h2>
        <?php if ($_SESSION['user_role'] == 'admin'): ?>
            <form action="scores.php" method="POST" class="form-score">
                <div class="form-group">
                    <label for="match_date">Date du Match:</label>
                    <input type="date" id="match_date" name="match_date" required>
                </div>
                <div class="form-group">
                    <label for="team1">Équipe 1:</label>
                    <input type="text" id="team1" name="team1" required placeholder="Équipe 1">
                </div>
                <div class="form-group">
                    <label for="team2">Équipe 2:</label>
                    <input type="text" id="team2" name="team2" required placeholder="Équipe 2">
                </div>
                <div class="form-group">
                    <label for="score1">Score Équipe 1:</label>
                    <input type="number" id="score1" name="score1" required placeholder="Score Équipe 1">
                </div>
                <div class="form-group">
                    <label for="score2">Score Équipe 2:</label>
                    <input type="number" id="score2" name="score2" required placeholder="Score Équipe 2">
                </div>
                <button type="submit" name="record_score" class="btn-submit">Enregistrer le score</button>
            </form>
        <?php endif; ?>

    </div>
    <div class="footer">
        &copy; GOLD AND BLACK 2024
    </div>
</body>
</html>
