<?php
session_start();
include('../config/database.php');

// Vérifier si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Récupérer les utilisateurs
$query = "SELECT * FROM users ORDER BY created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Gérer les Utilisateurs - Club de Futsal</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        .container {
            padding: 20px;
        }
        .table-container {
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
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
        <h2>Gérer les Utilisateurs</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Date de Naissance</th>
                        <th>Adresse</th>
                        <th>Rôle</th>
                        <th>Date d'Inscription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['surname']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['phone']); ?></td>
                            <td><?php echo htmlspecialchars($user['dob']); ?></td>
                            <td><?php echo htmlspecialchars($user['address']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                            <td>
                                <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <a href="manage_content.php">Gérer les articles,les scores et entraînements</a>
    <div class="footer">
        &copy; GOLD AND BLACK 2024
    </div>
</body>
</html>
