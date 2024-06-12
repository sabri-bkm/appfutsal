<?php
session_start();
include('../config/database.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Récupérer les informations de l'utilisateur
$query = "SELECT * FROM users WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

// Récupérer les prochaines sessions d'entraînement
$query = "SELECT * FROM trainings WHERE date >= CURDATE() ORDER BY date ASC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$trainings = $stmt->fetchAll();

// Récupérer les scores récents
$query = "SELECT * FROM scores ORDER BY match_date DESC LIMIT 5";
$stmt = $pdo->prepare($query);
$stmt->execute();
$scores = $stmt->fetchAll();

// Récupérer les articles récents
$query = "SELECT * FROM actu ORDER BY created_at DESC LIMIT 5";
$stmt = $pdo->prepare($query);
$stmt->execute();
$articles = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tableau de Bord - Club de Futsal</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: #C3AB70;
        }
        .sidebar .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }
        .main-content {
            transition: margin-left .5s;
            padding: 20px;
        }
        .openbtn {
            font-size: 20px;
            cursor: pointer;
            background-color: #111;
            color: white;
            padding: 10px 15px;
            border: none;
        }
        .section-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .training, .scores, .articles {
            margin-bottom: 40px;
        }
        .training img, .scores img, .articles img {
            max-width: 100%;
            height: auto;
        }
        .training-item, .score-item, .article-item {
            margin-bottom: 10px;
        }
        .main-content {
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

.articles {
    margin-bottom: 40px;
}

.article-item {
    list-style: none;
    padding: 0;
}

.article {
    background-color: #f9f9f9;
    margin-bottom: 20px;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}

.article h3 {
    margin-top: 0;
    color: #333;
}

.article p {
    color: #555;
}

.article img {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
    margin-top: 10px;
    margin-right: 5px;
    margin-left: 76%;
}
    </style>
    
</head>
<body>
    <header>
      <img src="../img/fondgabb.png" alt="">   
             <a href="../logout.php" class="logout-btn">Déconnexion</a>

    </header>
    
    <div class="navbar">
        <a href="dashboard.php">DASHBOARD</a>
        <a href="scores.php">SCORES</a>
        <a href="training.php">ENTRAINEMENTS</a>
        <a href="forum.php">DISCUSSIONS</a>
    </div>

    <?php if ($_SESSION['user_role'] == 'admin'): ?>
        <button class="openbtn" onclick="openNav()">☰ Admin Menu</button>
        <div id="mySidebar" class="sidebar">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
            <a href="add_score.php">Ajouter un Score</a>
            <a href="add_training.php">Ajouter un Entraînement</a>
            <a href="add_article.php">Ajouter un Article</a>
            <a href="manage_users.php">Gestions</a>
        </div>
    <?php endif; ?>

    <div id="main" class="main-content">
        <div class="articles">
            <h2 class="section-title">Actualité</h2>
            <div class="article-item">
                <?php foreach ($articles as $article): ?>
                    <div class="article">
                        <h3><?php echo htmlspecialchars($article['title']); ?></h3>
                        <p><?php echo htmlspecialchars($article['content']); ?></p>
                        <p>Posté par <?php echo htmlspecialchars($article['author']); ?> le <?php echo htmlspecialchars($article['created_at']); ?></p>
                        <?php if ($article['image_path']): ?>
                            <img src="<?php echo htmlspecialchars($article['image_path']); ?>" alt="Image de l'article">
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="footer">
        &copy; GOLD AND BLACK 2024
    </div>

    <script>
        function openNav() {
            document.getElementById("mySidebar").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("mySidebar").style.width = "0";
            document.getElementById("main").style.marginLeft= "0";
        }
    </script>
</body>
</html>
