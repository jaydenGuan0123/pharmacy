<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include '../db.php';

    $prescription_id = $_POST['prescription_id'];
    $status = $_POST['status'];
    $accepted_by = $_SESSION['pharmacist_id'];

    $stmt = $conn->prepare("UPDATE prescription SET status = ?, accepted_by = ? WHERE id = ?");
    $stmt->bind_param("sis", $status, $accepted_by, $prescription_id);

    // Execute the update query
    if ($stmt->execute()) {
        if($status === 'accepted'){
            // Decrease the stock number
            $stmt = $conn->prepare("SELECT medicine_id, quantity FROM prescription WHERE id = ?");
            $stmt->bind_param("i", $prescription_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $medicine_id = $row['medicine_id'];
            $quantity = $row['quantity'];
            $stmt = $conn->prepare("UPDATE medicine SET stock = stock - ?  WHERE id = ?");
            $stmt->bind_param("ii", $quantity, $medicine_id);
            $stmt->execute();
        }
        // Check if status is 'Ready' and send an email
        if ($status === 'ready') {
            // Get the patient's email address
            $stmt = $conn->prepare("SELECT p.email FROM prescription pr
                                          INNER JOIN patient p ON pr.patient_id = p.id
                                          WHERE pr.id = ?");
            $stmt->bind_param("s", $prescription_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            if ($row) {
                $email = $row['email'];
                $subject = "Prescription Ready for Pickup";
                $message = "Your prescription is now ready for pickup. Please visit the pharmacy to collect your medication.";

                // Use a more robust email library if possible
                mail($email, $subject, $message);
            } else {
                echo "Error: Patient email not found.";
            }
        }
        echo "Prescription marked as $status.";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>