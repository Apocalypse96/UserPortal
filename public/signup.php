<?php
require_once '../includes/oauth.php';
require_once '../includes/db.php';

session_start();

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // Get user profile info from Google
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email = $google_account_info->email;
    $name = $google_account_info->name;
    $google_id = $google_account_info->id;

    // Check if user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE google_id = ?");
    $stmt->bind_param("s", $google_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, log them in
        $_SESSION['user'] = $result->fetch_assoc();
        header('Location: form.php');
    } else {
        // New user, insert into database
        $stmt = $conn->prepare("INSERT INTO users (name, email, google_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $google_id);
        $stmt->execute();

        $_SESSION['user'] = [
            'id' => $conn->insert_id,
            'name' => $name,
            'email' => $email
        ];
        header('Location: form.php');
    }
}
?>
