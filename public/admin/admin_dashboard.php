<?php
session_start();
require_once '../../config/database.php';

// Ensure the user is an admin (optional)
$admin_email = $_SESSION['user']['email'];
$stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
$stmt->bind_param("s", $admin_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header('Location: login.php');  // If not an admin, redirect to login
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <p>Welcome, <?= htmlspecialchars($_SESSION['user']['name']) ?>! <a href="/public/logout.php">Logout</a></p>
</head>
<body>
    <h1>Admin Dashboard</h1>
    
    <a href="manage_customers.php">Manage Customers</a><br>
    <a href="view_logs.php">View Admin Logs</a><br>
</body>
</html>
