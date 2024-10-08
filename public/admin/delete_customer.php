<?php
session_start();
require_once '../../config/database.php';

// Ensure the user is an admin (validate against the admins table)
$admin_email = $_SESSION['user']['email'];
$stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
$stmt->bind_param("s", $admin_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header('Location: ../login.php');  // Redirect non-admins to login
    exit;
}

// Get the customer ID from the URL
$customer_id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$customer_id) {
    echo "Invalid customer ID.";
    exit;
}

// Handle deletion confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete the customer
    $delete_stmt = $conn->prepare("DELETE FROM customers WHERE id = ?");
    $delete_stmt->bind_param("i", $customer_id);

    if ($delete_stmt->execute()) {
        echo "Customer deleted successfully.";
        header('Location: manage_customers.php');
        exit;
    } else {
        echo "Error deleting customer.";
    }
}

// Fetch the customer details to confirm deletion
$stmt = $conn->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$customer = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Customer</title>
</head>
<body>
    <h1>Delete Customer</h1>
    <p>Are you sure you want to delete <?= htmlspecialchars($customer['name']) ?>?</p>
    <form method="POST">
        <button type="submit">Yes, Delete</button>
        <a href="manage_customers.php">Cancel</a>
    </form>
</body>
</html>
