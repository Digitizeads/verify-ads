<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes
require_once 'phpmailer/src/Exception.php';
require_once 'phpmailer/src/PHPMailer.php';
require_once 'phpmailer/src/SMTP.php';

// contact.php - REST API
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'vendor/autoload.php'; // Ensure this path is correct

$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "verifyads";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if (isset($_POST['reset_request'])) {
    $email = $_POST['reset_email'];

    // Check if the email exists
    $sql = "SELECT * FROM user WHERE emailid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50)); // Generate token
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));
        $updateTokenSql = "UPDATE user SET password_reset_token = ?, token_expiry = ? WHERE emailid = ?";
        $updateStmt = $conn->prepare($updateTokenSql);
        $updateStmt->bind_param("sss", $token, $expiry, $email);

        if ($updateStmt->execute()) {
            // Call the passwordReset function to send the email
            $message = passwordReset($email, $token);
        } else {
            $message = "Error updating token: " . $updateStmt->error;
        }

        $updateStmt->close();
    } else {
        $message = "No account found with that email.";
    }

    $stmt->close();
}

$conn->close();

// Function to send password reset email
function passwordReset($email, $token)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Change this to your SMTP server if necessary
        $mail->SMTPAuth = true;
        $mail->Username = 'rajat.web71@gmail.com'; // Replace with your email
        $mail->Password = 'ctwh vyny rrdh nwcu'; // Replace with your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email content
        $mail->setFrom('rajat.web71@gmail.com', 'Tecknify'); // Replace with your email
        $mail->addAddress($email);
        $mail->Subject = 'Password Reset Request';

        // Create a reset link
        $resetLink = "http://localhost/verify-ads/reset_password.php?token=" . $token;
        $mail->Body = "Please click the following link to reset your password: <a href='$resetLink'>$resetLink</a>";
        $mail->isHTML(true); // Ensure the email is sent as HTML

        // Enable debugging
        $mail->SMTPDebug = 2; // Set to 0 for no output, 1 for errors and messages, 2 for detailed debug output

        // Send the email
        $mail->send();
        return "Password reset link has been sent to your email.";
    } catch (Exception $e) {
        return "Error sending email: " . $mail->ErrorInfo;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>

<body>
    <div class="forgot-password">
        <div class="form-container">
            <h2>Forgot Password</h2>

            <!-- Message Area -->
            <?php if ($message != ''): ?>
                <p class="message"><?php echo $message; ?></p>
            <?php endif; ?>

            <!-- Forgot Password Form -->
            <form method="POST">
                <div class="input-group">
                    <label for="reset_email">Email:</label>
                    <input type="email" id="reset_email" name="reset_email" required>
                </div>
                <button type="submit" name="reset_request">Send Reset Link</button>
            </form>
        </div>
    </div>
</body>

</html>
