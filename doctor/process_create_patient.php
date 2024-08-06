<?php
session_start();
include('../db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $DOB = $_POST['DOB'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $stmt = $conn->prepare("SELECT * FROM patient WHERE name = ? AND DOB = ?");
    $stmt->bind_param("ss", $name, $DOB);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $stmt->close();
        $conn->close();
        // Redirect to an error page or display an error message
        $_SESSION['error_message'] = "Patient already exists.";
        header("Location: create_patient.php");
        exit();
    }
    else{
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO patient (name, DOB, phone, email, address) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $DOB, $phone_number, $email, $address);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        // Redirect to the doctor dashboard
        $_SESSION['success_message'] = "Patient created successfully.";
        header("Location: create_patient.php");
        exit();
    }
}