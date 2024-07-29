<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "ishield";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate employee ID
function generateEmpId($conn) {
    $prefix = "IS";
    $unique = false;
    $empid = '';

    // Fetch the latest empid from the database to determine the next sequential number
    $query = "SELECT MAX(RIGHT(empid, 4)) AS max_empid FROM register WHERE empid LIKE 'IS%'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $max_empid = $row['max_empid'];

    // Increment the last sequential number
    $next_number = ($max_empid !== null) ? intval($max_empid) + 1 : 1;
    $padded_number = str_pad($next_number, 4, '0', STR_PAD_LEFT); // Pad with leading zeros if necessary

    // Generate the new empid
    $empid = $prefix . $padded_number;

    return $empid;
}

// Get and sanitize inputs
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmpassword = $_POST['confirmpassword'];
$EmpRole = $_POST['EmpRole'];
$inviter_id = $_POST['inviter_id'];

// Validate inputs
if ($password !== $confirmpassword) {
    die('Passwords do not match.');
}

// Generate a new employee ID
$empid = generateEmpId($conn);

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO register (empid, username, email, password, EmpRole, inviter_id) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssi", $empid, $username, $email, $password, $EmpRole, $inviter_id);

if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
