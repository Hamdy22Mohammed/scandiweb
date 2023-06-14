<?php
namespace Controller;
class Controller
{
    public function addProductAndValue(Product $classType)
    {
        if (count($classType->errors) > 0) {
            echo json_encode($classType->errors);
        } else {
            $classType->frontendFormate();
            $classType->addProduct();
            $classType->addValue();
            echo json_encode('succeed');
        }
    }
    public function getAttrs()
    {
        Product::getAttrs();
    }
    public function getProducts()
    {
        Product::getProducts();
    }
    public function deleteProducts()
    {
        Product::deleteProducts();
    }
}
