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
                <button type="submit">Dodaj Śmietnik</button>
            </form>
            <h2>Lista Śmietników</h2>
            <ul id="trashcanList"></ul>

            <h2>Lista Pracowników</h2>
            <ul id="employeeList">
                <?php
                // Pobierz listę pracowników przypisanych do zalogowanego użytkownika (właściciela)
                $owner_id = $_SESSION['user_id'];
                $sql = "SELECT * FROM users WHERE owner_id = $owner_id";
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "<li>" . htmlspecialchars($row['username']) . " - " . htmlspecialchars($row['email']) . "</li>";
                }
                ?>
            </ul>

            <h2>Dodaj Nowego Pracownika</h2>
            <form id="addEmployeeForm" method="POST" action="register_employee.php">
                <label for="username">Nazwa użytkownika:</label>
                <input type="text" id="username" name="username" required><br>
                <label for="password">Hasło:</label>
                <input type="password" id="password" name="password" required><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>
                <button type="submit">Dodaj Pracownika</button>
            </form>
        <?php elseif ($role === 'employee'): ?>
            <h2>Panel Pracownika</h2>
            <p>Witaj, <?php echo htmlspecialchars($user['username']); ?>. Skontaktuj się z administratorem, aby uzyskać więcej informacji.</p>
        <?php else: ?>
            <p>Nieznana rola użytkownika. Skontaktuj się z administratorem.</p>
        <?php endif; ?>
    </div>
    <script src="script.js"></script>
</body>
</html>
