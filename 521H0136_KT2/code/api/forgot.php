<?php
require_once 'db.php';
require_once 'utils.php';
$error = '';
$email = '';
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    if (empty($email)) {
        $error = 'Please enter your email';
    } else if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
        $error = 'This is not a valid email address';
    } else {
        // reset password
        $sql = "SELECT * FROM account WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $token = generateToken(20);
            $reset_link = 'http://localhost/Lab08/code/reset_password.php?email='
                . urlencode($email)
                . '&token='
                . urlencode($token);
            $subject = 'Reset your password';
            $body = 'Click <a href="' . $reset_link . '">here</a> to reset your password';
            if (send_mail($email, $subject, $body) === true) {
                $error = 'An email has been sent to your email address. Please check your email to reset your password';
            } else {
                $error = 'An error occurred. Please try again';
            }
        } else {
            $error = 'This email does not exist in the database';
        }
    }
}
?>

<DOCTYPE html>
    <html lang="en">

    <head>
        <title>Reset user password</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>

    <body>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <h3 class="text-center text-secondary mt-5 mb-3">Reset Password</h3>
                    <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" id="email" type="text" class="form-control" placeholder="Email address">
                        </div>
                        <div class="form-group">
                            <p>If your email exists in the database, you will receive an email containing the reset password instructions.</p>
                        </div>
                        <div class="form-group">
                            <?php
                            if (!empty($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            }
                            ?>
                            <button class="btn btn-success px-5">Reset password</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </body>

    </html>