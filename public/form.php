<?php
session_start();
require_once __DIR__ . '/../includes/db.php'; // Include database connection

// If the user is not logged in, redirect to login page
if (!isset($_SESSION['user'])) {
    header('Location: /public');
    exit;
}

// Always show the logout link and welcome message
?>
<p>Welcome, <?= htmlspecialchars($_SESSION['user']['name']) ?>! <a href="logout.php">Logout</a></p>

<?php
// Get the user's email from the session
$email = $_SESSION['user']['email'];

// Check if the user already exists in the 'customers' table
$stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // If the user exists, show the logout link, then redirect to the thank you page
    echo "<p>Redirecting to the Thank You page...</p>";
    header('Refresh: 3; URL=/public/thankyou.php'); // Redirect to /public/thankyou.php after 3 seconds
    exit;
}
?>

<!-- If the user does not exist in the 'customers' table, display the form -->
<form action="../includes/form-handler.php" method="POST">
    Name: <input type="text" name="name" value="<?= htmlspecialchars($_SESSION['user']['name']) ?>" required><br>
    Email: <input type="email" name="email" value="<?= htmlspecialchars($_SESSION['user']['email']) ?>" readonly><br>
    Phone: <input type="text" name="phone" required><br>
    Date of Birth: <input type="date" name="dob" required><br>
    <button type="submit">Submit</button>
</form>
