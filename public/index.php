<?php
session_start();
require_once '../config/oauth.php'; // OAuth configuration
require_once '../includes/db.php';  // Database connection

// If the user is logged in (session exists), check if they're an admin or a customer
if (isset($_SESSION['user'])) {
    $email = $_SESSION['user']['email'];

    // Check if the user is an admin
    $admin_stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
    $admin_stmt->bind_param("s", $email);
    $admin_stmt->execute();
    $admin_result = $admin_stmt->get_result();

    if ($admin_result->num_rows > 0) {
        // If the user is an admin, redirect to the admin dashboard
        header('Location: /admin/admin_dashboard.php');
        exit;
    } else {
        // Check if the user already exists in the 'customers' table
        $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // If the user exists in the database, show the logout and continue options
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Welcome Back</title>
                <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
                <link href="/public/css/custom.css" rel="stylesheet">
            </head>
            <body>
                <div class="container mt-5">
                    <div class="card p-4 shadow-sm">
                        <h1 class="text-center">Welcome, <?= htmlspecialchars($_SESSION['user']['name']) ?>!</h1>
                        <p class="text-center">You are already a registered customer.</p>
                        <div class="text-center">
                            <!-- Show logout and continue options -->
                            <a href="/public/logout.php" class="btn btn-danger">Logout</a> <!-- Logout button -->
                            <form action="/public/thankyou.php" method="get" style="display: inline;">
                                <button type="submit" class="btn btn-primary ms-2">Continue</button> <!-- Continue to Thank You page -->
                            </form>
                        </div>
                    </div>
                </div>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
            </body>
            </html>
            <?php
            exit; // Stop further execution
        } else {
            // If the user is not a customer yet, send them to the form
            header('Location: form.php');
            exit;
        }
    }
}

// If not logged in, create the Google OAuth URL for sign-up/login
$auth_url = $client->createAuthUrl();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Portal</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/css/custom.css" rel="stylesheet"> <!-- Optional custom styles -->
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-5 shadow-lg" style="max-width: 400px; width: 100%;">
            <h1 class="text-center">Welcome to the User Portal</h1>
            <a href="<?= $auth_url ?>" class="btn btn-danger btn-lg w-100 mt-3">Sign up / Log in with Gmail</a>
        </div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
