<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
require_once('../../database.php');

// Get the product ID from the URL
$productID = filter_input(INPUT_GET, 'productID', FILTER_VALIDATE_INT);

// Fetch product details
if ($productID) {
    $queryProduct = 'SELECT p.*, c.categoryName FROM products p
                     JOIN categories c ON p.categoryID = c.categoryID
                     WHERE p.productID = :productID';
    $statement = $db->prepare($queryProduct);
    $statement->bindValue(':productID', $productID);
    $statement->execute();
    $product = $statement->fetch();
    $statement->closeCursor();
} else {
    // Handle case where productID is not valid
    // Redirect or display an error message
    header('Location: ../admin_products/manage_products.php'); // Redirect to manage products page
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['productName']; ?></title>
    <link rel="stylesheet" href="../../css/products.css"> <!-- Add your CSS file here -->
</head>
<body>
    <?php include("../../view/admin_sidebar.php"); ?>
    <main>
        <h1><?php echo $product['productName']; ?></h1>
        <div id="left_column">
            <p>
                <img src="<?php echo $product['imagePath']; ?>" alt="<?php echo $product['imageAltText']; ?>" />
            </p>
        </div>

        <div id="right_column">
            <p><strong>List Price:</strong> <?php echo '$' . number_format($product['listPrice'], 2); ?></p>
            <p><strong>Discount:</strong> <?php echo $product['discountPercent'] . '%'; ?></p>
            <p><strong>Your Price:</strong> <?php echo '$' . number_format($product['discountPercent'], 2); ?></p>
            <h2 class="no_bottom_margin">Description</h2>
            <?php echo ($product['description']); ?> <!-- Assuming this function is defined somewhere -->
   
        </div>

        <div>
             <form action="../admin_products/edit_product.php" method="get" style="display:inline;">
    <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>">
    <button type="submit" class="delete-button">Edit</button>

    <!-- Form for deleting a category -->
<form action="../products/delete_product.php" method="post" style="display:inline;">
                <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>">
                <input type="submit" class="delete-button" value="Delete">
            </form>
</form><br>
</div>
    </main>
</body>
</html>
