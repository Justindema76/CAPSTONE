<?php
// session_start();
// require("../database.php");

// // Ensure the user is an admin
// if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
//     header("Location: admin/admin_login.php");
//     exit();
// }

// // Fetch all products from the database
// $stmt = $pdo->query("SELECT * FROM products");
// $products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="../css/manage_products.css">
</head>
<body>
    <h1>Manage Products</h1>
    


    <!-- Manage Existing Products -->
    <h2>Existing Products</h2>
    <form action="products/update_product.php" class="top-bar" method="POST" enctype="multipart/form-data">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td>
                            <input type="text" name="name[<?= $product['id'] ?>]" value="<?= $product['name'] ?>" required>
                        </td>
                        <td>
                            <textarea name="description[<?= $product['id'] ?>]" required><?= $product['description'] ?></textarea>
                        </td>
                        <td>
                            <input type="number" name="price[<?= $product['id'] ?>]" step="0.01" value="<?= $product['price'] ?>" required>
                        </td>
                        <td>
                            <input type="number" name="stock[<?= $product['id'] ?>]" value="<?= $product['stock'] ?>" required>
                        </td>
                        <td>
                            <img src="../uploads/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" style="width: 50px;">
                            <input type="file" name="image[<?= $product['id'] ?>]">
                        </td>
                        <td>
                            <button type="submit" name="update" value="<?= $product['id'] ?>">Update</button>
                            <a href="products/delete_product.php?id=<?= $product['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </form>
        <!-- Add New Product Form -->
        <h2>Add New Product</h2>
        <div class="product-form">
    <form action="products/add_product.php" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <label for="description">Description:</label>
        <textarea name="description" required></textarea>
        <label for="price">Price:</label>
        <input type="number" name="price" step="0.01" required>
        <label for="stock">Stock:</label>
        <input type="number" name="stock" required>
        <label for="image">Image:</label>
        <input type="file" name="image" required>
        <button type="submit">Add Product</button>
    </form>
    
  </div>
</body>
</html>