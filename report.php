<?php
include 'db.php';

if (isset($_GET['qr_id'])) {
    $qr_id = $_GET['qr_id'];

    $sql = "SELECT * FROM smietniki WHERE qr_id='$qr_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $trashcan = $result->fetch_assoc();
    } else {
        echo "Nie znaleziono śmietnika.";
        exit();
    }
} else {
    echo "Brak ID QR Kodu.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['report_full'])) {
        $sql = "UPDATE smietniki SET status='Przepełniony' WHERE qr_id='$qr_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Śmietnik zgłoszony jako przepełniony.";
        } else {
            echo "Błąd podczas zgłaszania: " . $conn->error;
        }
    } elseif (isset($_POST['resolve_full'])) {
        $sql = "UPDATE smietniki SET status='Wysprzątany' WHERE qr_id='$qr_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Śmietnik zgłoszony jako wysprzątany.";
        } else {
            echo "Błąd podczas rozwiązywania zgłoszenia: " . $conn->error;
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zgłoszenie przepełnionego śmietnika</title>
</head>
<body>
    <h1>Zgłoś przepełniony śmietnik</h1>
    <p>Lokalizacja: <?php echo htmlspecialchars($trashcan['location']); ?></p>

    <?php if ($trashcan['status'] == 'Przepełniony'): ?>
        <form method="POST">
            <button name="resolve_full" type="submit">Zgłoś, że śmietnik został wysprzątany</button>
        </form>
    <?php else: ?>
        <form method="POST">
            <button name="report_full" type="submit">Zgłoś przepełniony śmietnik</button>
        </form>
    <?php endif; ?>
</body>
</html>
