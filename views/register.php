<!-- register.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Inscription - Club de Futsal</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Inclure les fichiers CSS ici -->
</head>
<body>
    <div class="register-container">
        <h2>Inscription</h2>
        <form action="process_register.php" method="POST">
            <label for="name">Nom:</label>
            <input type="text" id="name" name="name" required>
            <label for="surname">Prénom:</label>
            <input type="text" id="surname" name="surname" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
            <label for="phone">Numéro de téléphone:</label>
            <input type="tel" id="phone" name="phone" required>
            <label for="dob">Date de naissance:</label>
            <input type="date" id="dob" name="dob" required>
            <label for="address">Adresse:</label>
            <input type="text" id="address" name="address" required>
            <button type="submit">S'inscrire</button>
        </form>
    </div>
    <div class="footer">
        &copy; GOLD AND BLACK 2024
    </div>
</body>
</html>
