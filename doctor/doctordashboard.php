<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JDpharmacy Dashboard</title>
    <style>
        .dashboard {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .dashboard h2 {
            text-align: center;
        }
        .dashboard a {
            display: block;
            padding: 10px;
            margin: 10px 0;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 3px;
        }
        .dashboard a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<?php
session_start();
        if(isset($_SESSION['username'])){
            $username = $_SESSION['username'];
        } else {
            $username = "Unknown";
        }
?>
    <div class="title">
        <h3>Welcome, <?php echo $username; ?></h3>
    </div>
    <div class="dashboard">
        <h2>Pharmacy Dashboard</h2>
        <a href="create_patient.php">Create new patient</a>
        <a href="create_prescription.php">Create prescription</a>
        <a href="send_message.php">Send Message</a>
    </div>
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>