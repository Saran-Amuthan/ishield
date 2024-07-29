<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="style.css">

	<title>Ishield Dashboard</title>
    <style>
        /* styles.css */

/* General styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    color: #333;
    line-height: 1.6;
    padding: 20px;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h5.card-title-sm {
    margin-bottom: 10px;
    font-size: 1.2rem;
}

/* Form styling */
.input-item {
    margin-bottom: 20px;
}

.input-item label {
    display: block;
    margin-bottom: 5px;
}

.input-bordered {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

.select-bordered {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 4px;
    font-size: 16px;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.text-success {
    color: #28a745;
}

.checkbox-label {
    display: inline-block;
    margin-bottom: 10px;
}

.input-switch {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 24px;
    background-color: #ccc;
    border-radius: 12px;
    margin-right: 10px;
}

.input-switch input {
    display: none;
}

.input-switch .input-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: white;
    border-radius: 12px;
    transition: 0.4s;
}

.input-switch input:checked + .input-slider {
    background-color: #007bff;
}

.input-slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    border-radius: 50%;
    transition: 0.4s;
}

.input-switch input:checked + .input-slider:before {
    transform: translateX(16px);
}

.input-switch-sm {
    width: 32px;
    height: 16px;
}

.gaps-1x {
    margin-top: 20px;
}

