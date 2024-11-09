<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]); // Zwracaj pustą tablicę, jeśli użytkownik nie jest zalogowany
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM smietniki WHERE user_id='$user_id'";
$result = $conn->query($sql);

$trashcans = [];
while ($row = $result->fetch_assoc()) {
    $trashcans[] = $row;
}

echo json_encode($trashcans);

$conn->close();
?>
