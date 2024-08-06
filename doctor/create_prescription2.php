<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Prescription</title>
    <style>
        .medicine-group {
            margin-bottom: 10px;
        }
        .remove-button {
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Create Prescription</h2>
    <a href="create_prescription.php">Back</a>
    <?php
    session_start();
    if (isset($_SESSION['error_messages'])) {
        echo '<ul style="color: red;">';
        foreach ($_SESSION['error_messages'] as $error) {
            echo "<li>$error</li>";
        }
        echo '</ul>';
        unset($_SESSION['error_messages']);
    }
    if (isset($_SESSION['success_message'])) {
        echo '<p style="color: green;">' . $_SESSION['success_message'] . '</p>';
        unset($_SESSION['success_message']);
    }
    ?>
    <form action="process_create_prescription.php" method="POST" id="prescriptionForm">
        <div id="medicineContainer">
            <div class="medicine-group">
                <label for="medicine_name">Medicine Name:</label>
                <input type="text" name="medicine_name[]" required><br>

                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity[]" required><br>

                <label for="date">Date:</label>
                <input type="date" name="date[]" required><br>

                <label for="notes">Notes:</label>
                <textarea name="notes[]"></textarea><br>
            </div>
        </div>
        <button type="button" onclick="addMedicine()">+ Add Medicine</button>
        <input type="submit" value="Submit">
    </form>

    <script>
        function addMedicine() {
            var container = document.getElementById("medicineContainer");
            var newMedicineGroup = document.createElement("div");
            newMedicineGroup.className = "medicine-group";
            newMedicineGroup.innerHTML = `
                <label for="medicine_name">Medicine Name:</label>
                <input type="text" name="medicine_name[]" required><br>

                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity[]" required><br>

                <label for="date">Date:</label>
                <input type="date" name="date[]" required><br>

                <label for="notes">Notes:</label>
                <textarea name="notes[]"></textarea><br>

                <button type="button" class="remove-button" onclick="removeMedicine(this)">Remove</button>
            `;
            container.appendChild(newMedicineGroup);
        }

        function removeMedicine(button) {
            var container = document.getElementById("medicineContainer");
            container.removeChild(button.parentElement);
        }
    </script>
</body>
</html>