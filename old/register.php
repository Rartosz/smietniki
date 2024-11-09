<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $role = 'owner'; // Ustawiamy rolę właściciela

    $sql = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$password', '$email', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "Rejestracja zakończona sukcesem. Możesz teraz się zalogować.";
    } else {
        echo "Błąd: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja właściciela</title>
</head>
<body>
    <h1>Rejestracja właściciela</h1>
    <form method="POST" action="register.php">
        <label for="username">Nazwa użytkownika:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Hasło:</label>
        <input type="password" id="password" name="password" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <button type="submit">Zarejestruj się</button>
    </form>
    <a href="login.php">Zaloguj się</a>
</body>
</html>
