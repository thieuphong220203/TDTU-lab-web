<?php
header('Content-Type: application/json'); // Return JSON responses

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['code' => 2, 'message' => 'Only PUT method is supported']);
    exit();
}

require_once 'database/product_db.php'; // Include the database functions

// Decode JSON input from the request body
$input = json_decode(file_get_contents('php://input'), true);

if (is_null($input) || !isset($input['id']) || !isset($input['name']) || !isset($input['price'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['code' => 1, 'message' => 'Invalid parameters']); // Error response
    exit();
}

$id = intval($input['id']); // Get the product ID
$name = $input['name'];
$price = intval($input['price']);
$desc = isset($input['desc']) ? $input['desc'] : ''; // Description can be optional

// Call the function to update the product in the database
$is_updated = update_product($id, $name, $price, $desc);

if ($is_updated) {
    http_response_code(200); // OK
    echo json_encode(['code' => 0, 'message' => 'Product updated successfully']); // Success message
} else {
    http_response_code(404);
    json_encode(['code' => 5, 'message' => 'Product not found or no changes made']); // Failure message
}
