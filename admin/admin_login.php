<?php
require("../database.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get username and password from the form
  $username = $_POST['username'];
  $password = $_POST['password'];

$queryUsers = 'SELECT * FROM users';
$statement1 = $db->prepare($queryUsers);
$statement->bindValue(':username', $username);
$statement1->execute();
$users = $statement1->fetchAll();
$statement1->closeCursor();

// Check if user exists
if ($user) {
  // Verify password (assuming passwords are hashed with password_hash)
  if (password_verify($password, $user['password'])) {
      // Check if the user is an admin
      if ($user['role'] === 'admin') {
          // Set session variables and redirect to the admin dashboard
          $_SESSION['user_id'] = $user['user_id'];
          $_SESSION['username'] = $user['username'];
          $_SESSION['role'] = $user['role'];
          header("Location: admin/admin_dashboard.php");
          exit();
      } else {
          // If the user is not an admin
          $error_message = "Access denied. You are not an admin.";
      }
  } else {
      // If the password is incorrect
      $error_message = "Invalid password. Please try again.";
  }
} else {
  // If the username is not found in the database
  $error_message = "Invalid username. Please try again.";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/app.css"/>
  <title>Admin Login - ShopEase</title>
</head>
<body>
  <main>
    <form action="admin/admin_login.php" method="POST">
      <h2>Admin Login</h2> <!-- Add this line -->
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>
      
      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>
      
      <input type="submit" value="Login">
    </form>

  </main>
</body>
</html>