<?php
// session_start();
// require("../database.php");

// // Ensure the user is an admin
// if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
//     header("Location: admin_login.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../css/admin.css">
    <style>
       
    </style>
</head>
<body>
<?php include("../../view/admin_sidebar.php"); ?>

    <div class="main-content">
    <h1>Welcome to the ShopEase Admin Dashboard</h1>
         <!-- Main Content Area -->
         <section class="main-content">
            
            <div class="admin-links">
    <div class="admin-section">
        <h2>Categories</h2>
        <a href="../categories/categories_form.php">Add / Edit Categories</a>
    </div>

    <div class="admin-section">
        <h2>Products</h2>
        <a href="../admin_products/index.php">Add / Edit Products</a>
    </div>

    <div class="admin-section">
        <h2>Orders</h2>
        <a href="manage_orders.php">View / Edit Orders</a>
    </div>

    <div class="admin-section">
        <h2>Customers</h2>
        <a href="manage_users.php">View / Edit Users</a>
    </div>

    <div class="admin-section">
        <h2>Manage Admin</h2>
        <a href="manage_admin.php">View / Edit Admins</a>
    </div>
</div>

            </div>
        </section>
    </div>

    <script>

    </script>
</body>
</html>
