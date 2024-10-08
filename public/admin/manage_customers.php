<?php
session_start();
require_once '../../config/database.php';

// Pagination logic
$limit = 10; // Records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch customers from the database
$stmt = $conn->prepare("SELECT * FROM customers LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers</title>
</head>
<body>
    <h1>Customer List</h1>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Date of Birth</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['dob']) ?></td>
            <td>
                <a href="edit_customer.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete_customer.php?id=<?= $row['id'] ?>">Delete</a> |
                <a href="generate_pdf.php?id=<?= $row['id'] ?>">Generate PDF</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <!-- Pagination -->
    <a href="?page=<?= $page - 1 ?>">Previous</a>
    <a href="?page=<?= $page + 1 ?>">Next</a>
</body>
</html>
