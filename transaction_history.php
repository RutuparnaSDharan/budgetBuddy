<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expense";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch transaction history from the database
$sql = "SELECT name, amount FROM money ORDER BY date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $transactions = [];
    while ($row = $result->fetch_assoc()) {
        $transactions[] = $row;
    }

    // Return the transaction history as JSON
    echo json_encode($transactions);
} else {
    // Handle the case where there are no transactions
    echo json_encode([]);
}

$conn->close();
?>
