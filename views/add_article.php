<?php
session_start();
include('../config/database.php');

// Vérifier si l'utilisateur est connecté et s'il est un administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_SESSION['user_id'];
    
    // Gestion de l'upload de l'image
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_path = '../uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }

    $query = "INSERT INTO actu (title, content, author, image_path, created_at) VALUES (:title, :content, :author, :image_path, NOW())";
    $stmt = $pdo->prepare($query);
    if ($stmt->execute(['title' => $title, 'content' => $content, 'author' => $author, 'image_path' => $image_path])) {
        $message = "Article ajouté avec succès.";
    } else {
        $message = "Une erreur est survenue lors de l'ajout de l'article.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un Article - Club de Futsal</title>
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

.message {
    color: green;
    margin-bottom: 20px;
}

.form-article {
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

.form-group input,
.form-group textarea {
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
        <h2>Ajouter un Article</h2>
        <?php if (isset($message) && $message): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form action="add_article.php" method="POST" enctype="multipart/form-data" class="form-article">
            <div class="form-group">
                <label for="title">Titre:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Contenu:</label>
                <textarea id="content" name="content" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn-submit">Ajouter</button>
        </form>
    </div>

    <div class="footer">
        &copy; GOLD AND BLACK 2024
    </div>
</body>
</html>
