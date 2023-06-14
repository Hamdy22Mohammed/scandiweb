<?php
namespace Controller;
use Model\Db;
class Furniture extends Product
{
    public $attributes = [];

    public function __construct()
    {
        parent::__construct();
        $this->attributes = ['width' => $this->validateFloat('width', $_POST['width']), 'height' => $this->validateFloat('height', $_POST['height']), 'length' => $this->validateFloat('length', $_POST['length'])];
    }

    public function frontendFormate()
    {
        $this->frontend = $this->attributes['height'] . 'x' . $this->attributes['width'] . 'x' . $this->attributes['length'] . $this->attribute_table[0]['unit'];
        return $this->frontend;
    }

    public function addValue()
    {
        foreach ($this->attributes as $attribute_key => $attribute_value) {
            $lastId = Db::productLastId('product');
            $attribute_table = Db::query("SELECT attribute.*,attribute.name, type.name as type FROM attribute
            LEFT JOIN type
            ON attribute.type_id = type.id
            WHERE attribute.name=?;", [$attribute_key]);

            $query = "INSERT INTO value(product_id, attribute_id, attribute_value) VALUES (?,?,?)";
            $params = [$lastId['last'], $attribute_table[0]['id'], $attribute_value];
            Db::query($query, $params);
        }
    }
}
