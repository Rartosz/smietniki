<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Musisz być zalogowany, aby zgłaszać przepełnienie lub wysprzątanie.");
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $status_update = '';

    if (isset($_POST['report_full'])) {
        $status_update = 'Przepełniony';
    } elseif (isset($_POST['resolve_full'])) {
        $status_update = 'Wysprzątany';
    }

    if ($status_update) {
        $sql = "UPDATE smietniki SET status='$status_update' WHERE id='$id' AND user_id='$user_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Status śmietnika zmieniony na: $status_update.";
        } else {
            echo "Błąd podczas aktualizacji: " . $conn->error;
        }
    } else {
        echo "Nieprawidłowa akcja.";
    }

    $conn->close();
}
?>