.d-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }
    .input-item {
        margin-bottom: 15px;
    }
}

    </style>

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
				<a href="profile.html">
					<i class='bx bx-user'></i>
					<span class="text">My Profile</span>
				</a>
			</li>
			<li>
				<a href="KYC.html">
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
					<i class='bx bxs-doughnut-chart'></i>
					<span class="text">Analytics</span>
				</a>
			</li>
			<li>
				<a href="team.html">
					<i class='bx bxs-group'></i>
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
				<a href="../Sign_in.html" class="logout">
					<i class='bx bxs-log-out-circle'></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu'></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="notification">
				<i class='bx bxs-bell'></i>
				<span class="num">8</span>
			</a>
			<a href="#" class="profile">
				<img src="img/people.png">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="index.html">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li>
							<a class="active" href="profile.html">PROFILE</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="tab-content" id="profile-details">
				<div class="tab-pane fade show active" id="personal-data">
					<form action="profile.php" method="POST">
						<?php
                    $conn = mysqli_connect('localhost', 'root', '', 'ishield');
                    if ($conn->connect_error) {
                      die("Connection failed: " . $conn->connect_error);
                    }
                    $tbl_name = 'register';
                    $empid = $_SESSION['empid'];
                    $empid = stripslashes($empid);
                    $empid = mysqli_real_escape_string($conn, $_SESSION['empid']);
                    $sql = "SELECT username,email,Emp_Role,District FROM $tbl_name WHERE empid='$empid'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                      foreach ($result as $row) {
                        ?>
						<div class="row">
							<div class="col-md-6">
								<div class="input-item input-with-label">
									<label for="User-Name" class="input-item-label">User Name</label>
									<input class="input-bordered" type="text" value="<?= $row['username']; ?>"
										id="username" name="username" pattern=".{4,}" title="Minimum of 4 characters"
										maxlength="20" required />
								</div>
								<!-- .input-item -->
							</div>
							<div class="col-md-6">
								<div class="input-item input-with-label">
									<label for="email-address" class="input-item-label">Email Address</label>
									<input class="input-bordered" type="email" value="<?= $row['email']; ?>" id="email"
										name="Email" type="email" pattern=".{3,}" title="Minimum of 3 characters"
										maxlength="255" required />
								</div>
								<!-- .input-item -->
							</div>

							<div class="col-md-6">
								<div class="input-item input-with-label">
									<label for="Mobile Number" class="input-item-label">Mobile Number</label>
									<link rel="stylesheet"
										href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
									<script
										src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
									</head>

									<body><br>
										<input class="input-bordered" type="tel" value="<?= $row['phone']; ?>"
											id="phone" name="phone" pattern=".{0-9}" title="Minimum of 4 characters"
											maxlength="10" required /></br>
									</body>
									<script>
										const phoneInputField = document.querySelector("#phone");
										const phoneInput = window.intlTelInput(phoneInputField, {
											utilsScript:
												"https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
										});
									</script>
								</div>
							</div>
							<div class="col-md-6">
								<div class="input-item input-with-label">
									<label for="date-of-birth" class="input-item-label">Date of Birth</label>
									<input class="input-bordered" type="date" value="<?= $row['Dateofbirth']; ?>"
										id="Dateofbirth" name="Dateofbirth" pattern=".{4,}"
										title="Minimum of 4 characters" maxlength="10" required />
								</div>
							</div>
							<div class="col-md-6">
								<div class="input-item input-with-label">
									<label for="nationality" class="input-item-label">Nationality</label>
									<select class="select-bordered select-block" name="Nationality" id="Nationality">
										<option value="India">India</option>
										<option value="United Kingdom">United Kingdom</option>
										<option value="France">France</option>
										<option value="Singapore">Singapore</option>
										<option value="Malaysia">Malaysia</option>
										<option value="Australia">Australia</option>
										<option value="Czech Republic">Czech Republic</option>
										<option value="United States">United States</option>
										<option value="Ireland">Ireland</option>
										<option value="Colombia">Colombia</option>
									</select>
								</div>
							</div>
						</div>
						<div class="gaps-1x">
						</div>

						<div class="d-sm-flex justify-content-between align-items-center">
							<button class="btn btn-primary" name="Update_Profile" value="Update_Profile" input
								type="submit">Update Profile</button>
							<div class="gaps-2x d-sm-none"></div><span class="text-success">
								<em class="ti ti-check-box"></em> All Changes are saved</span>
						</div>

						<?php
                      }
                    }
                    ?>

						<?php

                    session_start();
                    $UserID = $_SESSION['empid'];
                    $FullName = $_POST['username'];
                    $Email = $_POST['email'];
                    $phone = $_POST['phone'];
                    $Dateofbirth = $_POST['Dateofbirth'];
                    $Nationality = $_POST['Nationality'];

                    $sql1 = "update $tbl_name set username='$username', email='$email', phone='$phone',Dateofbirth='$Dateofbirth',Nationality='$Nationality' where empid='$empid'";
                    if ($conn->query($sql1) === TRUE) {
                      echo "update successfull";
                    } else {
                      echo "Error:";

                    }
                    ?>
						<!-- form -->
				</div><!-- .tab-pane -->
				</form>
				<div class="tab-pane fade" id="settings">
					<div class="pdb-1-5x">
						<h5 class="card-title card-title-sm text-dark">Security Settings</h5>
					</div>
					<div class="input-item">
						<input type="checkbox" class="input-switch input-switch-sm" id="save-log" checked>
						<label for="save-log">Save my Activities Log</label>
					</div>
					<div class="input-item">
						<input type="checkbox" class="input-switch input-switch-sm" id="pass-change-confirm">
						<label for="pass-change-confirm">Confirm me through email before password change</label>
					</div>
					<div class="pdb-1-5x">
						<h5 class="card-title card-title-sm text-dark">Manage Notification</h5>
					</div>
					<div class="input-item">
						<input type="checkbox" class="input-switch input-switch-sm" id="latest-news" checked>
						<label for="latest-news">Notify me by email about sales and latest news</label>
					</div>
					<div class="input-item">
						<input type="checkbox" class="input-switch input-switch-sm" id="activity-alert" checked>
						<label for="activity-alert">Alert me by email for unusual activity.</label>
					</div>
					<div class="gaps-1x"></div>
					<div class="d-flex justify-content-between align-items-center"><span></span>
						<span class="text-success"><em class="ti ti-check-box"></em> Setting has been updated</span>
					</div>
				</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->


	<script src="script.js"></script>
</body>

</html>