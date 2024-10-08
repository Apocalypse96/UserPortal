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

// Fetch the customer details
$stmt = $conn->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$customer = $stmt->get_result()->fetch_assoc();

// Handle form submission for updating customer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];

    // Update the customer details in the database
    $update_stmt = $conn->prepare("UPDATE customers SET name = ?, email = ?, phone = ?, dob = ? WHERE id = ?");
    $update_stmt->bind_param("ssssi", $name, $email, $phone, $dob, $customer_id);
    if ($update_stmt->execute()) {
        echo "Customer details updated successfully.";
        header('Location: manage_customers.php');
        exit;
    } else {
        echo "Error updating customer.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
</head>
<body>
    <h1>Edit Customer</h1>
    <form method="POST">
        Name: <input type="text" name="name" value="<?= htmlspecialchars($customer['name']) ?>" required><br>
        Email: <input type="email" name="email" value="<?= htmlspecialchars($customer['email']) ?>" required><br>
        Phone: <input type="text" name="phone" value="<?= htmlspecialchars($customer['phone']) ?>" required><br>
        Date of Birth: <input type="date" name="dob" value="<?= htmlspecialchars($customer['dob']) ?>" required><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
