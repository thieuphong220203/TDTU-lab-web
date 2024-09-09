<?php
header('Content-Type: application/json'); // Set the response to be JSON

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['code' => 2, 'message' => 'Only DELETE method is supported']);
    exit();
}

if (!isset($_GET['id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['code' => 1, 'message' => 'ID parameter is required']);
    exit();
}

$id = intval($_GET['id']); // Get the product ID from the URL

require_once 'database/product_db.php'; // Include database functions

$is_deleted = delete_product($id); // Delete the product from the database

if ($is_deleted) {
    http_response_code(200); // OK
    echo json_encode(['code' => 0, 'message' => 'Product deleted successfully']); // Success response
} else {
    http_response_code(404); // Not Found
    echo json_encode(['code' => 5, 'message' => 'Product not found']); // Failure response
}
