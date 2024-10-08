<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php'); // Redirect to login if session is not set
    exit;
}

// Retrieve user details from the session
$name = htmlspecialchars($_SESSION['user']['name']);  // Sanitize for HTML output
$company = "Your Company";  // Replace with your actual company name

// Construct WhatsApp link with properly URL-encoded parameters
$whatsapp_link = "https://api.whatsapp.com/send?phone=+1234567890&text=" . 
    urlencode("Hello Mr $name,\n\nThis message is to inform you that you have been successfully added as a customer at $company.\nPlease verify your details:\nName: $name\n\nThanks and Regards,\nTeam $company");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
</head>
<body>
    <h1>Thank you for your submission!</h1>
    <p><a href="<?= $whatsapp_link ?>" target="_blank">Click here to message us on WhatsApp</a></p>
</body>
</html>
