<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Śmietniki</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Śmietniki</h1>
        <form id="addTrashcanForm">
            <label for="location">Lokalizacja:</label>
            <input type="text" id="location" required>
            <!-- <label for="qrId">ID QR Kodu:</label> -->
            <input type="text" id="qrId" value="1" hidden>
            <button type="submit">Dodaj Śmietnik</button>
        </form>
        <h2>Lista Śmietników</h2>
        <ul id="trashcanList"></ul>
    </div>
    <script src="script.js"></script>
</body>
</html>
