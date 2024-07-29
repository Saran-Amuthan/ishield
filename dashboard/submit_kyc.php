<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../sign_in.html");
    exit();
}

// Database connection
$db_host = 'localhost';
$db_name = 'ishield';
$db_user = 'root';
$db_pass = '';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $countryOfResidence = $_POST['countryOfResidence'];
    $zip = $_POST['zip'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $idType = $_POST['idType'];
    $idNumber = $_POST['idNumber'];

    // File upload handling
    $upload_dir = 'uploads/';
    $timestamp = time();
    $idFront_filename = $firstName . '_' . $mobile . '_front_' . $timestamp . '.' . pathinfo($_FILES['idFront']['name'], PATHINFO_EXTENSION);
    $idBack_filename = $firstName . '_' . $mobile . '_back_' . $timestamp . '.' . pathinfo($_FILES['idBack']['name'], PATHINFO_EXTENSION);

    $idFront_path = $upload_dir . $idFront_filename;
    $idBack_path = $upload_dir . $idBack_filename;

    if (move_uploaded_file($_FILES['idFront']['tmp_name'], $idFront_path) && move_uploaded_file($_FILES['idBack']['tmp_name'], $idBack_path)) {
        // Insert KYC information into the database
        $sql = "
            INSERT INTO user_kyc (firstName, lastName, gender, address1, address2, city, state, countryOfResidence, zip, mobile, email, dateOfBirth, idType, idNumber, idFront, idBack) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare statement failed: " . $conn->error);
        }

        $stmt->bind_param('ssssssssssssssss', $firstName, $lastName, $gender, $address1, $address2, $city, $state, $countryOfResidence, $zip, $mobile, $email, $dateOfBirth, $idType, $idNumber, $idFront_path, $idBack_path);

        if ($stmt->execute()) {
            echo "KYC information submitted successfully.";
        } else {
            echo "Error submitting KYC information: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error uploading files.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Submit KYC</title>
    <style>
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .kyc-form {
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .kyc-form h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .kyc-form input, .kyc-form select, .kyc-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .kyc-form button {
            padding: 10px 20px;
            font-size: 18px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .kyc-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <section id="sidebar">
        <a href="index.html" class="brand">
            <img src="../images/logo-ishield.png" alt="Ishield">
        </a>
        <ul class="side-menu top">
            <li>
                <a href="index.html">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="profile.php">
                    <i class='bx bx-user'></i>
                    <span class="text">My Profile</span>
                </a>
            </li>
            <li>
                <a href="kyc1.php">
                    <i class='bx bxs-id-card'></i>
                    <span class="text">KYC</span>
                </a>
            </li>
            <li>
                <a href="wallet.html">
                    <i class='bx bx-wallet'></i>
                    <span class="text">Wallet</span>
                </a>
            </li>
            <li>
                <a href="Analytics.html">
                    <i class='bx bxs-doughnut-chart' ></i>
                    <span class="text">Analytics</span>
                </a>
            </li>
            <li >
                <a href="team.html">
                    <i class='bx bxs-group' ></i>
                    <span class="text">Team</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#">
                    <i class='bx bxs-cog'></i>
                    <span class="text">Settings</span>
                </a>
            </li>
            <li>
                <a href="logout.php" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>

    <section id="content">
        <nav>
            <i class='bx bx-menu'></i>
            <div class="nav-right">
                <input type="checkbox" id="switch-mode" hidden>
                <label for="switch-mode" class="switch-mode"></label>
                <a href="#" class="profile">
                    <img src="<?php echo htmlspecialchars($_SESSION['profile_picture']); ?>" alt="Profile">
                </a>
            </div>
        </nav>

        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Submit KYC</h1>
                    <ul class="breadcrumb">
                        <li><a href="index.html">Dashboard</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="submit_kyc.php">Submit KYC</a></li>
                    </ul>
                </div>
            </div>

            <div class="container">
                <div class="kyc-form">
                    <h2>Submit Your KYC Information</h2>
                    <form method="POST" action="submit_kyc.php" enctype="multipart/form-data">
                        <input type="text" name="firstName" placeholder="First Name" required>
                        <input type="text" name="lastName" placeholder="Last Name" required>
                        <select name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                        <input type="text" name="address1" placeholder="Address Line 1" required>
                        <input type="text" name="address2" placeholder="Address Line 2">
                        <input type="text" name="city" placeholder="City" required>
                        <input type="text" name="state" placeholder="State" required>
                        <input type="text" name="countryOfResidence" placeholder="Country of Residence" required>
                        <input type="text" name="zip" placeholder="Zip/Postal Code" required>
                        <input type="text" name="mobile" placeholder="Mobile Number" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="date" name="dateOfBirth" placeholder="Date of Birth" required>
                        <select name="idType" required>
                            <option value="">Select ID Type</option>
                            <option value="Passport">Passport</option>
                            <option value="Driver's License">Driver's License</option>
                            <option value="National ID">National ID</option>
                        </select>
                        <input type="text" name="idNumber" placeholder="ID Number" required>
                        <input type="file" name="idFront" accept="image/*" required>
                        <input type="file" name="idBack" accept="image/*" required>
                        <button type="submit">Submit KYC</button>
                    </form>
                </div>
            </div>
        </main>
    </section>
    <script src="script.js"></script>
</body>
</html>
