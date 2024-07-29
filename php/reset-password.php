<?php
// Check if token is provided and valid (in a real application, you would validate this against a database)
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Example form for resetting password
    echo "<h2>Reset Password</h2>";
    echo "<form action='reset-password-process.php' method='post'>";
    echo "<input type='hidden' name='token' value='$token'>";
    echo "<label for='new-password'>New Password:</label>";
    echo "<input type='password' id='new-password' name='new-password' required>";
    echo "<button type='submit'>Reset Password</button>";
    echo "</form>";
} else {
    echo "<p>Invalid or expired token.</p>";
}
?>
