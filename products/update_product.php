<?php
require("../database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['update'];
    $name = $_POST['name'][$id];
    $description = $_POST['description'][$id];
    $price = $_POST['price'][$id];
    $stock = $_POST['stock'][$id];
    $image = $_FILES['image'][$id]['name'];

    // If a new image is uploaded, handle the file upload
    if ($image) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['image'][$id]['tmp_name'], $target_file);

        // Update product with new image
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ?, image = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $stock, $image, $id]);
    } else {
        // Update product without changing image
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ? WHERE id = ?");
        $stmt->execute([$name, $description, $price, $stock, $id]);
    }

    // Redirect back to manage products page
    header("Location: ../admin/manage_products.php");
    exit();
}
