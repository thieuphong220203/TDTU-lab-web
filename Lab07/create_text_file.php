<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $filename = $data['filename'];
    $content = $data['content'];
    $dir = "uploads/";
    file_put_contents($dir . $filename, $content);
}
?>