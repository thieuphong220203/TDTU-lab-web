<?php
require_once "db.php";
require_once "utils.php";



$response = array();

// Proceed with registration
// Your existing registration logic goes here...
$first_name = isset($_POST['first']) ? $_POST['first'] : '';
$last_name = isset($_POST['last']) ? $_POST['last'] : '';
$email =  isset($_POST['email']) ? $_POST['email'] : '';
$user = isset($_POST['user']) ? $_POST['user'] : '';
$pass = isset($_POST['pass']) ? $_POST['pass'] : '';
$pass_confirm = isset($_POST['pass-confirm']) ? $_POST['pass-confirm'] : '';
if (empty($first_name)) {
    $response['error'] = 'Please enter your first name';
} else if (empty($last_name)) {
    $response['error'] = 'Please enter your last name';
} else if (empty($email)) {
    $response['error'] = 'Please enter your email';
} else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
    $response['error'] = 'This is not a valid email address';
} else if (empty($user)) {
    $response['error'] = 'Please enter your username';
} else if (empty($pass)) {
    $response['error'] = 'Please enter your password';
} else if (strlen($pass) < 6) {
    $response['error'] = 'Password must have at least 6 characters';
} else if ($pass != $pass_confirm) {
    $response['error'] = 'Password does not match';
} else {
    // register a new account

    $activate_token =  generateToken(5);
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    // $response['message'] = $hashed_password;

    $stmt = $conn->prepare("INSERT INTO account (username, firstname, lastname, email, password, activate_token) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssssss",
        $user,
        $first_name,
        $last_name,
        $email,
        $hashed_password,
        $activate_token
    );

    if ($stmt->execute()) {
        $activation_link = 'http://localhost/test/code/api/activate.php?email='
            . urlencode($email)
            . '&activate_token='
            . urlencode($activate_token);
        $body = 'click to activate your account: <a href="'
            . $activation_link . '">Activate</a>';
        $response['message'] = "Check your email please";
        // send_mail($email, "Account Activation", $body);
        // echo $body;
        $response['link'] = $body;
        $response['redirect'] = true;
    } else {
        $response['error'] = 'Cannot execute MySQL statement';
        $stmt->close();
        $conn->close();
    }
}


// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
