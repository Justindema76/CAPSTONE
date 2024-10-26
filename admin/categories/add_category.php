<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
require_once('../../database.php');  // Make sure this path is correct

// Get the database connection
$db = Database::getDB();

// Now $db is properly initialized and you can run your queries
$name = filter_input(INPUT_POST, 'name');

// Validate inputs
if (empty($name)) {
    // Handle the error
    $error = "Invalid category data. Please check the field and try again.";
    include('../categories/categories_form.php');
    exit();
} else {
    // Check if the category already exists
    $query = 'SELECT COUNT(*) FROM categories WHERE categoryName = :categoryName';
    $statement = $db->prepare($query);  // $db is now properly initialized
    $statement->bindValue(':categoryName', $name);
    $statement->execute();
    $count = $statement->fetchColumn();
    $statement->closeCursor();

    if ($count > 0) {
        // Error if category already exists
        $error = "The category already exists. Please enter a different name.";
        include('../categories/categories_form.php');
    } else {
        // Insert new category
        $query = 'INSERT INTO categories (categoryName) VALUES (:categoryName)';
        $statement = $db->prepare($query);
        $statement->bindValue(':categoryName', $name);
        $statement->execute();
        $statement->closeCursor();

        // Redirect to reload the category list
        header("Location: ../categories/categories_form.php");
        exit();
    }
}
