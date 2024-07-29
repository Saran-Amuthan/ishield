<?php
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
session_start(); // Start session to access user data

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = $_SESSION['user_id']; // Get the logged-in user ID from session

    // Fetch the user's role from the register table
    $stmt = $conn->prepare("SELECT EmpRole FROM register WHERE empid = ?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->bind_result($userRole);
    $stmt->fetch();
    $stmt->close();

    // Determine allowed roles based on the user's role
    $allowedRoles = [];
    switch ($userRole) {
        case 'Sales_Manager':
            $allowedRoles = ['Bussiness_Development_Officer'];
            break;
        case 'Regional_CoOrdinator':
            $allowedRoles = ['Sales_Manager', 'Bussiness_Development_Officer'];
            break;
        case 'Zonal_Head':
            $allowedRoles = ['Sales_Manager', 'Bussiness_Development_Officer', 'Regional_CoOrdinator'];
            break;
        case 'State_President':
            $allowedRoles = ['Sales_Manager', 'Bussiness_Development_Officer', 'Regional_CoOrdinator', 'Zonal_Head'];
            break;
        // Add more roles and their allowed roles as needed
    }

    echo json_encode($allowedRoles);
}
?>
