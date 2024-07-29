<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables and initialize with empty values
    $email = $password = $confirm_password = "";
    
    // Processing form data when form is submitted
    $email = trim($_POST["email"]);
    $password = trim($_POST["psw"]);
    $confirm_password = trim($_POST["psw-repeat"]);
    
    // Validate email
    if (empty($email)) {
        $email_err = "Please enter an email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
    }
    
    // Validate password
    if (empty($password)) {
        $password_err = "Please enter a password.";     
    } elseif (strlen($password) < 6) {
        $password_err = "Password must have at least 6 characters.";
    }
    
    // Validate confirm password
    if (empty($confirm_password)) {
        $confirm_password_err = "Please confirm password.";     
    } elseif ($password != $confirm_password) {
        $confirm_password_err = "Passwords did not match.";
    }
    
    // If no errors, proceed with further processing
    if (empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        // Perform necessary actions (e.g., store data in database, redirect user, etc.)
        
        // For demonstration purposes, echo success message
        echo "Registration successful!";
        
        // You can redirect to another page after successful registration if needed
        // header("location: welcome.php");
        // exit();
    }
}
?>
