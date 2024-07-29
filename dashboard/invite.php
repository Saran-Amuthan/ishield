<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root"; // Default username for MySQL
$password = ""; // Default password for MySQL
$dbname = "dashboardDB";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $email = $data->email;

    // Generate a unique token
    $inviteToken = bin2hex(random_bytes(16));

    // Insert the invite into the database
    $stmt = $conn->prepare("INSERT INTO invites (email, invite_token) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $inviteToken);

    if ($stmt->execute()) {
        $baseUrl = "http://" . $_SERVER['HTTP_HOST'];
        $inviteLink = $baseUrl . "/invite.php?token=" . $inviteToken;
        echo json_encode(["inviteLink" => $inviteLink]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Error generating invite link"]);
    }

    $stmt->close();
}

$conn->close();
?>
