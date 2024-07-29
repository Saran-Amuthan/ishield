<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../sign_in.html");
    exit();
}

// Determine the current page
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Ishield Dashboard</title>
</head>

<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="index.html" class="brand">
            <img src="../images/logo-ishield.png" alt="Ishield">
        </a>
        <ul class="side-menu top">
            <li class="<?php echo $current_page == 'index.html' ? 'active' : ''; ?>">
                <a href="index.html">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="<?php echo $current_page == 'profile.php' ? 'active' : ''; ?>">
                <a href="profile.php">
                    <i class='bx bx-user'></i>
                    <span class="text">My Profile</span>
                </a>
            </li>
            <li class="<?php echo $current_page == 'kyc1.php' ? 'active' : ''; ?>">
                <a href="kyc1.php">
                    <i class='bx bxs-id-card'></i>
                    <span class="text">KYC</span>
                </a>
            </li>

            <li class="<?php echo $current_page == 'wallet.php' ? 'active' : ''; ?>">
                <a href="wallet.php">
                    <i class='bx bx-wallet'></i>
                    <span class="text">Wallet</span>
                </a>
            </li>
            <li class="<?php echo $current_page == 'analytics.php' ? 'active' : ''; ?>">
                <a href="analytics.php">
                    <i class='bx bx-bar-chart'></i>
                    <span class="text">Analytics</span>
                </a>
            </li>
            <li class="<?php echo $current_page == 'teamnew.php' ? 'active' : ''; ?>">
                <a href="teamnew.php">
                    <i class='bx bx-group'></i>
                    <span class="text">Team</span>
                </a>
            </li>
            <!-- Add other menu items here -->
        </ul>
        <ul class="side-menu">
            <li class="<?php echo $current_page == 'settings.php' ? 'active' : ''; ?>">
                <a href="settings.php">
                    <i class='bx bxs-cog'></i>
                    <span class="text">Settings</span>
                </a>
            </li>
            <li class="<?php echo $current_page == 'logout.php' ? 'active' : ''; ?>">
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