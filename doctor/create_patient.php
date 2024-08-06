<!DOCTYPE html>
<html lang="en">
    <body>
        <h2>Create Patient</h2>
        <a href="doctordashboard.php">Back</a>
        <?php
        session_start();
        // Check if error message is set in session
        if (isset($_SESSION['error_message'])) {
            echo '<p style="color: red;">' . htmlspecialchars($_SESSION['error_message']) . '</p>';
            // Clear the error message from session after displaying it
            unset($_SESSION['error_message']);
        }
        if (isset($_SESSION['success_message'])) {
            echo '<p style="color: green;">' . htmlspecialchars($_SESSION['success_message']) . '</p>';
            // Clear the success message from session after displaying it
            unset($_SESSION['success_message']);
        }
        ?>
        <form method="POST" action="process_create_patient.php">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required><br>

            <label for="DOB">Date of Birth:</label>
            <input type="date" name="DOB" id="DOB" required><br>

            <label for="phoene_number">Phone Number:</label>
            <input type="text" name="phone_number" id="phone_number" required><br>
            
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" ><br>

            <label for="address">Address:</label>
            <textarea name="address" id="address" ></textarea><br>

            <input type="submit" value="Save">
        </form>
    </body>
    </html>