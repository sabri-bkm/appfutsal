<?php
include('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];

    // Vérifiez si l'email existe déjà
    $checkEmailQuery = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($checkEmailQuery);
    $stmt->execute(['email' => $email]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        // Email existe déjà, afficher un message d'erreur
        echo "Cette adresse email est déjà utilisée.";
    } else {
        // Afficher le mot de passe haché pour débogage
        echo "Mot de passe haché : " . $password . "<br>";

        // Insérer le nouvel utilisateur
        $query = "INSERT INTO users (name, surname, email, password, phone, dob, address) VALUES (:name, :surname, :email, :password, :phone, :dob, :address)";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['name' => $name, 'surname' => $surname, 'email' => $email, 'password' => $password, 'phone' => $phone, 'dob' => $dob, 'address' => $address]);

        header("Location: ./login.php");
        exit();
    }
}
?>
