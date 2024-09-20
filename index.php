<?php
// Database connection
$servername = "REDACTED";
$username = "REDACTED";
$password = "REDACTED";
$dbname = "REDACTED";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">

    <meta charset="UTF-8">
    <meta name="description" content="Uofficiel Community page til Crafters dk tilbudt af IkkeElias">
    <meta name="keywords" content="Crafters.dk, IkkeElias, Minecraft">
    <meta name="author" content="IkkeElias">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image" />

    <meta property="og:title" content="Crafters Community" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://com.ikkeelias.dk" />
    <meta property="og:image" content="http://com.ikkeelias.dk/favicon.ico" />
    <meta property="og:description" content="Uofficiel Community page til Crafters dk tilbudt af IkkeElias" />

</head>
<body>

<h1>Hello World</h1>
<p>En meget flot <b>§</b></p>


<div class="leaderboards">
    <div class="leaderboard">
<?php
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT player_name, SUM(amount) AS total_earnings FROM earnings GROUP BY player_name ORDER BY total_earnings DESC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
            echo "<h2>Earnings Leaderboard</h2>";
            echo "<ul>";
    while($row = $result->fetch_assoc()) {
            echo "<li>" . $row['player_name'] . " - " . $row['total_earnings'] . "</li>";
    }
        echo "</ul>";
} else {
        echo "<h2>Earnings Leaderboard</h2>";
        echo "No earnings yet!";
}

$conn->close();
?>
    </div>
    <div class="leaderboard">
<?php
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT player_name, SUM(amount) AS total_donation FROM donations GROUP BY player_name ORDER BY total_donation DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
        echo "<h2>Donation Leaderboard</h2>";
        echo "<ul>";
        while($row = $result->fetch_assoc()) {
            echo "<li>" . $row['player_name'] . " - " . $row['total_donation'] . "</li>";
        }
        echo "</ul>";
} else {
        echo "<h2>Earnings Leaderboard</h2>";
        echo "No donations yet!";
}

$conn->close();
?>
    </div>
</div>

</body>
</html>