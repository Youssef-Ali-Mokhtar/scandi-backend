<?php

namespace MyApp\factories;

require_once './models/attributeModel/Attribute.php';
require_once './models/attributeModel/Capacity.php';
require_once './models/attributeModel/Color.php';
require_once './models/attributeModel/Size.php';
require_once './models/attributeModel/TouchIDinkeyboard.php';
require_once './models/attributeModel/WithUSB3ports.php';

use MyApp\models\attributeModel\Attribute;
// use MyApp\models\attributeModel\Capacity;
// use MyApp\models\attributeModel\Color;
// use MyApp\models\attributeModel\Size;
// use MyApp\models\attributeModel\TouchIDinkeyboard;
// use MyApp\models\attributeModel\WithUSB3ports;

class AttributeFactory {
    public static function createAttribute(array $data): Attribute {
        $attributeType = str_replace(' ', '', $data['name']);
        $pathToClass = "MyApp\\models\\attributeModel\\" . ucfirst($attributeType);

        if (!(class_exists($pathToClass))) {
            throw new Exception("Class $pathToClass not found");
        }

        $attribute = new $pathToClass($data);

        if (!($attribute instanceof Attribute)) {
            throw new Exception("Invalid attribute type");
        }

        return $attribute;
    }
}
?>
