<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
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
    <title>Medical Records - InsightMed</title>
    <link rel="stylesheet" href="medical_records.css">
</head>
<body style="background-color: #f2f4f3; color: #276d5a;">
    <div class="container">
        <div class="welcome-message">
            <h2>Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
        </div>
        
        <div class="button-container">
            <a href="view_medical_records.php" class="button">View Medical Records</a>
            <a href="add_medical_record.php" class="button">Add New Medical Record</a><br>
            <a href="index.php" class="button">Go to Dashboard</a>
        </div>

        <?php if (empty($medicalRecords)): ?>
            <p class="no-records-message">No records found. Please add a new record.</p>
        <?php endif; ?>
    </div>
</body>
</html>
