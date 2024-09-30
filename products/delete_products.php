<?php
require("../database.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the product from the database
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);

    // Redirect back to manage products page
    header("Location: ../admin/manage_products.php");
    exit();
}
