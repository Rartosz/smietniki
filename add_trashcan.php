<?php
include 'db.php';
include 'phpqrcode/qrlib.php'; // Ścieżka do biblioteki QR Code

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $location = $_POST['location'];
    $qr_id = $_POST['qr_id'];

    // Generowanie unikalnego URL do zgłoszenia
    $qr_url = "http://localhost/report.php?qr_id=" . urlencode($qr_id);
    
    // Generowanie QR kodu
    $qr_path = 'qrcodes/' . $qr_id . '.png';
    if (!file_exists('qrcodes')) {
        mkdir('qrcodes', 0777, true); // Tworzenie katalogu, jeśli nie istnieje
    }
    QRcode::png($qr_url, $qr_path);

    $sql = "INSERT INTO smietniki (location, qr_id) VALUES ('$location', '$qr_id')";
    if ($conn->query($sql) === TRUE) {
        echo "Nowy rekord został pomyślnie dodany.";
    } else {
        echo "Błąd: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
