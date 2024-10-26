<?php
// Include database connection and required models
require_once('../../database.php');
require_once('../../util/tags.php');
require_once('../../model/product_db.php');
require_once('../../model/category_db.php');
require_once('../../model/product.php');
require_once('../../model/category.php');

// Create a database connection
$db = Database::getDB(); // Ensure you have a function that returns the PDO connection

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'list_products';  // Default action
    }
}

// After creating CategoryDB instance

$productDB = new ProductDB($db); // Create instance of ProductDB

switch ($action) {
    case 'list_products':
        $categoryID = filter_input(INPUT_GET, 'categoryID', FILTER_VALIDATE_INT);
        if ($categoryID === FALSE || $categoryID === NULL) {
            $categoryID = 1;  // Default category
        }                
        $current_category = $categoryDB->getCategory($categoryID);  // Get current category
        $categories = $categoryDB->getCategories();  // Get all categories
        $products = $productDB->getProductsByCategory($categoryID);  // Get products by category
        include('product_list.php');  // Include the product listing view
        break;

    // Other cases remain unchanged...


    case 'view_product':
        $categories = $categoryDB->getCategories();  // Get all categories
        $productID = filter_input(INPUT_GET, 'productID', FILTER_VALIDATE_INT);  // Get product ID
        $product = ProductDB::getProduct($productID);  // Fetch product details
        include('product_view.php');  // Include the product view page
        break;

    case 'delete_product':
        $productID = filter_input(INPUT_POST, 'productID', FILTER_VALIDATE_INT);  // Get product ID
        $categoryID = filter_input(INPUT_POST, 'categoryID', FILTER_VALIDATE_INT);  // Get category ID
        ProductDB::deleteProduct($productID);  // Delete the product
        
        // Redirect to product list for the current category
        header("Location: .?categoryID=$categoryID");
        break;

    case 'show_add_edit_form':
        $categories = $categoryDB->getCategories();  // Get all categories
        $productID = filter_input(INPUT_GET, 'productID', FILTER_VALIDATE_INT);  // Get product ID
        if ($productID == NULL) {
            $productID = filter_input(INPUT_POST, 'productID', FILTER_VALIDATE_INT);
        }
        if (isset($productID)) {
            $product = ProductDB::getProduct($productID);  // Fetch product if editing
        }
        include('edit_add_product.php');  // Include add/edit product form
        break;

    case 'add_product':        
        $categoryID = filter_input(INPUT_POST, 'categoryID', FILTER_VALIDATE_INT);  // Get category ID
        $productCode = filter_input(INPUT_POST, 'code');  // Get product code
        $productName = filter_input(INPUT_POST, 'name');  // Get product name
        $productDescription = filter_input(INPUT_POST, 'description');  // Get product description
        $productPrice = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);  // Get product price
        $productDiscountPercent = filter_input(INPUT_POST, 'discount_percent', FILTER_VALIDATE_FLOAT);  // Get discount percent
        $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);  // Get stock value

        if ($categoryID === FALSE || $productCode == NULL || $productName == NULL || $productDescription == NULL || $productPrice === FALSE || $productDiscountPercent === FALSE || $stock === FALSE) {            
            $error = 'Invalid product data. Check all fields and try again.';  // Handle errors
            include('../../errors/error.php');
        } else {
            $category = new Category($categoryID, "");  // Create category object
            $product = new Product($category, $productCode, $productName, $productDescription, $productPrice, $productDiscountPercent, $stock);  // Create product object with stock
            $productID = ProductDB::addProduct($product);  // Add product to the database
            
            // Redirect to the newly added product view
            header("Location: .?action=view_product&productID=$productID");
        }
        break;

    case 'update_product':
        $productID = filter_input(INPUT_POST, 'productID', FILTER_VALIDATE_INT);  // Get product ID
        $categoryID = filter_input(INPUT_POST, 'categoryID', FILTER_VALIDATE_INT);  // Get category ID
        $productCode = filter_input(INPUT_POST, 'code');  // Get product code
        $productName = filter_input(INPUT_POST, 'name');  // Get product name
        $productDescription = filter_input(INPUT_POST, 'description');  // Get description
        $productPrice = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);  // Get price
        $productDiscountPercent = filter_input(INPUT_POST, 'discount_percent', FILTER_VALIDATE_FLOAT);  // Get discount percent
        $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);  // Get stock value

        if ($productID === FALSE || $categoryID === FALSE || $productCode == NULL || $productName == NULL || $productDescription == NULL || $productPrice === FALSE || $productDiscountPercent === FALSE || $stock === FALSE) {            
            $error = 'Invalid product data. Check all fields and try again.';  // Handle errors
            include('../../errors/error.php');
        } else {
            $category = new Category($categoryID, "");  // Create category object
            $product = new Product($category, $productCode, $productName, $productDescription, $productPrice, $productDiscountPercent, $stock);  // Create product object with stock
            $product->setProductID($productID);  // Set product ID
            ProductDB::updateProduct($product);  // Update product in the database
            
            // Redirect to updated product view
            header("Location: .?action=view_product&productID=$productID");
        }
        break;
}
