<?php
session_start();
require_once '../../config/database.php';
// Ensure the user is an admin (validate against the admins table)
$admin_email = $_SESSION['user']['email'];
$stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
$stmt->bind_param("s", $admin_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header('Location: ../login.php');  // Redirect non-admins to login
    exit;
}

// Fetch logs from the database, ordering by `timestamp`
$stmt = $conn->prepare("SELECT admin_logs.*, users.name FROM admin_logs JOIN users ON admin_logs.user_id = users.id ORDER BY admin_logs.timestamp DESC");
$stmt->execute();
$logs = $stmt->get_result();
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
            <?php while ($row = $logs->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['action']) ?></td>
                    <td><?= htmlspecialchars($row['timestamp']) ?></td> <!-- Corrected to use `timestamp` -->
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
