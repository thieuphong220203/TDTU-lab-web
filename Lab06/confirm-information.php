<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>PHP Exercises</title>
</head>
<body>
<?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = !empty($_POST['name']) ? $_POST['name']: "no name";
        $email = !empty($_POST['email'] ) ? $_POST['email'] : "no email";
        $gender = !empty($_POST['gender']) ? $_POST['gender'] : "no gender";
        $browsers = !empty($_POST['browsers']) ? $_POST['browsers'] : "no browsers";
        $operating_system = $_POST['operating_system'];
    }
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-lg-5 my-5 mx-2 mx-sm-auto border rounded px-3 py-3">
            <h5 class="text-center mb-3 text-success">Confirm Information</h5>
            <form action="exercise4-template.html" method="POST">
                <div class="form-group">
                    <label for="name">Your name</label>
                    <p id="name" class="text-success font-weight-bold"><?php echo $name;?></p>
                </div>
                <div class="form-group">
                    <label for="email">Your email</label>
                    <p id="email" class="text-success font-weight-bold"><?php echo $email;?></p>
                </div>
                <div class="form-group">
                    <label for="gender" class="col-form-label">Gender</label>
                        <p id="gender" class="text-success font-weight-bold"><?php echo $gender;?></p>
                </div>
                <div class="form-group">
                    <legend class="col-form-label">Favorite web browsers</legend>
                    <ul>
                        <?php
                            foreach ($browsers as $browser) {
                                echo "<li class='text-success font-weight-bold'>$browser</li>";
                            }
                        ?>
                    </ul>
                </div>
                <div class="form-group">
                    <legend class="col-form-label">Prefered Operating System</legend>
                    <p id="gender" class="text-success font-weight-bold"><?php echo $operating_system;?></p>
                </div>
                <button class="btn btn-success px-5 mr-2">Send</button>
                <button  type="submit" class="btn btn-outline-success px-5">Back</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>