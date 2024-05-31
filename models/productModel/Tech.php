<?php

namespace MyApp\models\productModel;

require_once './factories/AttributeFactory.php';
require_once './models/productModel/Product.php';
require_once './factories/AttributeFactory.php';

use MyApp\models\productModel\Tech;
use MyApp\factories\AttributeFactory;


class Tech extends Product {
    public function __construct($data) {
        parent::__construct($data);
    }

    public function setAttributesSet(array $attributesData) {

        $attributeNames = ['Color', 'Capacity', 'With USB 3 ports', 'Touch ID in keyboard'];

        $innerAttributes = [];

        foreach ($attributesData as $attributeData) {

            if (in_array($attributeData['name'], $attributeNames)) {

                $attribute = AttributeFactory::createAttribute($attributeData);
                
                $attribute->setItems($attributeData['items']);
                
                $this->attributes[] = $attribute->getDetails();
            }

        }

    }
}


?>