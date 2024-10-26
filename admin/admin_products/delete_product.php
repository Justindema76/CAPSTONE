<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get productID directly from the POST request; default to an empty string if not set
$productID = $_POST['productID'] ?? ''; 

// Validate inputs
if (empty($productID)) {
    $error = "Invalid Product ID.";
    include('../error.php'); // Display error page
    exit(); // Stop further execution
} else {
    // Include the database connection
    require_once('../database.php');

    try {
        // Prepare the SQL DELETE statement
        $query = 'DELETE FROM products WHERE productID = :productID';
        $statement = $db->prepare($query);
        
        // Bind the productID as a string
        $statement->bindValue(':productID', $productID, PDO::PARAM_STR);
        
        // Execute the statement
        $statement->execute();
        
        // Close the cursor
        $statement->closeCursor();
        
        // Redirect to the Product List page or include the products form
        include('../products/products_form.php');
    } catch (PDOException $e) {
        // Handle potential database errors
        $error = "Database error: " . $e->getMessage();
        include('../error.php'); // Display error page
    }
}
?>
