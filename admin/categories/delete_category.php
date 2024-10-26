<?php

// Get ID
$categoryID = filter_input(INPUT_POST, 'categoryID', FILTER_VALIDATE_INT);

// Validate inputs
if ($categoryID == NULL || $categoryID == FALSE) {
    $error = "Invalid category ID.";
    include('../error.php');
} else {
    require_once('../../database.php');

// Get the database connection
$db = Database::getDB();

    // Add the product to the database  
    $query = 'DELETE FROM categories 
              WHERE categoryID = :categoryID';
    $statement = $db->prepare($query);
    $statement->bindValue(':categoryID', $categoryID);
    $statement->execute();
    $statement->closeCursor();

    // Display the Category List page
    include('../categories/categories_form.php');
}
?>