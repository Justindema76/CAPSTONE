<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection and required models
require_once('../../database.php');
require_once('../../util/tags.php');
require_once('../../model/product_db.php');
require_once('../../model/category_db.php');
require_once('../../model/product.php');
require_once('../../model/category.php');

// Get the database connection
$db = Database::getDB();

// Fetch categories for the dropdown
$queryCategories = 'SELECT * FROM categories';
$statement = $db->prepare($queryCategories);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();

// Check if a category ID is selected
$categoryID = filter_input(INPUT_GET, 'categoryID', FILTER_VALIDATE_INT);

// Base query to fetch products, joining with categories
$queryProduct = 'SELECT p.*, c.categoryName FROM products p 
                 JOIN categories c ON p.categoryID = c.categoryID';

// Add a WHERE clause if a category ID is specified
if ($categoryID && $categoryID != 0) {
    $queryProduct .= ' WHERE p.categoryID = :categoryID';
}

// Prepare the statement
$statement = $db->prepare($queryProduct);

// Bind the category ID if provided
if ($categoryID && $categoryID != 0) {
    $statement->bindValue(':categoryID', $categoryID);
}

// Execute the query
$statement->execute();

// Fetch product data
$productData = $statement->fetchAll(PDO::FETCH_ASSOC);
$statement->closeCursor();

// Instantiate Product objects
$products = [];
foreach ($productData as $row) {
    $category = new Category($row['categoryID'], $row['categoryName']);
    $product = new Product(
        $category,
        $row['productCode'],
        $row['productName'],
        $row['description'],
        $row['listPrice'],
        $row['discountPercent'],
        $row['stock']
    );
    $product->setProductID($row['productID']);
    $products[] = $product;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="../../css/products.css">
</head>
<body>
<?php include("../../view/admin_sidebar.php"); ?>

<main>
    <h1>ShopEase - Manage Products</h1>
    <button class="add-product-button" onclick="window.location.href='../admin_products/add_product_form.php';">
        Add New Product
    </button>

    <!-- Category Selection -->
    <section>
        <h2>Select a Category</h2>
        <form action="" method="get">
            <select name="categoryID" id="category" required>
                <option value="">Select Category</option>
                <option value="0">All Products</option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo $category['categoryID']; ?>" 
                        <?php if ($categoryID == $category['categoryID']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($category['categoryName']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Filter</button>
        </form>
    </section>

    <!-- Products Table -->
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Discount Percent</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($products) > 0) : ?>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product->getCategory()->getCategoryName()); ?></td>
                        <td><?php echo htmlspecialchars($product->getProductCode()); ?></td>
                        <td><?php echo htmlspecialchars($product->getProductName()); ?></td>
                        <td><?php echo htmlspecialchars($product->getProductDescription()); ?></td>
                        <td><?php echo htmlspecialchars($product->getProductPriceFormatted()); ?></td>
                        <td><?php echo htmlspecialchars($product->getProductDiscountPercentFormatted()); ?></td>
                        <td><?php echo htmlspecialchars($product->getStock()); ?></td>
                        <td>
                            <!-- View Product Button -->
                            <form action="../admin_products/product_view.php" method="get" style="display:inline;">
                                <input type="hidden" name="productID" value="<?php echo $product->getProductID(); ?>">
                                <button type="submit" class="edit-button">View</button>
                            </form>
                        </td>  
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8">No products available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>
</body>
</html>
