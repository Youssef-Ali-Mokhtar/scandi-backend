<?php 

namespace MyApp\services;

require_once './helper/ParseProduct.php';
require_once './factories/ProductFactory.php';

use MyApp\helper\ParseProduct;
use MyApp\factories\ProductFactory;

        // $products = [];

        // foreach ($productsData as $productData) {
        //     $product = ProductFactory::createProduct($productData);
        //     $product->setAttributesSet($attributesData);
        //     $products[] = $product->getDetails();
        // }

class ProductService {
    private $productRepository;

    public function __construct($productRepository) {
        $this->productRepository = $productRepository;
    }



    //One query, only Product table, no join with attribute
    public function getAllProducts() {
        $productsData = $this->productRepository->fetchAll();
        //DO I NEED A FACTORY METHOD HERE?
        return $productsData;
    }

    //GET ONE PRODUCT BY ID IN ONE QUERY
    public function getProductById($id) {

        $data = $this->productRepository->fetchById($id);

        if (!$data) {
            throw new Exception("Product not found");
        }

        // if ($data[0]['attributeId'] === null) {
        //     return $product;
        // }
        
        
        $extractedProduct = ParseProduct::extractProduct($data); //EXTRACT PRODUCT 
        
        $extractedAttributes = ParseProduct::extractAttributes($data); //EXTRACT ATTRIBUTES

        $productObj = ProductFactory::createProduct($extractedProduct); //FACTORY PATTERN FOR PRODUCT

        $productObj->setAttributesSet($extractedAttributes); //LEVERAGING POLYMORPHISM TO SET ATTRIBUTES

        $productObj->getDetails();

        return $productObj->getDetails();
    }

    public function getProductByCategory($category) {
        $productsData = $this->productRepository->fetchByCategory($category);

        return $productsData;
    }
}
?>
