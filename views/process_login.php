<!-- process_login.php -->
<?php
session_start();
include('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Email ou mot de passe incorrect.";
    }
}
?>
