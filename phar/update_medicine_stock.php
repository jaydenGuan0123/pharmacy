<!DOCTYPE>
<html>
    <body>
        <div>
            <h2>Create a new medication</h2>
            <?php
            session_start();
            if(isset($_SESSION['error_message'])){
                echo '<p style="color: red;">' . htmlspecialchars($_SESSION['error_message']) . '</p>';
                unset($_SESSION['error_message']);
            }
            if (isset($_SESSION['success_message'])) {
                echo '<p style="color: green;">' . htmlspecialchars($_SESSION['success_message']) . '</p>';
                // Clear the success message from session after displaying it
                unset($_SESSION['success_message']);
            }
            ?>
            <a href="pharmacistdashboard.php">Back</a>
            <form action="create_medication.php" method="POST">
                <label for="medication_name">Medicine Name:</label>
                <input type="text" id="medication_name" name="medication_name" required><br><br>
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" min="0" required><br><br>
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" required><br><br>
                <input type="submit" value="Create Medication">
            </form>
            <br>
            <h2>Update medication stock</h2>
            <form action="update_stock.php" method="POST">
                <label for="medicine_name">Medicine Name:</label>
                <input type="text" id="medicine_name" name="medicine_name" required><br><br>
                <label for="stock_increase">New Stock:</label>
                <input type="number" id="stock_increase" name="stock_increase" required><br><br>
                <input type="submit" value="Update Stock">
            </form>
        </div>
    </body>
</html>