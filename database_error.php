<?php
session_start();
if (isset($_SESSION["database_error"])) {
    $error_message = $_SESSION["database_error"];
} else {
    $error_message = "Unknown error.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Error</title>
</head>
<body>
    <h1>Database Connection Error</h1>
    <p>Sorry, we are unable to connect to the database at this time. Please try again later.</p>
    <p>Error details: <?= htmlspecialchars($error_message); ?></p>
</body>
</html>
