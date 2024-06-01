<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "./vendor/autoload.php";
require_once "./config/config.php";

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
            $productController->getByCategory($category);
        } else {
            $productController->getAll();
        }
    } elseif (preg_match('/^\/scandi\/products\/([^\/]+)$/', $requestPath, $matches)) {
        $productId = $matches[1];
        $productController->getById($productId);

    } else {
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'Endpoint not found']);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Only GET requests are allowed']);
}

?>
