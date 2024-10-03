<?php
$servername = "localhost";
$username = "root";  // Replace with your MySQL username
$password = "";      // Replace with your MySQL password
$dbname = "verifyads";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';  // Store any success/error messages

// Handle signup form submission
if (isset($_POST['signup'])) {
    $email = $_POST['signup_email'];
    $password = password_hash($_POST['signup_password'], PASSWORD_BCRYPT);  // Hash the password

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

        // Verify password
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['email'] = $user['email'];
            header('Location: home');
            exit;
        } else {
            $message = "Invalid password. Please try again.";
        }
    } else {
        $message = "No account found with that email. Please sign up.";
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-signup {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container {
            max-width: 400px;
            margin: auto;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        p {
            text-align: center;
        }

        #toggle-signup,
        #toggle-login {
            color: blue;
            cursor: pointer;
        }

        .message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="login-signup">
        <div class="form-container">
            <h2 id="form-title">Admin Login</h2>

            <!-- Message Area -->
            <?php if ($message != ''): ?>
                <p class="message"><?php echo $message; ?></p>
            <?php endif; ?>

            <!-- Login Form -->
            <form id="login-form" method="POST">
                <div class="input-group">
                    <label for="login_email">Email:</label>
                    <input type="email" id="login_email" name="login_email" required>
                </div>
                <div class="input-group">
                    <label for="login_password">Password:</label>
                    <input type="password" id="login_password" name="login_password" required>
                </div>
                <button type="submit" name="login">Login</button>
                <p>Don't have an account? <span id="toggle-signup">Sign Up</span></p>
            </form>

            <!-- Signup Form -->
            <form id="signup-form" method="POST" style="display: none;">
                <div class="input-group">
                    <label for="signup_email">Email:</label>
                    <input type="email" id="signup_email" name="signup_email" required>
                </div>
                <div class="input-group">
                    <label for="signup_password">Password:</label>
                    <input type="password" id="signup_password" name="signup_password" required>
                </div>
                <button type="submit" name="signup">Sign Up</button>
                <p>Already have an account? <span id="toggle-login">Login</span></p>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('toggle-signup').addEventListener('click', function() {
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('signup-form').style.display = 'block';
            document.getElementById('form-title').innerText = 'Admin Sign Up';
        });

        document.getElementById('toggle-login').addEventListener('click', function() {
            document.getElementById('signup-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
            document.getElementById('form-title').innerText = 'Admin Login';
        });
    </script>
</body>

</html>