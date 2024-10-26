<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../database.php');

// Get all categories
$queryCategories = 'SELECT * FROM categories ORDER BY categoryID';
$statementCategories = $db->prepare($queryCategories);
$statementCategories->execute();
$categories = $statementCategories->fetchAll();
$statementCategories->closeCursor();
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../css/products.css">

</head>
<body>
<?php include("../view/admin_sidebar.php"); ?>

<main>
    <h1>Add New Product</h1>

    <!-- Form for adding products -->
    <form action="../products/add_product.php" method="post" enctype="multipart/form-data" id="add_product_form">


        <!-- Category -->
        <label for="category">Category:</label>
        <select name="categoryID" id="category" required>
            <option value="">Select Category</option>
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['categoryID']; ?>">
                    <?php echo $category['categoryName']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Product Code -->
        <label for="productCode">Product Code:</label>
        <input type="text" name="productCode" id="productCode" >
        
        <!-- Product Name -->
        <label for="productName">Product Name:</label>
        <input type="text" name="productName" id="productName" >

        <!-- Description -->
        <label for="description">Description:</label>
        <textarea name="description" id="description" rows="3" ></textarea>

        <!-- Price -->
        <label for="listPrice">Price:</label>
        <input type="text" name="listPrice" id="listPrice" >

        <!-- Discount -->
        <label for="discountPercent">Discount Amount:</label>
        <input type="text" name="discountPercent" id="dicountPercent" >

        <!-- Stock -->
        <label for="stock">Stock Quantity:</label>
        <input type="number" name="stock" id="stock">

    
        <!-- Submit Button -->
        <input type="submit" value="Add Product">
    </form>
    

</main>

</body>
</html>
