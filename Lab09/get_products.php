<?php
header('Content-Type: application/json');
require_once 'database/product_db.php';
try {
    $products = get_products();

    http_response_code(200); // OK
    echo json_encode($products);
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['code' => 3, 'message' => 'Server error']);
}
