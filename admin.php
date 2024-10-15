<?php
include 'config.php';
session_start();

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load the PHPMailer classes from the src folder
require_once 'phpmailer/src/Exception.php';
require_once 'phpmailer/src/PHPMailer.php';
require_once 'phpmailer/src/SMTP.php';

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

// Handle signup form submission
if (isset($_POST['signup'])) {
    $email = $_POST['signup_email'];
    $password = password_hash($_POST['signup_password'], PASSWORD_BCRYPT);

    // Check if email already exists
    $checkEmailQuery = "SELECT * FROM user WHERE emailid = ?";
    $checkStmt = $conn->prepare($checkEmailQuery);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        $message = "Email already exists. Please choose another email.";
    } else {
        $sql = "INSERT INTO user (emailid, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);

        if ($stmt->execute()) {
            $message = "Signup successful! You can now log in.";
        } else {
            $message = "Error during signup: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Handle login form submission
if (isset($_POST['login'])) {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    $sql = "SELECT * FROM user WHERE emailid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['email'] = $user['emailid'];

            header('Location: home');
            exit();
        } else {
            $message = "Invalid password. Please try again.";
        }
    } else {
        $message = "No account found with that email. Please sign up.";
    }

    $stmt->close();
}

if (isset($_POST['reset_request'])) {
    $email = $_POST['reset_email'];

    date_default_timezone_set('Asia/Kolkata');

    $sql = "SELECT * FROM user WHERE emailid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate a password reset token
        $token = bin2hex(random_bytes(50));

        // Update the user table with the token and set an expiry time (e.g., 1 hour from now)
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));
        $updateTokenSql = "UPDATE user SET password_reset_token = ?, token_expiry = ? WHERE emailid = ?";
        $updateStmt = $conn->prepare($updateTokenSql);
        $updateStmt->bind_param("sss", $token, $expiry, $email);

        if ($updateStmt->execute()) {
            // Create a password reset link with the token
            $resetLink = "http://localhost/verify-ads/reset_password.php?token=" . $token;
            /*  $resetLink = WEBSERVICEAPI_URL . "/reset_password.php?token=" . $token; */

            // Initialize PHPMailer
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'rajat.web71@gmail.com';               // SMTP username
                $mail->Password   = 'ctwh vyny rrdh nwcu';                  // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('rajat.web71@gmail.com', 'Verify-ads');
                $mail->addAddress($email);                                  // Add a recipient

                // Content
                $mail->isHTML(true);                                        // Set email format to HTML
                $mail->Subject = 'Password Reset Request';
                $mail->Body    = "Hello, <br><br>Please click the link below to reset your password:<br><a href='" . $resetLink . "'>Reset Password</a><br><br>If you did not request a password reset, please ignore this email.";
                $mail->AltBody = "Hello, \n\nPlease click the link below to reset your password:\n" . $resetLink . "\n\nIf you did not request a password reset, please ignore this email.";

                $mail->send();
                $message = "Password reset link has been sent to your registered email.";
            } catch (Exception $e) {
                $message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login/Signup</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="login-signup card shadow-sm p-4" style="max-width: 400px; width: 100%;">
        <div class="form-container">
            <h2 id="form-title" class="text-center">Admin Login</h2>

            <?php if ($message != ''): ?>
                <p class="text-danger text-center"><?php echo $message; ?></p>
            <?php endif; ?>

            <!-- Login Form -->
            <form id="login-form" method="POST" class="active">
                <div class="mb-3">
                    <input type="email" class="form-control" name="login_email" required placeholder="Email">
                </div>
                <div class="mb-3 position-relative">
                    <input type="password" class="form-control" id="login_password" name="login_password" required placeholder="Password">
                    <span class="toggle-password position-absolute end-0 top-50 translate-middle-y me-3 text-primary" onclick="togglePassword('login_password')" style="cursor: pointer;">Show</span>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3" name="login">Login</button>
                <p class="text-center">Don't have an account? <span id="toggle-signup" class="text-primary" style="cursor: pointer;">Sign Up</span></p>
                <p class="text-center"><span id="toggle-forgot-password" class="text-primary" style="cursor: pointer;">Forgot Password?</span></p>
            </form>

            <!-- Signup Form -->
            <form id="signup-form" method="POST" style="display: none;">
                <div class="mb-3">
                    <input type="email" class="form-control" name="signup_email" required placeholder="Email">
                </div>
                <div class="mb-3 position-relative">
                    <input type="password" class="form-control" id="signup_password" name="signup_password" required placeholder="Password">
                    <span class="toggle-password position-absolute end-0 top-50 translate-middle-y me-3 text-primary" onclick="togglePassword('signup_password')" style="cursor: pointer;">Show</span>
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3" name="signup">Sign Up</button>
                <p class="text-center">Already have an account? <span id="toggle-login" class="text-primary" style="cursor: pointer;">Login</span></p>
            </form>

            <!-- Forgot Password Form -->
            <form id="forgot-password-form" method="POST" style="display: none;">
                <div class="mb-3">
                    <input type="email" class="form-control" name="reset_email" required placeholder="Email">
                </div>
                <button type="submit" class="btn btn-primary w-100 mb-3" name="reset_request">Request Password Reset</button>
                <p class="text-center">Remembered your password? <span id="toggle-login-from-reset" class="text-primary" style="cursor: pointer;">Login</span></p>
            </form>

            <!-- Added hyperlink below the forms -->
            <div class="text-center mt-3">
                <a href="http://localhost/verify-ads" class="text-decoration-none">Go to Verify Ads Platform</a>
                <!-- <a href="https://verify-ads.com" class="text-decoration-none">Go to Verify Ads Platform</a> -->
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('toggle-signup').addEventListener('click', function() {
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('signup-form').style.display = 'block';
            document.getElementById('forgot-password-form').style.display = 'none';
            document.getElementById('form-title').innerText = 'Admin Sign Up';
        });

        document.getElementById('toggle-login').addEventListener('click', function() {
            document.getElementById('signup-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
            document.getElementById('forgot-password-form').style.display = 'none';
            document.getElementById('form-title').innerText = 'Admin Login';
        });

        document.getElementById('toggle-forgot-password').addEventListener('click', function() {
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('forgot-password-form').style.display = 'block';
            document.getElementById('signup-form').style.display = 'none';
            document.getElementById('form-title').innerText = 'Forgot Password';
        });

        document.getElementById('toggle-login-from-reset').addEventListener('click', function() {
            document.getElementById('forgot-password-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
            document.getElementById('form-title').innerText = 'Admin Login';
        });

        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const toggleButton = passwordField.nextElementSibling;

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleButton.textContent = "Hide";
            } else {
                passwordField.type = "password";
                toggleButton.textContent = "Show";
            }
        }
    </script>
</body>

</html>