<?php
$servername = "localhost";
$username = "root"; // lub inny użytkownik
$password = ""; // hasło, jeśli jest ustawione
$dbname = "smietniki_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Sprawdź połączenie
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
