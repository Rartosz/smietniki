<?php
include 'db.php';

$sql = "SELECT * FROM smietniki";
$result = $conn->query($sql);

$trashcans = [];
while ($row = $result->fetch_assoc()) {
    $trashcans[] = $row;
}

echo json_encode($trashcans);

$conn->close();
?>
