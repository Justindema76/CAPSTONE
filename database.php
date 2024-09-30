<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$dsn = 'mysql:host=localhost;dbname=ShopEase';
$username = 'root'; // Your MySQL username
$password = ''; // Your MySQL password

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable error reporting
} catch (PDOException $e) {
    $_SESSION["database_error"] = $e->getMessage();
    $url = "database_error.php"; // Create a database error page if needed
    header("Location: " . $url);
    exit();
}
?>
