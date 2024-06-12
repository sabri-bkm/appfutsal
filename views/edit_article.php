<?php
session_start();
include('../config/database.php');

// Vérifier si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Récupérer l'article à modifier
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM actu WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);
    $article = $stmt->fetch();

    if (!$article) {
        echo "Article introuvable.";
        exit();
    }
}

// Traiter la modification de l'article
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_POST['author'];

    $query = "UPDATE actu SET title = :title, content = :content, author = :author WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['title' => $title, 'content' => $content, 'author' => $author, 'id' => $id]);

    header("Location: manage_content.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modifier l'Article - Club de Futsal</title>
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
        <h2>Modifier l'Article</h2>
        <form action="edit_article.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($article['id']); ?>">
            <label for="title">Titre</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($article['title']); ?>" required>
            <label for="content">Contenu</label>
            <textarea id="content" name="content" required><?php echo htmlspecialchars($article['content']); ?></textarea>
            <label for="author">Auteur</label>
            <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($article['author']); ?>" required>
            <button type="submit">Modifier</button>
        </form>
    </div>
    <div class="footer">
        &copy; GOLD AND BLACK 2024
    </div>
</body>
</html>
