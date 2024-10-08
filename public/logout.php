<?php
session_start();
require_once '../config/oauth.php'; // Include OAuth configuration

// If there's an active Google session, revoke the token
if (isset($_SESSION['user'])) {
    // Revoke the OAuth token to disconnect the user from your app
    $client->revokeToken(); // This invalidates the token used for your app
}

// Destroy the session (this logs the user out from your app)
session_destroy();

// Redirect the user back to the login page
header('Location: login.php');
exit();
?>
