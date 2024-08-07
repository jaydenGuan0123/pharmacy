<!DOCTYPE html>
<html>
<head>
    <title>JDpharmacy</title>
    <style>
        /* Basic styling for better visibility */
        .header, .status-filter, .prescription-list {
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Prescription List</h1>
    </div>
    <div class="go-back">
        <a href="pharmacistdashboard.php">Go back</a>
    </div>
    <div class="status-filter">
        <form method="GET" action="">
            <input type="submit" name="status" value="pending">
            <input type="submit" name="status" value="accepted">
        </form>
    </div>
    <div class="prescription-list">
        <table>
            <tr>
                <th>Prescription ID</th>
                <th>Patient Name</th>
                <th>Doctor ID</th>
                <th>Date</th>
                <th>Medication Name</th>
                <th>Quantity</th>
                <th>DOB</th>
                <th>Note</th>
                <th>Actions</th>
            </tr>
            <?php
            session_start();
            include '../db.php';
            if ($conn === null) {
                die("Database connection not established.");
            }

            // Get the status from the query parameter, default to 'Accepted'
            $status = isset($_GET['status']) ? $_GET['status'] : 'pending';
            
            // Fetch data from the database based on the selected status
            // $query = "SELECT p.name AS patient_name, p.DOB AS DOB, pr.*,m.name AS medication_name
            //           FROM prescription pr
            //           INNER JOIN patient p ON pr.patient_id = p.id 
            //           Inner JOIN medicine m ON pr.medicine_id = m.id
            //           WHERE pr.status='$status' ORDER BY pr.id";
            $stmt = $conn->prepare("SELECT p.name AS patient_name, p.DOB AS DOB, pr.*,m.name AS medication_name
                      FROM prescription pr
                      INNER JOIN patient p ON pr.patient_id = p.id 
                      Inner JOIN medicine m ON pr.medicine_id = m.id
                      WHERE pr.status=? ORDER BY pr.id");
            $stmt->bind_param("s", $status);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            while ($row = $result->fetch_assoc()) {
               
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['patient_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['doctor_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
                echo "<td>" . htmlspecialchars($row['medication_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                echo "<td>" . htmlspecialchars($row['DOB']) . "</td>";
                echo "<td>" . htmlspecialchars($row['note']) . "</td>";
            
                // Display action buttonp
                echo "<td>";
                if ($status === 'accepted') {
                    echo "<button type='button' onclick='markAsStatus(\"" . htmlspecialchars($row['id']) . "\", \"ready\")'>Mark as Ready</button>";
                } elseif ($status === 'pending') {
                    echo "<button type='button' onclick='markAsStatus(\"" . htmlspecialchars($row['id']) . "\", \"accepted\")'>Mark as Accepted</button>";
                }
                echo "</td>";
            
                // Display medication details
        
                echo "</tr>";
            }
            
            // Close the database connection
            $conn->close();
            ?>
            </table>
    </div>
    <script>
    function markAsStatus(prescriptionId, status) {
        fetch('change_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'prescription_id=' + encodeURIComponent(prescriptionId) + '&status=' + encodeURIComponent(status)
        })
        .then(response => response.text())
        .then(result => {
            alert(result);
            console.log(result);
            location.reload(); // Refresh the page to reflect the updated status
        })
        .catch(error => {
            console.error('Error:', error);
        });
        
    }
    </script>
</body>
</html>
            
    