<?php
$host = 'localhost';
$db = 'user_portal';
$user = 'root';
$pass = 'Ayush2296';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
