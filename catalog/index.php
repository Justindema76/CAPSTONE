<?php
require_once('../util/main.php');
require_once('../util/tags.php');
require_once('../database.php');
require_once('../model/product_db.php');
require_once('../model/category_db.php');
require_once('../model/product.php');
require_once('../model/category.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'list_products';
    }
}

switch ($action) {
    case 'list_products':
        // get current category
        $categoryID = filter_input(INPUT_GET, 'categoryID', 
                FILTER_VALIDATE_INT);
        if ($categoryID == NULL || $categoryID === FALSE) {
            $categoryID = 1;
        }                

        // get categories and products
        $current_category = CategoryDB::getCategory($categoryID);
        $categories = CategoryDB::getCategories();
        $products = ProductDB::getProductsByCategory($categoryID);

        // display view
        include('product_list.php');
        break;
    case 'view_product':
        $categories = CategoryDB::getCategories();

        // get product data
        $productID = filter_input(INPUT_GET, 'productID', 
                FILTER_VALIDATE_INT);
        $product = ProductDB::getProduct($productID);
        
        // display product
        include('product_view.php');
        break;
}
?>