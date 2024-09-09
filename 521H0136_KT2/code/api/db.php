<?php
    $servername = "localhost";
    $db_user = "root";
    $db_password = "";
    $dbname = "lab08";

    //Create connection
    $conn = new mysqli($servername, $db_user, $db_password, $dbname);
    $conn->set_charset("utf8");

    if($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }