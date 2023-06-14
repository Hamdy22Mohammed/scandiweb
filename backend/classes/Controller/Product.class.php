<?php

namespace Controller;

use Model\Validation;
use Model\Db;

abstract class Product extends Validation
{
    public $passed;
    protected $sku;
    protected $name;
    protected $price;
    protected $type;
    protected $frontend;
    protected $attribute_table;

    public function __construct()
    {
        $this->sku = $this->validateString('sku', $_POST['sku']);
        $this->sku = $this->validateUnique('product', 'sku', $_POST['sku']);
        $this->name = $this->validateString('name', $_POST['name']);
        $this->price = $this->validateFloat('price', $_POST['price']);
        $this->type = $this->validateType('productType', $_POST['productType']);

        $this->attribute_table = Db::query("SELECT attribute.*,attribute.name, type.name as type FROM attribute
        LEFT JOIN type
        ON attribute.type_id = type.id
        WHERE type.name=?;", [$_POST['productType']]);
    }
    public function addProduct()
    {
        $query = "INSERT INTO product(sku, name, price, front_end) VALUES (?,?,?,?)";
        $params = [$this->sku, $this->name, $this->price, $this->frontend];
        Db::query($query, $params);
    }

    public static function getAttrs()
    {
        $attributes = (Db::query("SELECT attribute.name as attr, unit FROM attribute
        LEFT JOIN type
        ON attribute.type_id = type.id
        WHERE type.name=?;", [$_POST['productType']]));
        echo json_encode($attributes);
    }

    public static function getProducts()
    {
        $products = (Db::query("SELECT sku, name, price, front_end FROM product;"));
        echo json_encode($products);
    }

    public static function deleteProducts()
    {
        Db::query("DELETE product , value FROM product  INNER JOIN value  
                WHERE product.id= value.product_id and product.sku IN ('" . implode("','", $_POST['toDelete']) . "');");
        echo json_encode('deleted');
    }

    abstract public function addValue();

    abstract public function frontendFormate();
}
