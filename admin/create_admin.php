<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start(); // Keep this here
require("../database.php"); // Include your database connection

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $role = 'admin'; // Admin role

    // Insert admin user into the database
    $query = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
    $statement = $db->prepare($query);
    $statement->bindParam(':username', $username);
    $statement->bindParam(':password', $hashedPassword);
    $statement->bindParam(':role', $role);

    if ($statement->execute()) {
        echo "Admin user created successfully!";
    } else {
        $_SESSION["error"] = "Error creating admin user: " . $statement->errorInfo()[2];
        header("Location: admin/admin_setup.php");
        exit();
    }

    $statement->closeCursor();
}
?>
