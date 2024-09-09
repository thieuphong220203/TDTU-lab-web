<?php
$targetDir = "uploads/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}
$targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
if (file_exists($targetFile)) {
    echo json_encode(array('message' => 'File already exists'));
    exit;
}
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo json_encode(array('message' => 'File is too large'));
    exit;
}
if ($fileType != "jpg" && $fileType != "png" && $fileType != "txt") {
    echo json_encode(array('message' => 'File type is invalid'));
    exit;
}
if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
    echo json_encode(array('message' => 'Error uploading file'));
    exit;
}
echo json_encode(array('message' => 'File uploaded successfully'));
