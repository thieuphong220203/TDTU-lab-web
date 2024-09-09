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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <title>PHP Exercises</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-8 my-3 mx-auto p-3">
            <div class="border rounded p-3">
                <h4 class="text-center mb-3">Nhập bình luận của bạn</h4>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Họ và tên</label>
                            <input id="name" name="name" type="text" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="type">Chọn màu nền</label>
                            <select id="type" name="type" class="custom-select">
                                <option value="alert-secondary" selected>Gray</option>
                                <option value="alert-success">Green</option>
                                <option value="alert-primary">Blue</option>
                                <option value="alert-danger">Red</option>
                                <option value="alert-warning">Yellow</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment">Bình luận</label>
                        <textarea id="comment" name="comment" class="form-control" placeholder="Nhập nội dung" style="height: 80px"></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Gửi bình luận</button>
                </form>
            </div>
            <div class="mt-3" style="max-height: 300px; overflow: scroll">
                <?php
                $comments = file_get_contents("comments.txt");
                if (!empty($comments)) {
                    $comments = explode("\n", $comments);
                    $comments = array_reverse($comments);
                    foreach ($comments as $comment) {
                        $comment = trim($comment);
                        if (!empty($comment)) {
                            $data = json_decode($comment, true);
                            echo '<div class="alert ' . $data["type"] . ' alert-dismissible">';
                            echo '<button type="button" class="close" data-id="' . $data["timestamp"] . '">&times;</button>';
                            echo '<strong>' . $data["name"] . ':</strong> ' . $data["comment"];
                            echo '<div class="text-right small">' . date("H:i - d/m/Y", $data["timestamp"]) . '</div>';
                            echo '</div>';
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Delete comment when close button is clicked
        $(".alert .close").click(function() {
            var timestamp = $(this).data("id");
            $.post("<?php echo $_SERVER['PHP_SELF']; ?>", {timestamp: timestamp, action: 'delete'}, function(data) {
                location.reload();
            });
        });
    });
</script>
</body>
</html>

<?php
// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $name = $_POST["name"];
    $type = $_POST["type"];
    $comment = $_POST["comment"];

    if (!empty($name) && !empty($comment)) {
        $timestamp = time();
        $data = array(
            "name" => $name,
            "type" => $type,
            "comment" => $comment,
            "timestamp" => $timestamp
        );
        $encoded_data = json_encode($data);
        // Append comment data to file
        file_put_contents("comments.txt", $encoded_data . "\n", FILE_APPEND);
    }
}

// Process comment deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "delete") {
    $timestamp = $_POST["timestamp"];
    $comments = file_get_contents("comments.txt");
    $comments = explode("\n", $comments);
    $updated_comments = array();
    foreach ($comments as $comment) {
        if (!empty($comment)) {
            $data = json_decode($comment, true);
            if ($data["timestamp"] != $timestamp) {
                $updated_comments[] = $comment;
            }
        }
    }
    file_put_contents("comments.txt", implode("\n", $updated_comments));
}
?>
