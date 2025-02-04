<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

// Include database connection
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $serviceType = trim($_POST['service_type']);
    $doctorName = trim($_POST['doctor_name']);
    $notes = trim($_POST['notes']);
    $prescription = trim($_POST['prescription']);
    $recordDate = date('Y-m-d');  // Default to the current date

    // Server-side validation
    if (empty($serviceType) || empty($doctorName) || empty($notes) || empty($prescription)) {
        $errorMessage = "All fields are required.";
    } else {
        // Insert the new record into the database
        $sql = "INSERT INTO patient_history (user_id, record_date, service_type, doctor_name, notes, prescription) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssss", $_SESSION['user_id'], $recordDate, $serviceType, $doctorName, $notes, $prescription);
        
        if ($stmt->execute()) {
            header("Location: medical_records.php"); // Redirect to medical records page after submission
            exit;
        } else {
            $errorMessage = "Error adding record. Please try again.";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medical Record - InsightMed</title>
    <link rel="stylesheet" href="medical_records.css">
</head>
<body style="background-color: #f2f4f3; color: #276d5a;">
    <div class="container">
        <h2>Add a New Medical Record</h2>

        <?php if (!empty($errorMessage)): ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <form method="POST" action="add_medical_record.php">
            <label for="service_type">Service Type:</label>
            <input type="text" id="service_type" name="service_type" required>
            <label for="doctor_name">Doctor's Name:</label>
            <input type="text" id="doctor_name" name="doctor_name" required>
            <label for="notes">Notes:</label>
            <textarea id="notes" name="notes" required></textarea>
            <label for="prescription">Prescription:</label>
            <textarea id="prescription" name="prescription" required></textarea>
            <button type="submit" class="button">Submit Record</button>
        </form>

        <a href="medical_records.php" class="button">Back to Records</a>
    </div>
</body>
</html>
