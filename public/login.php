<?php
require_once '../config/oauth.php';
require_once '../includes/db.php';

session_start();

// Check if there's an OAuth code in the URL
if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // Get user profile info from Google
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email = $google_account_info->email;
    $name = $google_account_info->name;
    $google_id = $google_account_info->id;

    // Check if user exists in the users table
    $stmt = $conn->prepare("SELECT * FROM users WHERE google_id = ?");
    $stmt->bind_param("s", $google_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, log them in
        $_SESSION['user'] = $result->fetch_assoc();

        // Log the login action
        $user_id = $_SESSION['user']['id'];
        $action = "User Login";
        $log_stmt = $conn->prepare("INSERT INTO admin_logs (user_id, action) VALUES (?, ?)");
        $log_stmt->bind_param("is", $user_id, $action);
        $log_stmt->execute();

        // Check if the logged-in user is an admin
        $admin_stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
        $admin_stmt->bind_param("s", $email);
        $admin_stmt->execute();
        $admin_result = $admin_stmt->get_result();

        if ($admin_result->num_rows > 0) {
            // Redirect to the admin dashboard if the user is an admin
            header('Location: /public/admin/admin_dashboard.php');
        } else {
            // Redirect to the normal user flow (form page)
            header('Location: form.php');
        }
        exit;
    } else {
        // New user, insert into the database
        $stmt = $conn->prepare("INSERT INTO users (name, email, google_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $google_id);
        $stmt->execute();

        $user_id = $conn->insert_id;

        // Set session for the new user
        $_SESSION['user'] = [
            'id' => $user_id,
            'name' => $name,
            'email' => $email
        ];

        // Log the signup action
        $action = "New User Signup";
        $log_stmt = $conn->prepare("INSERT INTO admin_logs (user_id, action) VALUES (?, ?)");
        $log_stmt->bind_param("is", $user_id, $action);
        $log_stmt->execute();

        // Check if the new user is an admin
        $admin_stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
        $admin_stmt->bind_param("s", $email);
        $admin_stmt->execute();
        $admin_result = $admin_stmt->get_result();

        if ($admin_result->num_rows > 0) {
            // Redirect to the admin dashboard if the new user is an admin
            header('Location: /public/admin/admin_dashboard.php');
        } else {
            // Redirect to the normal user flow (form page)
            header('Location: form.php');
        }
        exit;
    }
} else {
    // Force Google to prompt for account selection when logging in again
    $client->setPrompt('select_account');  // Forces account selection
    $auth_url = $client->createAuthUrl();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login with Google</h1>
    <a href="<?= htmlspecialchars($auth_url) ?>">Login with Google</a>
</body>
</html>
