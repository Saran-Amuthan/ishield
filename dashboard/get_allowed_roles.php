<?php
session_start(); // Ensure you start the session

// Database connection details
$db_host = 'localhost';
$db_name = 'ishield';
$db_user = 'root';
$db_pass = '';

// Create a connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the email is in the session
if (!isset($_SESSION['email'])) {
    die("No email found in session!");
}

$email = $_SESSION['email'];

// Fetch the user's role from the database
$sql = "SELECT EmpRole FROM register WHERE email = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare statement failed: " . $conn->error);
}

$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $currentUserRole = $row['EmpRole'];
} else {
    die("User role not found!");
}

$stmt->close();

// Define the role hierarchy
$roles = [
    'Bussiness_Development_Officer' => ['Sales_Manager'],
    'Sales_Manager' => ['Bussiness_Development_Officer'],
    'Regional_CoOrdinator' => ['Sales_Manager', 'Bussiness_Development_Officer'],
    'Zonal_Head' => ['Sales_Manager', 'Bussiness_Development_Officer', 'Regional_CoOrdinator'],
    'State_President' => ['Sales_Manager', 'Bussiness_Development_Officer', 'Regional_CoOrdinator', 'Zonal_Head']
];

// Determine allowed roles based on current user's role
$allowedRoles = $roles[$currentUserRole] ?? [];

// If the current user role is State_President, allow all roles
if ($currentUserRole === 'State_President') {
    $allowedRoles = array_keys($roles);
}

// Convert allowed roles to the format expected by the frontend
$response = array_map(function($role) {
    return ['value' => $role, 'text' => str_replace('_', ' ', $role)];
}, $allowedRoles);

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close the connection
$conn->close();
?>
