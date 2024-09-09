<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    $foldername = $data['foldername'];
    $dir = "uploads/";
    mkdir($dir . $foldername);
}
?>