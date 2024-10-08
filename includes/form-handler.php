<?php
require_once __DIR__ . '/db.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $name = trim($_POST['name']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST['phone']);
    $dob = trim($_POST['dob']);

    // Ensure valid email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Ensure no duplicate email exists
    $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If the email already exists, log the "Duplicate Customer" action
        $user_id = $_SESSION['user']['id'];
        $action = "Attempted to add duplicate customer";
        $log_stmt = $conn->prepare("INSERT INTO admin_logs (user_id, action) VALUES (?, ?)");
        $log_stmt->bind_param("is", $user_id, $action);
        $log_stmt->execute();

        // Redirect to the thank you page
        header('Location: /public/thankyou.php');
        exit;
    } else {
        // Insert customer data into the database
        $stmt = $conn->prepare("INSERT INTO customers (name, email, phone, dob) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $dob);

        if ($stmt->execute()) {
            // Log the "New Customer Added" action
            $user_id = $_SESSION['user']['id'];
            $action = "New customer added: $name";

            $log_stmt = $conn->prepare("INSERT INTO admin_logs (user_id, action) VALUES (?, ?)");
            $log_stmt->bind_param("is", $user_id, $action);
            $log_stmt->execute();

            // Redirect to the Thank You page
            header("Location: /public/thankyou.php");
            exit();
        } else {
            // Handle customer insertion error
            echo "Error adding customer.";
            exit();
        }
    }
}
?>
