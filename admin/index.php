<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Database connection
// Database connection
$servername = "REDACTED";
$username = "REDACTED";
$password = "REDACTED";
$dbname = "REDACTED";

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle the form submissions for donations
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['donation_submit'])) {
    $player_name = $_POST['player_name'];
    $amount = $_POST['amount'];

    $stmt = $pdo->prepare("INSERT INTO donations (player_name, amount) VALUES (?, ?)");
    $stmt->execute([$player_name, $amount]);

    echo "Donation successfully added!";
}

// Handle the form submissions for earnings
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['earnings_submit'])) {
    $player_name = $_POST['player_name'];
    $earnings = $_POST['earnings'];

    $stmt = $pdo->prepare("INSERT INTO earnings (player_name, earnings) VALUES (?, ?)");
    $stmt->execute([$player_name, $earnings]);

    echo "Earnings successfully added!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body>
    <h2>Admin Panel</h2>

    <!-- Form for Adding Donations -->
    <h3>Add Donation</h3>
    <form method="POST">
        <label>Player Name:</label>
        <input type="text" name="player_name" required><br><br>
        <label>Donation Amount:</label>
        <input type="number" step="0.01" name="amount" required><br><br>
        <button type="submit" name="donation_submit">Add Donation</button>
    </form>
    
    <!-- Display Donations Leaderboard -->
<h3>Donations Leaderboard</h3>
    <table>
        <tr>
            <th>Player Name</th>
            <th>Amount</th>
            <th>Timestamp</th>
        </tr>
    <?php
        $stmt = $pdo->query("SELECT * FROM donations ORDER BY amount DESC");
        while ($row = $stmt->fetch()) {
            echo "<tr><td>{$row['player_name']}</td><td>{$row['amount']}</td><td>{$row['timestamp']}</td></tr>";
        }
        ?>
    </table>

    <!-- Form for Adding Earnings -->
    <h3>Add Earnings</h3>
    <form method="POST">
        <label>Player Name:</label>
        <input type="text" name="player_name" required><br><br>
        <label>Earnings Amount:</label>
        <input type="number" step="0.01" name="earnings" required><br><br>
        <button type="submit" name="earnings_submit">Add Earnings</button>
    </form>

<!-- Display Earnings Leaderboard -->
<h3>Earnings Leaderboard</h3>
<table>
    <tr>
        <th>Player Name</th>
        <th>Earnings</th>
        <th>Timestamp</th>
    </tr>
    <?php
    $stmt = $pdo->query("SELECT * FROM earnings ORDER BY amount DESC");
    while ($row = $stmt->fetch()) {
        echo "<tr><td>{$row['player_name']}</td><td>{$row['earnings']}</td><td>{$row['timestamp']}</td></tr>";
    }
    ?>
</table>
    <a href="logout.php">Logout</a>
</body>
</html>
