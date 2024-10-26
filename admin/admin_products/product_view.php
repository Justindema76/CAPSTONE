<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection and necessary files
require_once('../../database.php');
require_once('../../model/product.php');
require_once('../../model/category.php');
require_once('../../model/product_db.php');
require_once('../../model/category_db.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get the database connection
$db = Database::getDB();

// Get product ID from the query string and validate
$productID = filter_input(INPUT_GET, 'productID', FILTER_VALIDATE_INT);
if (!$productID) {
    $_SESSION['feedback'] = 'Invalid product ID.';
    header('Location: products_list.php');
    exit();
}

// Fetch product details
$queryProduct = 'SELECT p.*, c.categoryName 
                 FROM products p
                 JOIN categories c ON p.categoryID = c.categoryID
                 WHERE p.productID = :productID';
$statement = $db->prepare($queryProduct);
$statement->bindValue(':productID', $productID);
$statement->execute();
$row = $statement->fetch(PDO::FETCH_ASSOC);
$statement->closeCursor();

// Check if product exists
if ($row) {
    $category = new Category($row['categoryID'], $row['categoryName']);
    $product = new Product(
        $category,
        $row['productCode'],
        $row['productName'],
        $row['description'],
        (float)$row['listPrice'],
        (float)$row['discountPercent'],
        (int)$row['stock']
    );
    $product->setProductID($row['productID']);
} else {
    $_SESSION['feedback'] = 'Product not found.';
    header('Location: products_list.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="../../css/products.css">
</head>
<body>
    <?php include("../../view/admin_sidebar.php"); ?>
    <main>
        <h1>Product Manager - View Product</h1>
        <div class="product_view">
            <div id="product-image">
                <!-- Add the product image code here -->
            </div>
            <div class="product-details">
                <p><strong>Category:</strong> <?php echo htmlspecialchars($product->getCategory()->getCategoryName()); ?></p>
                <p><strong>Product Code:</strong> <?php echo htmlspecialchars($product->getProductCode()); ?></p>
                <p><strong>Product Name:</strong> <?php echo htmlspecialchars($product->getProductName()); ?></p>
                <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($product->getProductDescription())); ?></p>
                <p><strong>Price:</strong> $<?php echo htmlspecialchars($product->getProductPriceFormatted()); ?></p>
                <p><strong>Discount Percent:</strong> <?php echo htmlspecialchars($product->getProductDiscountPercentFormatted()); ?>%</p>

                <!-- Add to Cart Form -->
                <form action="<?php echo $app_path . 'cart'; ?>" method="post" id="add_to_cart_form">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="productID" value="<?php echo $product->getProductID(); ?>">
                    <b>Quantity:</b>
                    <input type="number" name="quantity" value="1" min="1" size="2" required>
                    <input type="submit" value="Add to Cart">
                </form>

                <p><strong>Your Price:</strong> $<?php echo htmlspecialchars($product->getProductDiscountPriceFormatted()); ?> (You save $<?php echo htmlspecialchars($product->getProductDiscountAmountFormatted()); ?>)</p>

                <div class="last_paragraph">
                    <form action="../admin_products/edit_add_product.php" method="post" id="edit_button_form">
                        <input type="hidden" name="action" value="show_add_edit_form"/>
                        <input type="hidden" name="productID" value="<?php echo $product->getProductID(); ?>" />
                        <input type="hidden" name="categoryID" value="<?php echo $product->getCategory()->getCategoryID(); ?>" />
                        <button type="submit" class="edit-button">Edit Product</button>
                    </form>
                    <form action="." method="post">
                        <input type="hidden" name="action" value="delete_product"/>
                        <input type="hidden" name="productID" value="<?php echo $product->getProductID(); ?>" />
                        <input type="hidden" name="categoryID" value="<?php echo $product->getCategory()->getCategoryID(); ?>" />
                        <button type="submit" class="delete-button">Delete Product</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
