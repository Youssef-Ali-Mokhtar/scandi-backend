<?php

namespace MyApp\repositories;

use PDO;

class ProductRepository {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    //One query, only Product table, no join with attribute
    public function fetchAll() {
        $query = "SELECT * FROM product;";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // One query, get product by id, join with attribute table
    public function fetchById($id) {
        $query = "
        SELECT p.id AS productId, p.name AS productName, p.inStock, p.category, p.brand, 
        a.id AS attributeId, a.name AS attributeName, a.type, ai.id AS itemId, ai.value,
        ai.displayValue
        FROM product AS p
        LEFT JOIN product_attribute AS pa 
        ON p.id = pa.productId 
        LEFT JOIN attribute AS a
        ON pa.attributeId = a.id 
        LEFT JOIN product_attribute_item AS pai
        ON pa.id = pai.productAttributeId 
        LEFT JOIN ( 
            SELECT id, value, displayValue, 'Size' as type FROM size 
            UNION ALL 
            SELECT id, value, displayValue, 'Color' as type FROM color 
            UNION ALL 
            SELECT id, value, displayValue, 'Capacity' as type FROM capacity 
            UNION ALL 
            SELECT id, value, displayValue, 'With USB 3 ports' as type 
            FROM with_usb_3_ports 
            UNION ALL 
            SELECT id, value, displayValue, 'Touch ID in keyboard' as type FROM touch_id_in_keyboard 
        ) AS ai 
        ON pai.itemId = ai.id
        AND pai.attributeType = ai.type
        WHERE p.id = :id;
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchByCategory($category) {
        $query = "SELECT * FROM product WHERE category = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $category);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function fetchAttributesByProductId($productId) {
    //     $query = "SELECT * FROM attributes WHERE product_id = ?";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(1, $productId, PDO::PARAM_INT);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
}
?>
