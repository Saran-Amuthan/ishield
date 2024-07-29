<?php
session_start(); // Start the session

// Ensure user is logged in or has a valid session
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to view this page.");
}

$userId = $_SESSION['email']; // Get user ID from session

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch KYC data for the logged-in user
$stmt = $conn->prepare("SELECT * FROM kyc_data WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View KYC</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
            }
            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 8px;
                background-color: #f9f9f9;
            }
            h1 {
                font-size: 24px;
                margin-bottom: 20px;
            }
            .form-group {
                margin-bottom: 15px;
            }
            .form-group label {
                font-weight: bold;
            }
            .form-group p {
                margin: 5px 0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Your KYC Information</h1>
            <div class="form-group">
                <label>First Name:</label>
                <p><?php echo htmlspecialchars($data['firstName']); ?></p>
            </div>
            <div class="form-group">
                <label>Last Name:</label>
                <p><?php echo htmlspecialchars($data['lastName']); ?></p>
            </div>
            <div class="form-group">
                <label>Gender:</label>
                <p><?php echo htmlspecialchars($data['gender']); ?></p>
            </div>
            <div class="form-group">
                <label>Address Line 1:</label>
                <p><?php echo htmlspecialchars($data['address1']); ?></p>
            </div>
            <div class="form-group">
                <label>Address Line 2:</label>
                <p><?php echo htmlspecialchars($data['address2']); ?></p>
            </div>
            <div class="form-group">
                <label>City:</label>
                <p><?php echo htmlspecialchars($data['city']); ?></p>
            </div>
            <div class="form-group">
                <label>State/Province/Region:</label>
                <p><?php echo htmlspecialchars($data['state']); ?></p>
            </div>
            <div class="form-group">
                <label>Country of Residence:</label>
                <p><?php echo htmlspecialchars($data['countryOfResidence']); ?></p>
            </div>
            <div class="form-group">
                <label>Zip/Postal Code:</label>
                <p><?php echo htmlspecialchars($data['zip']); ?></p>
            </div>
            <div class="form-group">
                <label>Mobile:</label>
                <p><?php echo htmlspecialchars($data['mobile']); ?></p>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <p><?php echo htmlspecialchars($data['email']); ?></p>
            </div>
            <div class="form-group">
                <label>Date of Birth:</label>
                <p><?php echo htmlspecialchars($data['dateOfBirth']); ?></p>
            </div>
            <div class="form-group">
                <label>ID Type:</label>
                <p><?php echo htmlspecialchars($data['idType']); ?></p>
            </div>
            <div class="form-group">
                <label>ID Number:</label>
                <p><?php echo htmlspecialchars($data['idNumber']); ?></p>
            </div>
            <div class="form-group">
                <label>ID Card Front:</label>
                <p><img src="<?php echo htmlspecialchars($data['idFrontPath']); ?>" alt="ID Card Front" style="max-width: 100%; height: auto;"></p>
            </div>
            <div class="form-group">
                <label>ID Card Back:</label>
                <p><img src="<?php echo htmlspecialchars($data['idBackPath']); ?>" alt="ID Card Back" style="max-width: 100%; height: auto;"></p>
            </div>
            <div class="form-group">
                <label>Terms and Conditions Agreed:</label>
                <p><?php echo $data['termsAgree'] ? 'Yes' : 'No'; ?></p>
            </div>
        </div>
    </body>
    </html>

    <?php
} else {
    echo "No KYC data found.";
}

$stmt->close();
$conn->close();
?>
