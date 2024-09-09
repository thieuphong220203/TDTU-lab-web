<?php
require_once "db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    if (isset($_POST['product_id'], $_POST['name'], $_POST['price'], $_POST['desc'])) {
        $product_id = intval($_POST['product_id']);
        $product_name = mysqli_real_escape_string($conn, $_POST['name']);
        $product_price = intval($_POST['price']); // Ensure it's an integer
        $product_desc = mysqli_real_escape_string($conn, $_POST['desc']);
        $sql = "UPDATE product
        SET name = '$product_name', price = $product_price, description = '$product_desc'
        WHERE id = $product_id";
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php?edit_success=true");
            $conn->close();
            exit();
        } else {
            echo "Error updating product: " . mysqli_error($conn);
            $conn->close();
        }
    } else {
        echo "Invalid input data. Please try again.";
    }
} else {
    echo "Invalid request method.";
}
