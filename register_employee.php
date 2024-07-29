<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $owner_id = $_SESSION['user_id']; // ID właściciela
    $role = 'employee'; // Ustawiamy rolę pracownika

    $sql = "INSERT INTO users (username, password, email, owner_id, role) VALUES ('$username', '$password', '$email', '$owner_id', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "Rejestracja pracownika zakończona sukcesem.";
    } else {
        echo "Błąd: " . $conn->error;
    }

    $conn->close();
}
?>


