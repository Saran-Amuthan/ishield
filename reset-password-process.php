<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $token = clean_input($_POST["token"]);
    $new_password = clean_input($_POST["new-password"]);

    // Example: Update user's password in your database (not implemented here)
    // Replace with your own update logic
    // Example query: UPDATE users SET password = :new_password WHERE email IN (SELECT user_email FROM password_resets WHERE reset_token = :token)

    // Simulate success message
    echo "<p>Password reset successful!</p>";
}

// Function to sanitize input data
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
