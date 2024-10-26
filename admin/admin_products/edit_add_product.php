<?php
// Display errors for debugging
// At the beginning of the file
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary classes
require_once('../../database.php');
require_once('../../model/product.php');
require_once('../../model/category.php');
require_once('../../model/product_db.php');
require_once('../../model/category_db.php');

// Validate product ID from URL
$productID = filter_input(INPUT_GET, 'productID', FILTER_VALIDATE_INT);
if (!$productID) {
    die('No product ID specified or invalid product ID.'); // Stop execution if no valid product ID is provided
}

try {
    // Fetch product by ID
    $product = ProductDB::getProduct($productID); 
    if (!$product) {
        die('Product not found.'); // Handle missing product gracefully
    }

    // Get the category ID from the product
    $categoryID = $product->getCategoryID(); // Ensure your Product class has a method for category ID
    $category = CategoryDB::getCategory($categoryID);
    if (!$category) {
        die('Category not found for this product.'); // Handle missing category gracefully
    }

    // Populate other product variables...
    $heading_text = 'Edit Product';
    $action = 'update_product';

    // Additional code...
    
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}


// Get the database connection
$db = Database::getDB();

// Fetch categories for the dropdown
$query = 'SELECT categoryID, categoryName FROM categories ORDER BY categoryName';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);
$statement->closeCursor();

// Get the productID from the URL
$productID = filter_input(INPUT_GET, 'productID', FILTER_VALIDATE_INT);
if ($productID) {
    // Fetch product by ID
    $product = ProductDB::getProduct($productID); 
    if (!$product) {
        die('Product not found.'); // Handle missing product gracefully
    }

    // Populate variables from the product object
    $heading_text = 'Edit Product';
    $action = 'update_product';
    
    $categoryName = htmlspecialchars($product->getCategory()->getCategoryName()); // Fetch category name
    $productCode = htmlspecialchars($product->getProductCode());
    $productName = htmlspecialchars($product->getProductName());
    $listPrice = $product->getProductPriceFormatted(); // Formatted price
    $discountPercent = $product->getProductDiscountPercentFormatted(); // Formatted discount percent
    $description = htmlspecialchars($product->getDescription());
    $stock = $product->getStock(); // Get stock quantity

    // Calculate the discounted price
    $discountedPrice = $product->getProductDiscountPriceFormatted();
    $savingsFormatted = $product->getProductDiscountAmountFormatted();
} else {
    die('No product ID specified.'); // Stop execution if no product ID is provided
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
        <section>
            <h1>Product Manager - <?php echo $heading_text; ?></h1>
            <form action="index.php" method="post" id="edit_add_product_form">
                <input type="hidden" name="action" value="<?php echo $action; ?>" />
                <input type="hidden" name="categoryID" value="<?php echo $categoryID; ?>" />
                <input type="hidden" name="productID" value="<?php echo $productID; ?>" />

                <label>Category:</label>
                <select name="categoryID" id="category" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo htmlspecialchars($category['categoryID']); ?>"
                            <?php if (isset($categoryID) && $category['categoryID'] == $categoryID) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($category['categoryName']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>Code:</label>
                <input type="text" name="productCode" value="<?php echo $productCode; ?>"><br>

                <label>Name:</label>
                <input type="text" name="productName" value="<?php echo $productName; ?>"><br>

                <label>List Price:</label>
                <input type="text" name="listPrice" value="<?php echo $listPrice; ?>" readonly><br>

                <label>Discount Percent:</label>
                <input type="text" name="discountPercent" value="<?php echo $discountPercent; ?>" readonly><br>

                <label>Description:</label>
                <textarea name="description" rows="10"><?php echo $description; ?></textarea><br>

                <label>Stock:</label>
                <input type="number" name="stock" value="<?php echo $stock; ?>" min="0"><br>

                <label>Your Price:</label>
                <input type="text" value="$<?php echo $discountedPrice; ?> (You save $<?php echo $savingsFormatted; ?>)" disabled><br>

                <label>&nbsp;</label>
                <input type="submit" value="Submit">
            </form>
    
            <div id="formatting_directions">
                <h2>How to format the Description entry</h2>
                <ul>
                    <li>Use two returns to start a new paragraph.</li>
                    <li>Use an asterisk to mark items in a bulleted list.</li>
                    <li>Use one return between items in a bulleted list.</li>
                    <li>Use standard HTML tags for bold and italics.</li>
                </ul>
            </div>
        </section>
    </main>
</body>
</html>
