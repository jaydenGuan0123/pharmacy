<?php
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../db.php';
    $medicine_name = $_POST['medicine_name'];
    $stock_increase = $_POST['stock_increase'];
    //check if the medicine exists
    $check_stmt = $conn->prepare("SELECT id FROM medicine WHERE name = ?");
    $check_stmt->bind_param("s", $medicine_name);
    $check_stmt->execute();
    $check_stmt->store_result();
    if ($check_stmt->num_rows == 0) {
        $_SESSION['error_message'] = "Medicine does not exist.";
        header("Location: update_medicine_stock.php");
        exit();
    }
    $check_stmt->close();
    // Update the stock
    $stmt = $conn->prepare("UPDATE medicine SET stock = stock + ? WHERE name = ?");
    $stmt->bind_param("is", $stock_increase, $medicine_name);
    $stmt->execute();
    if ($stmt->affected_rows == 0) {
        $_SESSION['error_message'] = "Failed to update stock.";
    } else {
        //show how many stock of medicine now
        $stmt = $conn->prepare("SELECT stock FROM medicine WHERE name = ?");
        $stmt->bind_param("s", $medicine_name);
        $stmt->execute();
        $stmt->bind_result($stock);
        $stmt->fetch();
        $_SESSION['success_message'] = "Stock updated successfully. Current stock: " . $stock;
    }
    $stmt->close();
    $conn->close();
    header('Location: update_medicine_stock.php');
    exit();
}