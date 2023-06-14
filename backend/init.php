<?php
include './includes/autoLoader.php';
$_POST = json_decode(file_get_contents('php://input'), true);
use Controller as C;
$controller = new C\Controller();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addProduct'])) {
        $type = $_POST['productType'];
        $class =  __NAMESPACE__ . '\\Controller\\' . $type;
        $obj = new $class; 
        $controller->addProductAndValue($obj);
    } else if (isset($_POST['getAttr'])) {
        $controller->getAttrs();
    } else if (isset($_POST['getProducts'])) {
        $controller->getProducts();
    } else if (isset($_POST['toDelete'])) {
        $controller->deleteProducts();
    }
}
