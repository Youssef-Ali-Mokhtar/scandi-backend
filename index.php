<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/controllers/ProductController.php';

use MyApp\controllers\ProductController;

$productController = new ProductController();

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];


if ($requestMethod == 'GET') {
    $requestPath = parse_url($requestUri, PHP_URL_PATH);

    // Routing logic
    if ($requestPath === '/scandi/products') {
        if (isset($_GET['category'])) {
            $category = $_GET['category'];
            $products = $productController->getByCategory($category);
            echo json_encode($products);
        } else {
            $products = $productController->getAll();
            echo json_encode($products);
        }
    } elseif (preg_match('/^\/scandi\/products\/([^\/]+)$/', $requestPath, $matches)) {
        $productId = $matches[1];
        $product = $productController->getById($productId);
        if ($product) {
            echo json_encode($product);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'Product not found']);
        }
    } else {
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'Endpoint not found']);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Only GET requests are allowed']);
}

?>
