<?php
// Connect to the database
if($_SERVER['REQUEST_METHOD']="POST"){
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expense";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert the transaction into the database
$name = $_POST['name'];
$amount = $_POST['amount'];
$type = $_POST['type'];
$date = date('Y-m-d');

$sql = "INSERT INTO money (name, amount, type, date) VALUES ('$name', '$amount', '$type', '$date')";

if ($conn->query($sql) === TRUE) {
    // Transaction added successfully

    // Calculate the updated balance based on the selected 'Type'
$balance = 0;
$income = 0;
$expense = 0;

// Retrieve balance
$sql = "SELECT SUM(CASE WHEN type = 'income' THEN amount ELSE -amount END) AS total FROM money";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $balance = $row['total'];
}

// Calculate income
$sql = "SELECT SUM(amount) AS total FROM money WHERE type = 'income'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $income = $row['total'];
}

// Calculate expense
$sql = "SELECT SUM(amount) AS total FROM money WHERE type = 'expense'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $expense = $row['total'];
}

// Echo JavaScript code to update the HTML elements
echo 'document.getElementById("balance").textContent = "$' . $balance . '";';
echo 'document.getElementById("money-plus").textContent = "+$' . $income . '";';
echo 'document.getElementById("money-minus").textContent = "-$' . $expense . '";';

} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

}
?>