<?php
include 'db.php';
include 'phpqrcode/qrlib.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Musisz być zalogowany, aby dodać śmietnik.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $location = $_POST['location'];
    $qr_id = $_POST['qr_id'];
    $user_id = $_SESSION['user_id'];

    $qr_url = "http://localhost/report.php?qr_id=" . urlencode($qr_id);
    $qr_path = 'qrcodes/' . $qr_id . '.png';
    if (!file_exists('qrcodes')) {
        mkdir('qrcodes', 0777, true);
    }
    QRcode::png($qr_url, $qr_path);

    $sql = "INSERT INTO smietniki (location, qr_id, user_id) VALUES ('$location', '$qr_id', '$user_id')";
    if ($conn->query($sql) === TRUE) {
        echo "Nowy rekord został pomyślnie dodany.";
    } else {
        echo "Błąd: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
