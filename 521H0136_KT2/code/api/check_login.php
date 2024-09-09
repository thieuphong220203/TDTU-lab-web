<?php
session_start();

// Initialize response array
$response = array();

if (isset($_SESSION['user'])) {
    // User is logged in
    $response['loggedIn'] = true;
} else {
    // User is not logged in
    $response['loggedIn'] = false;
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
