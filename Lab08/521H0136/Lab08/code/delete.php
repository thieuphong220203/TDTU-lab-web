<?php
require_once "db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id'])) {
        $product_id = intval($_POST['product_id']); // Convert to integer for security

        // Delete the product from the database

        // Get the image filename from the database before deleting the record
        $sql_get_image = "SELECT image FROM product WHERE id = $product_id";
        $result = mysqli_query($conn, $sql_get_image);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $image_filename = $row['image'];
            $sql = "DELETE FROM product WHERE id = $product_id";
            if (mysqli_query($conn, $sql)) {
                // Delete the image file
                $image_path = "images/" . $image_filename;
                if (file_exists($image_path))
                    unlink($image_path);
                header("Location: index.php?delete_success=true");
                exit();
            }
            $conn->close();
            // Redirect to the product list with a success message
        } else {
            // Handle error
            echo "Error deleting product: " . mysqli_error($conn);
            $conn->close();
        }
    } else {
        echo "Product not found.";
        $conn->close();
    }
} else {
    echo "Product ID not provided.";
    $conn->close();
}
