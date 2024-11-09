<?php
$servername = "localhost";
$username = "lihzikjz_smietniki2"; // lub inny użytkownik
$password = "WindowS32#"; // hasło, jeśli jest ustawione
$dbname = "lihzikjz_smietniki2";

$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdź połączenie
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
