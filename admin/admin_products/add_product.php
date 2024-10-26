<?php

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
require("../database.php"); // Ensure this file correctly establishes a $pdo connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $categoryID = isset($_POST['categoryID']) ? $_POST['categoryID'] : null;
    $productCode = isset($_POST['productCode']) ? $_POST['productCode'] : null;
    $productName = isset($_POST['productName']) ? trim($_POST['productName']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $listPrice = isset($_POST['listPrice']) ? floatval($_POST['listPrice']) : 0.0;
    $discountPercent = isset($_POST['discountPercent']) ? floatval($_POST['discountPercent']) : 0.0;
    $stock = isset($_POST['stock']) ? intval($_POST['stock']) : 0;

    // Insert product into the database (without image)
    $query = 'INSERT INTO products
                 (categoryID, productCode, productName, description, listPrice, discountPercent, stock)
              VALUES
                 (:categoryID, :productCode, :productName, :description, :listPrice, :discountPercent, :stock)';
    $statement = $db->prepare($query);
    $statement->bindValue(':categoryID', $categoryID);
    $statement->bindValue(':productCode', $productCode);
    $statement->bindValue(':productName', $productName);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':listPrice', $listPrice);
    $statement->bindValue(':discountPercent', $discountPercent);
    $statement->bindValue(':stock', $stock);
    $statement->execute();
    $statement->closeCursor();

    // Redirect back to the manage products page
    header("Location: ../products/products_form.php");
    exit();
}
