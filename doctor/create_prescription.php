<?php
session_start();
include('../db.php'); // Include the database connection

$patient_id = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_name = $_POST['patient_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $stmt = $conn->prepare("SELECT id FROM patient WHERE name = ? AND DOB = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
    $stmt->bind_param("ss", $patient_name, $date_of_birth);
    $stmt->execute();
    $stmt->bind_result($patient_id);
    $stmt->fetch();
    $stmt->close();

    if ($patient_id) {
        $_SESSION['patient_id'] = $patient_id; // Save patient ID to session
        header("Location: create_prescription2.php"); // Redirect to the next step
        exit();
    } else {
        $error = "Patient not found.";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Prescription </title>
</head>
<body>
    <h2>Create Prescription</h2>
    <a href="doctordashboard.php">Back</a>
    <form action="create_prescription.php" method="POST">
        <label for="patient_name">Patient Name:</label>
        <input type="text" name="patient_name" id="patient_name" required>
        <br>
        <label for="date_of_birth">Date of Birth:</label>
        <input type="date" name="date_of_birth" id="date_of_birth" required>
        <br>
        <input type="submit" value="Submit">
    </form>

    <?php
    if (isset($error)) {
        echo "<p>" . htmlspecialchars($error) . "</p>";
    }
    ?>
</body>
</html>