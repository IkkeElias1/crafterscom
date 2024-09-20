<?php
session_start();

$admin_user = 'REDACTED'; // Set your admin username
$admin_password = 'REDACTED'; // Set your admin password

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == $admin_user && $password == $admin_password) {
        $_SESSION['loggedin'] = true;
        header("Location: /admin");
        exit;
    } else {
        $error = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
        <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    </form>
</body>
</html>
