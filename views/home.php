<!-- login.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Connexion - Club de Futsal</title>
    <!-- Inclure les fichiers CSS ici -->
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <form action="process_login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Se connecter</button>
        </form>
        <a href="forgot_password.php">Mot de passe oublié?</a>
    </div>
</body>
</html>
