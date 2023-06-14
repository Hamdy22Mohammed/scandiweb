<?php
namespace Controller;
use Model\Db;
class Book extends Product
{
    public $weight;

    public function __construct()
    {
        parent::__construct();
        $this->weight = $this->validateFloat('weight', $_POST['weight']);
    }

    public function frontendFormate()
    {
        $this->frontend = $this->weight . $this->attribute_table[0]['unit'];
        return $this->frontend;
    }

    public function addValue()
    {
        $lastId = Db::productLastId('product');
        $attribute_table = Db::query("SELECT attribute.*,attribute.name, type.name as type FROM attribute
            LEFT JOIN type
            ON attribute.type_id = type.id
            WHERE attribute.name=?;", ['weight']);

        $query = "INSERT INTO value(product_id, attribute_id, attribute_value) VALUES (?,?,?)";
        $params = [$lastId['last'], $attribute_table[0]['id'], $this->weight];
        Db::query($query, $params);
    }
}
