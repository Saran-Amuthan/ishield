<?php
$db_host = 'localhost';  // Database host
$db_name = 'ishield';  // Database name
$db_user = 'root';  // Database username
$db_pass = '';  // Database password

// Create connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Protect against SQL injection
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Query to fetch user from database
    $sql = "SELECT * FROM register WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password']; // Retrieve the stored password

        // Verify password
        if ($password === $stored_password) {
            // Password is correct, start a new session
            session_start();
            $_SESSION['email'] = $email;
            // Redirect to your desired page after successful login
            header("Location: ../dashboard/index.html");
            exit;
        } else {
            // Password is incorrect
            echo "<script type='text/javascript'>alert('Invalid password!'); location='../sign_in.html';</script>";
        }
    } else {
        // No user found with that username
        echo "<script type='text/javascript'>alert('user not found!'); location='../sign_in.html';</script>";
    }
}

// Close the database connection
$conn->close();

?>

