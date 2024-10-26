<?php
session_start();
require("../database.php"); // Include your database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/app.css"/>
    <title>Create Admin User</title>
</head>
<body>
    
    <form action="admin/create_admin.php" method="POST">
    <h2>Create Admin User</h2>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <input type="submit" value="Create Admin">
    </form>

    <?php
    if (isset($_SESSION["error"])) {
        echo "<p style='color:red;'>" . $_SESSION["error"] . "</p>";
        unset($_SESSION["error"]);
    }
    ?>
</body>
</html>
