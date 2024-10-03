<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Welcome to the Admin Dashboard</h1>
    <p>Logged in as: <?php echo $_SESSION['email']; ?></p>

    <h2>Send Newsletter</h2>
    <form action="send_newsletter.php" method="POST">
        <div class="input-group">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required>
        </div>
        <div class="input-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>
        </div>
        <button type="submit">Send Newsletter</button>
    </form>

    <p><a href="logout.php">Logout</a></p>
</body>

</html>