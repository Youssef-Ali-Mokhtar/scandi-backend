<?php


namespace MyApp\factories;

require_once './models/productModel/Product.php';
require_once './models/productModel/Tech.php';
require_once './models/productModel/Clothes.php';

// use MyApp\models\productModel\Tech;
// use MyApp\models\productModel\Clothes;
use MyApp\models\productModel\Product;


class ProductFactory {
    public static function createProduct(array $data): Product {
        $productType = str_replace(' ', '', $data['category']);

        

        // CHANGE VARIABLE NAME!!!
        $pathToClass = "MyApp\\models\\productModel\\" . ucfirst($productType);

        

        if (!(class_exists($pathToClass))) {
            throw new Exception("Class $pathToClass not found");
        }

        $product = new $pathToClass($data);

        if (!($product instanceof Product)) {
            throw new Exception("Invalid product category");
        }

        return $product;
    }
}
?>
