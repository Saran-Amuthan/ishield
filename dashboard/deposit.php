<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../sign_in.html");
    exit();
}

// Database connection
$db_host = 'localhost';
$db_name = 'ishield';
$db_user = 'root';
$db_pass = '';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    
    // Update the balance in the register table
    $sql = "UPDATE register SET balance = balance + ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare statement failed: " . $conn->error);
    }
    $stmt->bind_param('ds', $amount, $email);
    if ($stmt->execute()) {
        header("Location: wallet.php");
    } else {
        echo "Error updating balance: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>
