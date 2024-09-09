<?php
header('Content-Type: application/json'); // Ensure the response is JSON

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['code' => 2, 'message' => 'Only POST method is supported']);
    exit();
}

require_once 'database/product_db.php'; // Include the database functions

$input = json_decode(file_get_contents('php://input'), true); // Get JSON input

// Validate the required fields
if (is_null($input) || empty($input['name']) || !isset($input['price'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['code' => 1, 'message' => 'Invalid parameters']); // Error response
    exit();
}

// Prepare the data to add to the database
$name = $input['name'];
$price = intval($input['price']);
$desc = isset($input['desc']) ? $input['desc'] : ''; // Description can be optional

// Call the function to add a new product to the database
$product_id = add_product($name, $price, $desc);

if ($product_id) {
    http_response_code(201); // Created
    echo json_encode(['id' => $product_id, 'name' => $name, 'price' => $price, 'desc' => $desc]); // Return the new product
} else {
    http_response_code(500); // Internal Server Error
    echo json_encode(['code' => 3, 'message' => 'Failed to add product']); // Error message
}
