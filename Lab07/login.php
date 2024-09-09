<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php
    session_start();
     $mock_user = "admin";
     $mock_pwd = "123";
     $error = null;

     if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['username']) && isset($_POST['password'])) {
            $user = $_POST['username'];
            $pwd = $_POST['password'];
            if($user === $mock_user && $pwd === $mock_pwd) {
                $_SESSION['username'] = $user;
                header("Location: home.php"); 
                exit;
            }
        }
        $error = "Invalid username or password";
     }
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <h3 class="text-center text-secondary mt-5 mb-3">User Login</h3>
            <form method ="POST" action="login.php" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input id="username" type="text" name="username" class="form-control" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="remember">
                    <label class="custom-control-label" for="remember">Remember login</label>
                </div>
                <div class="form-group">
                    <?php
                        if($error != null) {
                            echo "<div class='alert alert-danger'>{$error}</div>";
                        }
                    ?>
                    <button type="submit"  class="btn btn-success px-5">Login</button>
                </div>
                <div class="form-group">
                    <p>Forgot password? <a href="#">Click here</a></p>
                </div>
            </form>

        </div>
    </div>


</div>

<script>
    function validateData(event) {
        
        var username = document.getElementById("username").value;
        var pwd = document.getElementById("password").value;
        var message = document.querySelector(".alert");
        if(username === "" || pwd === "") {
            message.textContent = "You need to fill in username and password";
            message.classList.remove('d-none');
            event.preventDefault();
        }else{
            message.style.display = "none";
            return true;
        }
    }
</script>

</body>
</html>
