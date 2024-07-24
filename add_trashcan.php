<?php
include 'db.php';
include 'phpqrcode/qrlib.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Musisz być zalogowany, aby dodać śmietnik.");
}

function generateUniqueQrId($conn) {
    $isUnique = false;
    $qr_id = '';

    while (!$isUnique) {
        $qr_id = bin2hex(random_bytes(8)); // Generowanie losowego ID, np. 16 znaków
        $sql = "SELECT COUNT(*) as cnt FROM smietniki WHERE qr_id='$qr_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if ($row['cnt'] == 0) {
            $isUnique = true;
        }
    }

    return $qr_id;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $location = $_POST['location'];
    $user_id = $_SESSION['user_id'];

    // Generowanie unikalnego QR ID
    $qr_id = generateUniqueQrId($conn);
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
