<?php
session_start();
include('../config/database.php');

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Connexion - Club de Futsal</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

    <style>
        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <?php if ($error_message): ?>
            <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Se connecter</button>
        </form>
        <a href="forgot_password.php">Mot de passe oublié?</a>
        <a href="register.php">Pas encore membre ? Devenez le !</a>

    </div>
    <div class="footer">
        &copy; GOLD AND BLACK 2024
    </div>
</body>
</html>
