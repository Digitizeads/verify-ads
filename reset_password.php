<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "verifyads";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ''; // Store any success/error messages

// Check if the token is provided in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token is valid and not expired
    $sql = "SELECT * FROM user WHERE password_reset_token = ? AND token_expiry > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Handle password reset form submission
        if (isset($_POST['reset_password'])) {
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            if ($new_password === $confirm_password) {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

                // Update the user's password in the database
                $updatePasswordSql = "UPDATE user SET password = ?, password_reset_token = NULL, token_expiry = NULL WHERE emailid = ?";
                $updateStmt = $conn->prepare($updatePasswordSql);
                $updateStmt->bind_param("ss", $hashed_password, $user['emailid']);

                if ($updateStmt->execute()) {
                    $message = "Password reset successful! You can now log in.";
                } else {
                    $message = "Error updating password: " . $updateStmt->error;
                }

                $updateStmt->close();
            } else {
                $message = "Passwords do not match. Please try again.";
            }
        }
    } else {
        $message = "Invalid or expired token.";
    }

    $stmt->close();
} else {
    $message = "No token provided. Please check your email for the reset link.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password |  Verify Ads</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 400px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Reset Your Password</h2>

        <?php if (!empty($message)) : ?>
            <div class="alert alert-info" id="message" role="alert">
                <?php echo $message; ?>
            </div>
            <script>
                // Show the alert for 5 seconds then redirect
                setTimeout(function() {
                    window.location.href = 'admin'; // Redirect to admin.php
                }, 5000);
            </script>
        <?php endif; ?>

        <?php if (isset($user)) : ?>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <div class="input-group">
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('new_password', this)">
                                <span id="new_password_icon" class="glyphicon glyphicon-eye-open"></span> View
                            </button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password:</label>
                    <div class="input-group">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('confirm_password', this)">
                                <span id="confirm_password_icon" class="glyphicon glyphicon-eye-open"></span> View
                            </button>
                        </div>
                    </div>
                </div>
                <button type="submit" name="reset_password" class="btn btn-primary">Reset Password</button>
            </form>
        <?php endif; ?>
    </div>

    <script>
        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            const isPasswordVisible = input.type === "text";

            // Toggle the type between "text" and "password"
            input.type = isPasswordVisible ? "password" : "text";

            // Change the button text based on the current state
            button.innerHTML = isPasswordVisible ? "View" : "Hide";
        }
    </script>
</body>

</html>