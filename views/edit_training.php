<?php
session_start();
include('../config/database.php');

// Vérifier si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Vérifier si l'ID de la session d'entraînement est fourni
if (!isset($_GET['id'])) {
    header("Location: manage_content.php");
    exit();
}

$id = $_GET['id'];

// Récupérer les informations de la session d'entraînement
$query = "SELECT * FROM trainings WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $id]);
$training = $stmt->fetch();

if (!$training) {
    header("Location: manage_content.php");
    exit();
}

// Mettre à jour les informations de la session d'entraînement
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];

    $query = "UPDATE trainings SET date = :date, time = :time, location = :location, capacity = :capacity WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['date' => $date, 'time' => $time, 'location' => $location, 'capacity' => $capacity, 'id' => $id]);

    header("Location: manage_content.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modifier une session d'entraînement - Club de Futsal</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h2>Modifier une session d'entraînement</h2>
    <form action="edit_training.php?id=<?php echo $training['id']; ?>" method="POST">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($training['date']); ?>" required>
        <label for="time">Heure:</label>
        <input type="time" id="time" name="time" value="<?php echo htmlspecialchars($training['time']); ?>" required>
        <label for="location">Lieu:</label>
        <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($training['location']); ?>" required>
        <label for="capacity">Capacité:</label>
        <input type="number" id="capacity" name="capacity" value="<?php echo htmlspecialchars($training['capacity']); ?>" required>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
