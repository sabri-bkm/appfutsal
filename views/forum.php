<?php
session_start();
include('../config/database.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Traiter l'envoi de message
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO forum_messages (user_id, message) VALUES (:user_id, :message)";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['user_id' => $user_id, 'message' => $message]);

    header("Location: forum.php");
    exit();
}

// Récupérer les messages du forum
$query = "SELECT forum_messages.*, users.name, users.surname FROM forum_messages 
          JOIN users ON forum_messages.user_id = users.id 
          ORDER BY forum_messages.created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$messages = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forum de Discussion - Club de Futsal</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>

        .container {
            padding: 20px;
        }
        .chat-container {
            border: 1px solid #ccc;
            padding: 10px;
            height: 400px;
            overflow-y: scroll;
            margin-bottom: 20px;
        }
        .message {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }
        .message:last-child {
            border-bottom: none;
        }
        .message p {
            margin: 0;
        }
        .message .author {
            font-weight: bold;
        }
        .message .timestamp {
            color: #999;
            font-size: 0.9em;
        }
        .message-form {
            display: flex;
            margin-bottom: 20px;
        }
        .message-form textarea {
            flex: 1;
            padding: 10px;
        }
        .message-form button {
            padding: 10px 20px;
            background-color: #000;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
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
        <h2>Forum de Discussion</h2>
        <div class="chat-container">
            <?php foreach ($messages as $message): ?>
                <div class="message">
                    <p class="author"><?php echo htmlspecialchars($message['name'] . ' ' . $message['surname']); ?></p>
                    <p><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                    <p class="timestamp"><?php echo htmlspecialchars($message['created_at']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

        <form class="message-form" action="forum.php" method="POST">
            <textarea name="message" required></textarea>
            <button type="submit">Envoyer</button>
        </form>
    </div>
    <div class="footer">
        &copy; GOLD AND BLACK 2024
    </div>
</body>
</html>
