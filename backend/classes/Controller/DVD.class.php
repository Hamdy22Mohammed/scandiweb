<?php
namespace Controller;
use Model\Db;
class DVD extends Product
{
    public $size;

    public function __construct()
    {
        parent::__construct();
        $this->size = $this->validateFloat('size', $_POST['size']);
    }

    public function frontendFormate()
    {
        $this->frontend = $this->size . $this->attribute_table[0]['unit'];
        return $this->frontend;
    }

    public function addValue()
    {
        $lastId = Db::productLastId('product');
        $attribute_table = Db::query("SELECT attribute.*,attribute.name, type.name as type FROM attribute
            LEFT JOIN type
            ON attribute.type_id = type.id
            WHERE attribute.name=?;", ['size']);

        $query = "INSERT INTO value(product_id, attribute_id, attribute_value) VALUES (?,?,?)";
        $params = [$lastId['last'], $attribute_table[0]['id'], $this->size];
        Db::query($query, $params);
    }
}
