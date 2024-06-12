<!-- scores.php -->
<?php
session_start();
include('../config/database.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Traitement de l'enregistrement des scores (pour les administrateurs)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['record_score'])) {
    $match_date = $_POST['match_date'];
    $team1 = $_POST['team1'];
    $team2 = $_POST['team2'];
    $score1 = $_POST['score1'];
    $score2 = $_POST['score2'];

    $query = "INSERT INTO scores (match_date, team1, team2, score1, score2) VALUES (:match_date, :team1, :team2, :score1, :score2)";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['match_date' => $match_date, 'team1' => $team1, 'team2' => $team2, 'score1' => $score1, 'score2' => $score2]);

    header("Location: scores.php");
    exit();
}

// Récupérer les scores des matchs
$query = "SELECT * FROM scores ORDER BY match_date DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$scores = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Scores - Club de Futsal</title>

    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        container {
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

.container {
    margin: 0 auto;
    padding: 20px;
    max-width: 800px;
}

.score-list {
    list-style-type: none;
    padding: 0;
}

.score-item {
    display: flex;
    justify-content: space-between;
    padding: 10px;
    margin: 10px 0;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 5px;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.5s ease-in-out;
}

.score-item.show {
    opacity: 1;
    transform: translateY(0);
}


.score-item span {
    margin: 0 5px;
}

.match-date {
    font-weight: bold;
    color: #333;
}

.team1, .team2 {
    font-weight: bold;
    color: #555;
}

.score1, .score2 {
    font-size: 18px;
    color: #000;
}

.separator {
    font-size: 18px;
    color: #333;
}

    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
        <h2>Scores des Matchs</h2>
        <ul class="score-list">
            <?php foreach ($scores as $score): ?>
                <li class="score-item">
                    <span class="match-date"><?php echo htmlspecialchars($score['match_date']); ?></span>
                    <span class="team1"><?php echo htmlspecialchars($score['team1']); ?></span>
                    <span class="score1"><?php echo htmlspecialchars($score['score1']); ?></span>
                    <span class="separator">:</span>
                    <span class="score2"><?php echo htmlspecialchars($score['score2']); ?></span>
                    <span class="team2"><?php echo htmlspecialchars($score['team2']); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="footer">
        &copy; GOLD AND BLACK 2024
    </div>
    <script>
$(document).ready(function() {
    $('.score-item').each(function(index) {
        $(this).delay(200 * index).queue(function(next) {
            $(this).addClass('show');
            next();
        });
    });
});
</script>

</body>
</html>
