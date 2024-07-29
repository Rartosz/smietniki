<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Musisz być zalogowany, aby usunąć śmietnik.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $trashcan_id = $_POST['id'];
    $user_id = $_SESSION['user_id'];

    // Sprawdzenie, czy śmietnik należy do zalogowanego użytkownika
    $sql = "SELECT * FROM smietniki WHERE id='$trashcan_id' AND user_id='$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Usuń śmietnik
        $delete_sql = "DELETE FROM smietniki WHERE id='$trashcan_id'";
        if ($conn->query($delete_sql) === TRUE) {
            echo "Śmietnik został usunięty.";
        } else {
            echo "Błąd podczas usuwania: " . $conn->error;
        }
    } else {
        echo "Nie masz uprawnień do usunięcia tego śmietnika.";
    }

    $conn->close();
}
?>
