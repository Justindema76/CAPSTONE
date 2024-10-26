<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../../database.php');
// Get the database connection
$db = Database::getDB();

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
    <title>Manage Categories</title>
    <link rel="stylesheet" href="../../css/categories.css">
</head>
<body>
<?php include("../../view/admin_sidebar.php"); ?>
<main>
    <h1>ShopEase - Manage Categories</h1>

    <!-- Error message (if any) -->
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <br>


    <!-- Form to Add Category -->
    <form action="../categories/add_category.php" method="post" id="add_category_form">
        <label for="name">Add Category:</label>
        <input type="text" name="name" id="name" required />
        <input id="form_button" type="submit" value="Add" />
    </form>

    <!-- Category List -->
    <h1>Category List</h1>
    <table>
        <tr>
            
            <th>Department</th>
            <th>Category Name</th>
            <th></th>
        </tr>
        
        <!-- Display categories in the table -->
        <?php foreach ($categories as $category) : ?>
        <tr>
      
            <td><?php echo $category['categoryName']; ?></td>

            <td>
                <!-- Form for deleting a category -->
                <form action="../categories/delete_category.php" method="post" style="display:inline;">
                    <input type="hidden" name="categoryID" value="<?php echo $category['categoryID']; ?>">
                    <input type="submit" class="delete-button" value="Delete">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>    
    </table>
</main>
</body>
</html>
