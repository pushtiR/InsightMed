<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

// Include the database connection
include 'db.php';

// Fetch user's medical records from the `patient_history` table
$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM patient_history WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all records into an array
$medicalRecords = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Medical Records - InsightMed</title>
    <link rel="stylesheet" href="medical_records.css">
</head>
<body style="background-color: #f2f4f3; color: #276d5a;">
    <div class="container">
        <h2>Your Medical Records</h2>

        <?php if (!empty($medicalRecords)): ?>
            <table class="records-table">
                <thead>
                    <tr>
                        <th>Record ID</th>
                        <th>Date</th>
                        <th>Service Type</th>
                        <th>Doctor Name</th>
                        <th>Notes</th>
                        <th>Prescription</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($medicalRecords as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['record_id']); ?></td>
                            <td><?php echo htmlspecialchars($record['record_date']); ?></td>
                            <td><?php echo htmlspecialchars($record['service_type']); ?></td>
                            <td><?php echo htmlspecialchars($record['doctor_name']); ?></td>
                            <td><?php echo htmlspecialchars($record['notes']); ?></td>
                            <td><?php echo htmlspecialchars($record['prescription']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No medical records found.</p>
        <?php endif; ?>

        <a href="medical_records.php" class="button">Back to Main</a>
    </div>
</body>
</html>
