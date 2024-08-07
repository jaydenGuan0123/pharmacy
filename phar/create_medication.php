<?php
session_start(); 
if($_SERVER['REQUEST_METHOD'] == 'POST') {
   
include '../db.php';

$medication_name = $_POST['medication_name'];
$medication_price = $_POST['price'];
$medication_stock = $_POST['stock'];

// Check if the medication already exists
$check_stmt = $conn->prepare("SELECT id FROM medicine WHERE name = ?");
if (!$check_stmt) {
    die("Prepare failed: " . $conn->error);
}

$check_stmt->bind_param("s", $medication_name);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    // Medication already exists
    $_SESSION['error_message'] = "Medication already exists.";
    header("Location: update_medicine_stock.php");
    exit();
} else {
    echo "medication_name: ";
    var_dump($medication_name);
    // Medication does not exist, proceed with the insert
    $insert_stmt = $conn->prepare("INSERT INTO medicine (name, price, stock) VALUES (?, ?, ?)");
    if (!$insert_stmt) {
        die("Prepare failed: " . $conn->error);
    }
    
    $insert_stmt->bind_param("sdi", $medication_name, $medication_price, $medication_stock);
    $insert_stmt->execute();

    if ($insert_stmt->affected_rows == 0) {
        $_SESSION['error_message'] = "Failed to create medication.";
        header("Location: update_medicine_stock.php");
        exit();
    } else {
        $_SESSION['success_message'] = "Medication created successfully. Stock is: " . $medication_stock;
    }

    $insert_stmt->close();
}

$check_stmt->close();
$conn->close();

header('Location: update_medicine_stock.php');
exit();
}
?>