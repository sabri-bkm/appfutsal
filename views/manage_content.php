<?php
session_start();
include('../config/database.php');

// Vérifier si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Récupérer les articles
$query = "SELECT * FROM actu ORDER BY created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$articles = $stmt->fetchAll();

// Récupérer les scores
$query = "SELECT * FROM scores ORDER BY match_date DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$scores = $stmt->fetchAll();

// Récupérer les sessions d'entraînement
$query = "SELECT * FROM trainings ORDER BY date ASC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$trainings = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Gérer le Contenu - Club de Futsal</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>

        .container {
            padding: 20px;
        }
        .section-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions a, .actions form button {
            padding: 5px 10px;
            text-decoration: none;
            background-color: #000;
            color: white;
            border: none;
            cursor: pointer;
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

    <div class="container">
        <h2 class="section-title">Gérer les Articles</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Contenu</th>
                    <th>Auteur</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($article['id']); ?></td>
                        <td><?php echo htmlspecialchars($article['title']); ?></td>
                        <td><?php echo htmlspecialchars($article['content']); ?></td>
                        <td><?php echo htmlspecialchars($article['author']); ?></td>
                        <td><?php echo htmlspecialchars($article['created_at']); ?></td>
                        <td class="actions">
                            <a href="edit_article.php?id=<?php echo $article['id']; ?>">Modifier</a>
                            <form action="delete_article.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article?');">
                                <input type="hidden" name="id" value="<?php echo $article['id']; ?>">
                                <button type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="section-title">Gérer les Scores</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Équipe 1</th>
                    <th>Équipe 2</th>
                    <th>Score 1</th>
                    <th>Score 2</th>
                    <th>Date du Match</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($scores as $score): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($score['id']); ?></td>
                        <td><?php echo htmlspecialchars($score['team1']); ?></td>
                        <td><?php echo htmlspecialchars($score['team2']); ?></td>
                        <td><?php echo htmlspecialchars($score['score1']); ?></td>
                        <td><?php echo htmlspecialchars($score['score2']); ?></td>
                        <td><?php echo htmlspecialchars($score['match_date']); ?></td>
                        <td class="actions">
                            <a href="edit_score.php?id=<?php echo $score['id']; ?>">Modifier</a>
                            <form action="delete_score.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce score?');">
                                <input type="hidden" name="id" value="<?php echo $score['id']; ?>">
                                <button type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <h2 class="section-title">Gestion des Entraînements</h2>
        <ul class="training-list">
            <?php foreach ($trainings as $training): ?>
                <li class="training-item">
                    <span class="training-info"><?php echo htmlspecialchars($training['date']) . ' à ' . htmlspecialchars($training['time']) . ' - ' . htmlspecialchars($training['location']); ?></span>
                    <a href="edit_training.php?id=<?php echo $training['id']; ?>" class="btn-edit">Modifier</a>
                    <form action="delete_training.php" method="POST" class="btn-delete-form" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet entraînement?');">
                        <input type="hidden" name="id" value="<?php echo $training['id']; ?>">
                        <button type="submit" class="btn-delete">Supprimer</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="footer">
        &copy; GOLD AND BLACK 2024
    </div>
</body>
</html>
