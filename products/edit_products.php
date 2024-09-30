<?php
session_start();
require("../database.php");

// Ensure the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Handle image upload
    if ($_FILES['image']['name']) {
        $image = $_FILES['image']['name'];
        $target = "../uploads/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = $product['image'];
    }

    // Update product in database
    $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ?, image = ? WHERE id = ?");
    $stmt->execute([$name, $description, $price, $stock, $image, $id]);

    header("Location: manage_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../css/admin_dashboard.css">
</head>
<body>
    <h1>Edit Product</h1>
    <form action="edit_product.php?id=<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
        <label for="name">Product Name</label>
        <input type="text" id="name" name="name" value="<?= $product['name'] ?>" required>

        <label for="description">Product Description</label>
        <textarea id="description" name="description" required><?= $product['description'] ?></textarea>

        <label for="price">Price</label>
        <input type="text" id="price" name="price" value="<?= $product['price'] ?>" required>

        <label for="stock">Stock</label>
        <input type="number" id="stock" name="stock" value="<?= $product['stock'] ?>" required>

        <label for="image">Product Image</label>
        <input type="file" id="image" name="image">
        <img src="../uploads/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" width="100">

        <button type="submit">Update Product</button>
    </form>
</body>
</html>
