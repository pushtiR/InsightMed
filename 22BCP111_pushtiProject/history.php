<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch history records for the logged-in user
$sql = "SELECT * FROM patient_history WHERE user_id = :user_id ORDER BY record_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$history_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Health History</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="history-container">
        <h1>My Health History</h1>
        <?php if (count($history_records) > 0): ?>
            <?php foreach ($history_records as $record): ?>
                <div class="history-card">
                    <h3><?php echo htmlspecialchars($record['service_type']); ?></h3>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($record['record_date']); ?></p>
                    <p><strong>Doctor:</strong> <?php echo htmlspecialchars($record['doctor_name']); ?></p>
                    <p><strong>Notes:</strong> <?php echo htmlspecialchars($record['notes']); ?></p>
                    <p><strong>Prescription:</strong> <?php echo htmlspecialchars($record['prescription']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No health records found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
