<?php
// Start or resume the session
session_start();

// Retrieve the IP address from the POST request
$data = json_decode(file_get_contents("php://input"), true);
$ipAddress = $data['ipAddress'];

// Store the IP address in a PHP session variable
$_SESSION['user_ip'] = $ipAddress;
?>