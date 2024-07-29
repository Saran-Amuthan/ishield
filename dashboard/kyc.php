<?php
// Function to sanitize input data
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to sanitize file name
function sanitize_file_name($file_name) {
    // Remove any path information from the file name
    $file_name = basename($file_name);
    // Replace spaces with underscores
    $file_name = str_replace(' ', '_', $file_name);
    // Remove special characters except underscore and dot
    $file_name = preg_replace('/[^A-Za-z0-9_\-.]/', '', $file_name);
    return $file_name;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $firstName = sanitize_input($_POST["firstName"]);
    $lastName = sanitize_input($_POST["lastName"]);
    $gender = sanitize_input($_POST["gender"]);
    $address1 = sanitize_input($_POST["address1"]);
    $address2 = sanitize_input($_POST["address2"]);
    $city = sanitize_input($_POST["city"]);
    $state = sanitize_input($_POST["state"]);
    $country = sanitize_input($_POST["countryOfResidence"]);
    $zip = sanitize_input($_POST["zip"]);
    $mobile = sanitize_input($_POST["mobile"]);
    $dateOfBirth = sanitize_input($_POST["dateOfBirth"]);
    $idType = sanitize_input($_POST["idType"]);
    $idNumber = sanitize_input($_POST["idNumber"]);
    $termsAgree = isset($_POST["termsAgree"]) ? "Yes" : "No"; 
    
    // Create user folder if it doesn't exist
    $userFolder = "uploads/" . strtolower($firstName . "_" . $mobile);
    if (!file_exists($userFolder)) {
        mkdir($userFolder, 0777, true); // Create directory with full permissions
    }

    // File upload handling for ID Front and ID Back
    $uploadOk = 1;
    $idFrontFileName = sanitize_file_name($_FILES["idFront"]["name"]);
    $idBackFileName = sanitize_file_name($_FILES["idBack"]["name"]);
    $idFrontFile = $userFolder . "/" . $idFrontFileName;
    $idBackFile = $userFolder . "/" . $idBackFileName;
    $imageFileTypeFront = strtolower(pathinfo($idFrontFile, PATHINFO_EXTENSION));
    $imageFileTypeBack = strtolower(pathinfo($idBackFile, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($idFrontFile) || file_exists($idBackFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["idFront"]["size"] > 5000000 || $_FILES["idBack"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileTypeFront, $allowedExtensions) || !in_array($imageFileTypeBack, $allowedExtensions)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Attempt to upload files
        if (move_uploaded_file($_FILES["idFront"]["tmp_name"], $idFrontFile) && move_uploaded_file($_FILES["idBack"]["tmp_name"], $idBackFile)) {
            echo "The files ". htmlspecialchars(basename($_FILES["idFront"]["name"])) . " and " . htmlspecialchars(basename($_FILES["idBack"]["name"])) . " have been uploaded successfully.";

            // Database connection details
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "ishield";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare SQL statement
            $sql = "INSERT INTO user_kyc(firstName, lastName, gender, address1, address2, city, state, countryOfResidence, zip, mobile, dateofbirth, idtype, idnumber, termsagree)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            // Bind parameters and execute SQL statement
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssssssss", $firstName, $lastName, $gender, $address1, $address2, $city, $state, $countryOfResidence, $zip, $mobile, $dateOfBirth, $idType, $idNumber, $termsAgree,);

            if ($stmt->execute()) {
                echo "<script type='text/javascript'>alert('New records inserted successfully.');location='kyc.html';</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            // Close prepared statement and database connection
            $stmt->close();
            $conn->close();
        } else {
            echo "<script type='text/javascript'>alert('Sorry, there was an error uploading your files.');location='kyc.html';</script>";
        }
    }
} else {
    // Redirect to the form page if accessed directly without POST method
    header("Location: index.html");
    exit();
}
?>
