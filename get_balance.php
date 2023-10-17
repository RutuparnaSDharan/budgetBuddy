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

// Get balance, income, and expense from the database
$sql = "SELECT SUM(amount) AS balance, SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) AS income, SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) AS expense FROM transactions";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$balance = $row['balance'];
$income = $row['income'];
$expense = $row['expense'];

// Return the values as JSON
$data = array(
    'balance' => $balance,
    'income' => $income,
    'expense' => $expense
);
echo json_encode($data);

$conn->close();
?>
