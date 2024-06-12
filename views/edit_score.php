<?php
session_start();
include('../config/database.php');

// Vérifier si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Récupérer le score à modifier
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM scores WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);
    $score = $stmt->fetch();

    if (!$score) {
        echo "Score introuvable.";
        exit();
    }
}

// Traiter la modification du score
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $team1 = $_POST['team1'];
    $team2 = $_POST['team2'];
    $score1 = $_POST['score1'];
    $score2 = $_POST['score2'];
    $match_date = $_POST['match_date'];

    $query = "UPDATE scores SET team1 = :team1, team2 = :team2, score1 = :score1, score2 = :score2, match_date = :match_date WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['team1' => $team1, 'team2' => $team2, 'score1' => $score1, 'score2' => $score2, 'match_date' => $match_date, 'id' => $id]);

    header("Location: manage_content.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modifier le Score - Club de Futsal</title>
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
        <h2>Modifier le Score</h2>
        <form action="edit_score.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($score['id']); ?>">
            <label for="team1">Équipe 1</label>
            <input type="text" id="team1" name="team1" value="<?php echo htmlspecialchars($score['team1']); ?>" required>
            <label for="team2">Équipe 2</label>
            <input type="text" id="team2" name="team2" value="<?php echo htmlspecialchars($score['team2']); ?>" required>
            <label for="score1">Score 1</label>
            <input type="number" id="score1" name="score1" value="<?php echo htmlspecialchars($score['score1']); ?>" required>
            <label for="score2">Score 2</label>
            <input type="number" id="score2" name="score2" value="<?php echo htmlspecialchars($score['score2']); ?>" required>
            <label for="match_date">Date du Match</label>
            <input type="date" id="match_date" name="match_date" value="<?php echo htmlspecialchars($score['match_date']); ?>" required>
            <button type="submit">Modifier</button>
        </form>
    </div>
    <div class="footer">
        &copy; GOLD AND BLACK 2024
    </div>
</body>
</html>
