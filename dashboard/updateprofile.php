<?php
// Start or resume session
session_start();

// Check if user is logged in (you need to implement your own login check logic)
if (!isset($_SESSION['email'])) {
    // Redirect user to login page if not logged in
    header("Location: ../php/login.php");
    exit();
}

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ishield";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Escape and sanitize email (optional if you trust session data)
$email = $conn->real_escape_string($_SESSION['email']);

// Query to fetch user data based on email
$sql = "SELECT empid, emprole, email FROM register WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch data and assign to variables
    $row = $result->fetch_assoc();
    $empID = $row["empid"];
    $empRole = $row["emprole"];
    $email = $row["email"];
} else {
    // Handle case where no data found (optional)
    $empID = "N/A";
    $empRole = "N/A";
    $email = $_SESSION['email']; // Use session email as fallback
}

// Close statement and database connection
$stmt->close();
$conn->close();
?>
