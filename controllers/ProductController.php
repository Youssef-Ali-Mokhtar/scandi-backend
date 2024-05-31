<?php

namespace MyApp\controllers;


include_once './database/Database.php';
include_once './repositories/ProductRepository.php';
include_once './services/ProductService.php';

use MyApp\database\Database;
use MyApp\repositories\ProductRepository;
use MyApp\services\ProductService;

class ProductController {
    private $productService;

    public function __construct() {
        $database = new Database();
        $db = $database->connect();
        $productRepository = new ProductRepository($db);
        $this->productService = new ProductService($productRepository);
    }

    public function getAll() {
        $products = $this->productService->getAllProducts();
        echo json_encode($products);
    }

    public function getById($id) {
        $product = $this->productService->getProductById($id);
        echo json_encode($product);
    }

    public function getByCategory($category) {
        $products = $this->productService->getProductByCategory($category);
        echo json_encode($products);
    }
}
?>
