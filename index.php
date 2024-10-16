<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Pobierz informacje o zalogowanym użytkowniku
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Błąd: Nie znaleziono użytkownika.";
    exit();
}

// Sprawdź rolę użytkownika
$role = $user['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Użytkownika</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Witamy w systemie zarządzania śmietnikami</h1>
        <?php if ($role === 'owner'): ?>
            <h2>Śmietniki</h2>
            <form id="addTrashcanForm">
                <label for="location">Lokalizacja:</label>
                <input type="text" id="location" required>
                <!-- <label for="qrId">ID QR Kodu:</label> -->
                <input type="text" id="qrId" value="1" hidden>
                <button type="submit">Dodaj Śmietnik</button>
            </form>
            <h2>Lista Śmietników</h2>
            <ul id="trashcanList"></ul>

        <?php else: ?>
            <p>Nieznana rola użytkownika. Skontaktuj się z administratorem.</p>
        <?php endif; ?>
    </div>
    <script src="script.js"></script>
</body>
</html>
