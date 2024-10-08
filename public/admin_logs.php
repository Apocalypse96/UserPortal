<?php
session_start();
require_once '../../config/database.php';
// Check if the user is an admin (optional, add your own admin validation logic)
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

// Fetch logs from the database
$stmt = $conn->prepare("SELECT admin_logs.*, users.name FROM admin_logs JOIN users ON admin_logs.user_id = users.id ORDER BY admin_logs.created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Logs</title>
</head>
<body>
    <h1>Admin Logs</h1>
    <table border="1">
        <thead>
            <tr>
                <th>User</th>
                <th>Action</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['action']) ?></td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
