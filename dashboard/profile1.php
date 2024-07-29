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

$email = $_SESSION['email'];

// Join query to collect data from register, profile_details, and user_kyc tables
$sql = "
    SELECT r.username, r.empid, r.empRole, u.mobile, p.address, p.profile_picture 
    FROM register r 
    LEFT JOIN profile_details p ON r.email = p.email 
    LEFT JOIN user_kyc u ON r.email = u.email 
    WHERE r.email = ?
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare statement failed: " . $conn->error);
}

$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $username = htmlspecialchars($row['username']);
    $empID = htmlspecialchars($row['empid']);
    $empRole = htmlspecialchars($row['empRole']);
    $mobile = htmlspecialchars($row['mobile']);
    $address = htmlspecialchars($row['address']);
    $profilePicture = htmlspecialchars($row['profile_picture']);
    $_SESSION['profile_picture'] = $profilePicture;
} else {
    echo "User data not found!";
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Ishield Dashboard</title>
    <style>
       /* General container styling */
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Profile section styling */
        .profile {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            gap: 20px;
        }

        /* Profile picture styling */
        .profile-picture {
            flex: 1;
            text-align: center;
        }

        .profile-picture img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
        }

        .profile-picture input[type="file"] {
            display: block;
            margin: 10px auto;
        }

        /* Profile information styling */
        .profile-info {
            flex: 2;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-info h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .profile-info p {
            margin: 10px 0;
            font-size: 18px;
            color: #555;
        }

        .profile-info p strong {
            color: #000;
        }

        .profile-info .buttons {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        /* Button styling */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-back {
            background-color: #6c757d;
        }

        .btn-update {
            background-color: #007bff;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
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
            <li class="active">
                <a href="profile1.php">
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
                <a href="wallet.php">
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
            <!-- Add other menu items here -->
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
    <!-- SIDEBAR -->

    <!-- CONTENT -->
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
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li><a href="index.html">Dashboard</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="profile1.php">PROFILE</a></li>
                    </ul>
                </div>
            </div>

            <div class="container">
                <div class="profile">
                    <div class="profile-picture">
                        <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" id="profileImage">
                        <form action="updateprofile.php" method="post" enctype="multipart/form-data">
                            <input type="file" name="profilePicture" id="profilePicture">
                            <input type="submit" value="Upload Picture" name="submit">
                        </form>
                    </div>
                    <div class="profile-info">
                        <h2>Profile Information</h2>
                        <p><strong>Employee Name:</strong> <?php echo $username; ?></p>
                        <p><strong>Employee ID:</strong> <?php echo $empID; ?></p>
                        <p><strong>Employee Role:</strong> <?php echo $empRole; ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                        <p><strong>Phone Number:</strong> <?php echo $mobile; ?></p>
                        <div class="buttons">
                            <a href="dashboard.html" class="btn btn-back">Back to Dashboard</a>
                            <a href="updateprofile.php" class="btn btn-update">Update Changes</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </section>
    <script src="script.js"></script>
</body>
</html>
