<?php
include 'db.php';
session_start();

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

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$user = null;
$isEmployee = false;

if ($user_id) {
    $sql = "SELECT * FROM users WHERE id='$user_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $isEmployee = !is_null($user['owner_id']);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pracownicy mogą tylko zgłaszać śmietnik jako wysprzątany
    if ($isEmployee && isset($_POST['resolve_full']) && $trashcan['status'] == 'Przepełniony') {
        $sql = "UPDATE smietniki SET status='Wysprzątany' WHERE qr_id='$qr_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Śmietnik zgłoszony jako wysprzątany.";
        } else {
            echo "Błąd podczas zgłaszania: " . $conn->error;
        }
    } elseif (!$isEmployee && isset($_POST['report_full']) && $trashcan['status'] != 'Przepełniony') {
        $sql = "UPDATE smietniki SET status='Przepełniony' WHERE qr_id='$qr_id'";
        if ($conn->query($sql) === TRUE) {
            echo "Śmietnik zgłoszony jako przepełniony.";
        } else {
            echo "Błąd podczas zgłaszania: " . $conn->error;
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
    <h1>Zgłoś stan śmietnika</h1>
    <p>Lokalizacja: <?php echo htmlspecialchars($trashcan['location']); ?></p>

    <?php if ($isEmployee): ?>
        <?php if ($trashcan['status'] == 'Przepełniony'): ?>
            <form method="POST">
                <button name="resolve_full" type="submit">Zgłoś, że śmietnik został wysprzątany</button>
            </form>
        <?php else: ?>
            <p>Śmietnik nie jest zgłoszony jako przepełniony.</p>
        <?php endif; ?>
    <?php else: ?>
        <?php if ($trashcan['status'] == 'Przepełniony'): ?>
            <p>Śmietnik jest już zgłoszony jako przepełniony. Służby zostały powiadomione.</p>
        <?php else: ?>
            <form method="POST">
                <button name="report_full" type="submit">Zgłoś przepełniony śmietnik</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
