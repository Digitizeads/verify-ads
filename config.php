<?php
// Set environment: 'development' or 'production'
$environment = getenv('APP_ENV') ?: 'development'; // Use an environment variable or default to 'development'

// Set the base API URL based on the environment
if ($environment === 'development') {
    define('WEBSERVICEAPI_URL', 'http://localhost/restapi/');
} else {
    define('WEBSERVICEAPI_URL', 'https://verifyads.com/restapi/');
}

// Function to get the API URL
function getWebserviceUrl() {
    return WEBSERVICEAPI_URL;
}
?>
