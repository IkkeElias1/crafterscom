<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Database connection
$host = 'REDACTED'; // Database host
$db = 'REDACTED'; // Database name
$user = 'REDACTED'; // Database username
$pass = 'REDACTED'; // Database password

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
    $amount = $_POST['amount']; // Use 'amount' column

    $stmt = $pdo->prepare("INSERT INTO earnings (player_name, amount) VALUES (?, ?)"); // Use 'amount' column
    $stmt->execute([$player_name, $amount]);

    echo "Earnings successfully added!";
}

// Handle deletion for donations
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_donation'])) {
    $id = $_POST['id'];

    $stmt = $pdo->prepare("DELETE FROM donations WHERE id = ?");
    $stmt->execute([$id]);

    echo "Donation successfully deleted!";
}

// Handle deletion for earnings
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_earnings'])) {
    $id = $_POST['id'];

    $stmt = $pdo->prepare("DELETE FROM earnings WHERE id = ?");
    $stmt->execute([$id]);

    echo "Earnings successfully deleted!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="adminstyle.css">
</head>
<body>
    <div class="boasned" style="display: inline-block;">
        <h2 style="text-align: left;">Admin Panel</h2>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <div class="postpanelsss">
    <!-- Form for Adding Donations -->
    <div class="postpanel">
    <h3>Add Donation</h3>
    <form method="POST">
        <label>Player Name:</label>
        <input type="text" name="player_name" required><br><br>
        <label>Donation Amount:</label>
        <input type="number" step="0.01" name="amount" required><br><br>
        <button type="submit" name="donation_submit">Add Donation</button>
    </form>
    </div>
        <!-- Form for Adding Earnings -->
         <div class="postpanel">
        <h3>Add Earnings</h3>
    <form method="POST">
        <label>Player Name:</label>
        <input type="text" name="player_name" required><br><br>
        <label>Earnings Amount:</label>
        <input type="number" step="0.01" name="amount" required><br><br> <!-- Changed input name to 'amount' -->
        <button type="submit" name="earnings_submit">Add Earnings</button>
    </form>
    </div>
    </div>

    <!-- Display Donations Leaderboard -->
    <h3>Donations Leaderboard</h3>
    <table>
        <tr>
            <th>Player Name</th>
            <th>Amount</th>
            <th>Timestamp</th>
            <th>Action</th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT * FROM donations ORDER BY amount DESC");
        while ($row = $stmt->fetch()) {
            echo "<tr>
                    <td>{$row['player_name']}</td>
                    <td>{$row['amount']}</td>
                    <td>{$row['timestamp']}</td>
                    <td>
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <button type='submit' name='delete_donation'>Delete</button>
                        </form>
                    </td>
                  </tr>";
        }
        ?>
    </table>

    <!-- Display Earnings Leaderboard -->
    <h3>Earnings Leaderboard</h3>
    <table>
        <tr>
            <th>Player Name</th>
            <th>Amount</th> <!-- Changed column name to 'amount' -->
            <th>Timestamp</th>
            <th>Action</th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT * FROM earnings ORDER BY amount DESC"); // Use 'amount' column
        while ($row = $stmt->fetch()) {
            echo "<tr>
                    <td>{$row['player_name']}</td>
                    <td>{$row['amount']}</td> <!-- Use 'amount' column -->
                    <td>{$row['timestamp']}</td>
                    <td>
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <button type='submit' name='delete_earnings'>Delete</button>
                        </form>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
