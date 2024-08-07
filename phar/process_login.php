<?php
session_start();
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the form
    $username_post = $_POST['username'];
    $password_post = $_POST['password'];

        
        $stmt = $conn->prepare("SELECT * FROM user WHERE role='pharmacist' AND username=? AND password=?");
        $stmt->bind_param("ss", $username_post, $password_post);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            //direct to the pharmacy page
            $_SESSION['username'] = $username_post;
            $_SESSION['pharmacist_id'] = $result->fetch_assoc()['id'];
            header("Location: pharmacistdashboard.php");
            
        } else {
            //maybe there is some errors here
            session_unset();
            $_SESSION['error_message'] = "Invalid username or password. Please try again.";
            // Redirect to login page
            header("Location: index.php");
            exit;
        }
        // Close connection
        $conn->close();
}
?>