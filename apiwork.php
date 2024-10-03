<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>API Integration Example</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <center>
    <h1>Contact Details</h1>
  </center>

  <?php
  // Define the API URL
  $api_url = 'http://localhost/restapi/contact/contact?id=1';

  // Fetch data from the API
  $response = file_get_contents($api_url);

  // Check if the API response was successful
  if ($response === FALSE) {
    echo "<p>Failed to fetch data from the API.</p>";
    exit;
  }

  // Decode the JSON response
  $contact_data = json_decode($response, true);

  // Debug: Print the entire response to understand its structure
  echo "<pre>";print_r($contact_data);echo "</pre>";

  // Check if data is valid and contains the expected keys
  if (!empty($contact_data)) {
    echo "<h2>Contact Information:</h2>";

    // Use conditional checks to prevent warnings
    $fname = isset($contact_data['fname']) ? htmlspecialchars($contact_data['fname']) : 'N/A';
    $lname = isset($contact_data['lname']) ? htmlspecialchars($contact_data['lname']) : 'N/A';
    $email = isset($contact_data['email']) ? htmlspecialchars($contact_data['email']) : 'N/A';
    $phone = isset($contact_data['mobile']) ? htmlspecialchars($contact_data['mobile']) : 'N/A';
    $services = isset($contact_data['services']) ? htmlspecialchars($contact_data['services']) : 'N/A';
    $schedule = isset($contact_data['schedule']) ? htmlspecialchars($contact_data['schedule']) : 'N/A';
    $message = isset($contact_data['message']) ? htmlspecialchars($contact_data['message']) : 'N/A';

    // Display the data
    echo "<p><strong>Name:</strong> " . $fname . " " . $lname . "</p>";
    echo "<p><strong>Email:</strong> " . $email . "</p>";
    echo "<p><strong>Mobile:</strong> " . $phone . "</p>";
    echo "<p><strong>Services:</strong> " . $services . "</p>";
    echo "<p><strong>Schedule:</strong> " . $schedule . "</p>";
    echo "<p><strong>Message:</strong> " . $message . "</p>";
  } else {
    echo "<p>No data found for the given contact.</p>";
  }
  ?>

</body>

</html>