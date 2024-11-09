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
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>



    <main class="dashboard">
        <h1 class="dashboard__h1">Witamy w systemie zarządzania śmietnikami</h1>
        <?php if ($role === 'owner'): ?>
            <div class="dashboard__container dashboard__container--center">
                <h2 class="dashboard__h2">Dodaj śmietnik:</h2>

                <form id="addTrashcanForm" class="dashboard__addTrashcanForm">

                    <input type="text" id="location" required class="dashboard__input" placeholder="Wpisz adres śmietnika...">
                    <!-- <label for="qrId">ID QR Kodu:</label> -->

                    <input type="text" id="qrId" value="1" hidden>

                    <button type="submit" class="dashboard__submit">Dodaj Śmietnik</button>
                </form>

            </div>
            <div class="dashboard__container">
                <h2 class="dashboard__h2">Lista Śmietników</h2>
                <ul id="trashcanList" class="dashboard__trashcans">
                    
                </ul>
            </div>




        <?php else: ?>
            <p>Nieznana rola użytkownika. Skontaktuj się z administratorem.</p>
        <?php endif; ?>
    </main>




    <script src="script.js"></script>
</body>
</html>
