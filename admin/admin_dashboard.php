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
    <title>Admin Dashboard - ShopEase</title>
    <link rel="stylesheet" href="../css/admin_dashborad.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="manage_products.php">Manage Products</a></li>
                    <li><a href="manage_orders.php">Manage Orders</a></li>
                    <li><a href="manage_users.php">Manage Users</a></li>
                    <li><a href="manage_reviews.php">Manage Reviews</a></li>
                    <li><a href="manage_shipping.php">Manage Shipping</a></li>
                    <li><a href="manage_payments.php">Manage Payments</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <section class="main-content">
            <h1>Welcome to the ShopEase Admin Dashboard</h1>
            <div class="admin-links">

                <div class="admin-section">
                    <h2>Prodcuts</h2>
                    <a href="products/manage_products.php">View / Edit Products</a>
                </div>

                <div class="admin-section">
                    <h2>Orders</h2>
                    <a href="manage_orders.php">View / Edit Orders</a>
                </div>

                <div class="admin-section">
                    <h2>Users</h2>
                    <a href="manage_users.php">View / Edit Users</a>
                </div>

                <div class="admin-section">
                    <h2>Reviews</h2>
                    <a href="manage_reviews.php">View / Edit Reviews</a>
                </div>

                <div class="admin-section">
                    <h2>Shipping Methods</h2>
                    <a href="manage_shipping.php">View / Edit Shipping Methods</a>
                </div>

                <div class="admin-section">
                    <h2>Payment Methods</h2>
                    <a href="manage_payments.php">View / Edit Payment Methods</a>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
