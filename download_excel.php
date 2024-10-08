<?php
// download_excel.php

// Database connection settings
$host = 'localhost';
$db = 'verifyads';
$user = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the IDs were passed via POST
if (isset($_POST['ids'])) {
    $ids = $_POST['ids']; // This should be an array of IDs
    $idsString = implode(',', array_map('intval', $ids)); // Sanitize and prepare for the SQL query

    // Query to fetch the selected records
    $sql = "SELECT * FROM newsletter WHERE id IN ($idsString)";
    $result = $conn->query($sql);

    // Check if there are results
    if ($result->num_rows > 0) {
        // Set headers for Excel file
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"selected_records.xls\"");

        // Output data for Excel
        echo "ID\tEmail\tDate\n"; // Column headers

        while ($row = $result->fetch_assoc()) {
            echo "{$row['id']}\t{$row['email']}\t" . date('Y-m-d', strtotime($row['createdDt'])) . "\n";
        }
    } else {
        echo "No data found for selected IDs.";
    }
} else {
    echo "No IDs provided.";
}

// Close connection
$conn->close();
?>
