<?php
session_start();
include('../db.php'); // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $medicine_names = $_POST['medicine_name'];
    $quantities = $_POST['quantity'];
    $dates = $_POST['date'];
    $notes = $_POST['notes'];
    $patient_id = $_SESSION['patient_id'];
    $doctor_id = $_SESSION['doctor_id'];
    $status = "pending";

    $error_messages = [];

    // Prepare statements for checking medicine and inserting prescription
    $check_medicine_stmt = $conn->prepare("SELECT id FROM medicine WHERE name = ?");
    $insert_prescription_stmt = $conn->prepare("INSERT INTO prescription (medicine_id, quantity, date, note, patient_id, doctor_id, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insert_prescription_stmt->bind_param("iissiis", $medicine_id, $quantity, $date, $note, $patient_id, $doctor_id, $status);

    foreach ($medicine_names as $index => $medicine_name) {
        $quantity = $quantities[$index];
        $date = $dates[$index];
        $note = $notes[$index];

        // Check if the medicine exists
        $check_medicine_stmt->bind_param("s", $medicine_name);
        $check_medicine_stmt->execute();
        $check_medicine_stmt->store_result();

        if ($check_medicine_stmt->num_rows > 0) {
            $check_medicine_stmt->bind_result($medicine_id);
            $check_medicine_stmt->fetch();
            
            // Insert the prescription
            $insert_prescription_stmt->execute();
        } else {
            $error_messages[] = "Medicine " . htmlspecialchars($medicine_name) . " not found in database.";
        }
    }

    $check_medicine_stmt->close();
    $insert_prescription_stmt->close();
    $conn->close();

    if (!empty($error_messages)) {
        $_SESSION['error_messages'] = $error_messages;
        header("Location: create_prescription2.php");
        exit();
    }

    $_SESSION['success_message'] = "Prescription created successfully.";
    header("Location: create_prescription2.php");
    exit();
}
?>