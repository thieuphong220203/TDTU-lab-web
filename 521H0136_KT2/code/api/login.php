<?php
require_once("db.php");
session_start();

// Initialize response array
$response = array();

// if (isset($_SESSION['user'])) {
//     // If user is already logged in, redirect to index.php
//     $response['redirect'] = 'index.php';
// } else {
$user = isset($_POST['user']) ? $_POST['user'] : '';
$pass = isset($_POST['pass']) ? $_POST['pass'] : '';

if (empty($user)) {
    $response['error'] = 'Please enter your username';
} else if (empty($pass)) {
    $response['error'] = 'Please enter your password';
} else if (strlen($pass) < 6) {
    $response['error'] = 'Password must have at least 6 characters';
} else {
    $sql = "SELECT username, password, firstname FROM account WHERE username = '$user'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password_from_db = $row['password'];

        if (password_verify($pass, $hashed_password_from_db)) {
            // Login successful
            $_SESSION['user'] = $row['username'];
            $_SESSION['name'] = $row['firstname'];
            $response['redirect'] = 'api/index.php';
        } else {
            // Invalid password
            $response['error'] = "Invalid username or password";
        }
    } else {
        // Invalid username
        $response['error'] = 'Invalid username or password';
    }
}
// }

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
