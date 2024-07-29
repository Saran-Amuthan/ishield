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
// Get the role and inviter_id from the URL
$role = isset($_GET['role']) ? $_GET['role'] : null;
$inviter_id = isset($_GET['inviter_id']) ? $_GET['inviter_id'] : null;

// Validate and sanitize inputs
if (!in_array($role, ['Sales Manager', 'Business Development Officer', 'Regional Coordinator', 'Zonal Head', 'State President'])) {
    die('Invalid role.');
}
if (!filter_var($inviter_id, FILTER_VALIDATE_INT)) {
    die('Invalid inviter ID.');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        /* Add some basic styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .registration-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
        .registration-form h1 {
            margin-top: 0;
        }
        .registration-form label {
            display: block;
            margin-top: 10px;
        }
        .registration-form input {
            width: calc(100% - 22px);
            padding: 10px;
            margin-top: 5px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .registration-form button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .registration-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="registration-form">
        <h1>Register</h1>
        <form action="process_registration.php" method="post">
            <input type="hidden" name="EmpRole" value="<?php echo htmlspecialchars($EmpRole); ?>">
            <input type="hidden" name="inviter_id" value="<?php echo htmlspecialchars($inviter_id); ?>">
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="confirmpassword">confirmpassword:</label>
            <input type="confirmpassword" id="confirmpassword" name="confirmpassword" required>
            
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
