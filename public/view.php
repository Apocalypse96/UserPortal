<?php
require_once '../includes/db.php';

$result = $conn->query("SELECT * FROM customers");

while ($row = $result->fetch_assoc()) {
    echo "Name: " . $row['name'] . "<br>";
    echo "Email: " . $row['email'] . "<br>";
    echo "Phone: " . $row['phone'] . "<br>";
    echo "DOB: " . $row['dob'] . "<br>";
    echo "<a href='edit.php?id=" . $row['id'] . "'>Edit</a> | ";
    echo "<a href='delete.php?id=" . $row['id'] . "'>Delete</a><br><br>";
}
?>
