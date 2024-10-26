<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session only if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$dsn = 'mysql:host=localhost;dbname=ShopEase';
$username = 'root';
$password = '';

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable error reporting for exceptions
} catch (PDOException $e) {
    $_SESSION["database_error"] = $e->getMessage();
    $url = "database_error.php"; // Create a database error page if needed
    header("Location: " . $url);
    exit();
}
