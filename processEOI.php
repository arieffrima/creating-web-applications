<?php


// Include your database connection settings from settings.php
include('settings.php');

// Check if the eoi table exists, and create it if it doesn't
$tableExists = false;
$result = mysqli_query($conn, "SHOW TABLES LIKE 'eoi'");
if ($result) {
    if (mysqli_num_rows($result) == 1) {
        $tableExists = true;
    }
}

if (!$tableExists) {
    // Create the eoi table if it doesn't exist
    $createTableSQL = "CREATE TABLE eoi (
        EOInumber INT AUTO_INCREMENT PRIMARY KEY,
        JobReferenceNumber VARCHAR(255) NOT NULL,
        FirstName VARCHAR(50) NOT NULL,
        LastName VARCHAR(50) NOT NULL,
        StreetAddress VARCHAR(255) NOT NULL,
        SuburbTown VARCHAR(100) NOT NULL,
        State VARCHAR(50) NOT NULL,
        Postcode VARCHAR(10) NOT NULL,
        EmailAddress VARCHAR(255) NOT NULL,
        PhoneNumber VARCHAR(20) NOT NULL,
        Skill1 VARCHAR(100),
        Skill2 VARCHAR(100),
        Skill3 VARCHAR(100),
        Skill4 VARCHAR(100),
        Skill5 VARCHAR(100),
        OtherSkills TEXT,
        ApplicationDate DATE NOT NULL,
        Status ENUM('New', 'Current', 'Final') DEFAULT 'New' NOT NULL
    )";
    if (mysqli_query($conn, $createTableSQL)) {
        echo "The 'eoi' table has been created successfully.<br>";
    } else {
        echo "Error creating the 'eoi' table: " . mysqli_error($conn) . "<br>";
    }
}

// Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate the form data (enhanced validation)
    
    // Validate and sanitize the job reference number
    $jobRef = sanitize($_POST["JRN"]);
    if (strlen($jobRef) !== 5 || !ctype_alnum($jobRef)) {
        displayError("Job reference number must be exactly 5 alphanumeric characters.");
    }
    
    // Validate and sanitize first name
    $firstName = sanitize($_POST["firstname"]);
    if (strlen($firstName) > 20 || !ctype_alpha($firstName)) {
        displayError("First name must be a maximum of 20 alphabetic characters.");
    }

    // Validate and sanitize last name
    $lastName = sanitize($_POST["lastname"]);
    if (strlen($lastName) > 20 || !ctype_alpha($lastName)) {
        displayError("Last name must be a maximum of 20 alphabetic characters.");
    }
    
    // Validate date of birth (age between 15 and 80)
    $dob = sanitize($_POST["DOB"]);
    $dobTimestamp = strtotime($dob);
    if (!$dobTimestamp || $dobTimestamp > strtotime("-15 years") || $dobTimestamp < strtotime("-80 years")) {
        displayError("Invalid date of birth. Age must be between 15 and 80.");
    }

    // Validate gender
    $gender = isset($_POST["gender"]) ? sanitize($_POST["gender"]) : '';
    if (empty($gender)) {
        displayError("Gender must be selected.");
    }

    $streetAddress = $_POST["streetaddress"];
    $suburbTown = $_POST["suburb/town"];
   // Validate street address
if (empty($streetAddress)) {
    displayError("Street address cannot be blank.");
} elseif (strlen($streetAddress) > 40) {
    displayError("Street address must be a maximum of 40 characters.");
}

// Validate suburb/town
if (empty($suburbTown)) {
    displayError("Suburb/town cannot be blank.");
} elseif (strlen($suburbTown) > 40) {
    displayError("Suburb/town must be a maximum of 40 characters.");
}
    
    // Validate state
    $state = sanitize($_POST["state"]);
    if (!in_array($state, ['VIC', 'NSW', 'QLD', 'NT', 'WA', 'SA', 'TAS', 'ACT'])) {
        displayError("State must be one of VIC, NSW, QLD, NT, WA, SA, TAS, ACT.");
    }

    // Validate and sanitize postcode
    $postcode = sanitize($_POST["postcode"]);
    if (!preg_match('/^\d{4}$/', $postcode) || ($state === 'VIC' && substr($postcode, 0, 1) !== '3')) {
        displayError("Invalid postcode.");
    }

    // Validate and sanitize email address
    $email = sanitize($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        displayError("Invalid email address format.");
    }

    // Validate and sanitize phone number
    $phoneNumber = sanitize($_POST["phonenumber"]);
    if (!preg_match('/^[0-9\s]{8,12}$/', $phoneNumber)) {
        displayError("Phone number must be 8 to 12 digits or spaces.");
    }

    // OtherSkills validation
    $skills = isset($_POST["category"]) ? $_POST["category"] : [];
    $otherSkills = sanitize($_POST["comments"]);
    if (in_array('other', $skills) && empty($otherSkills)) {
        displayError("Other skills must not be empty if 'Other Skills' is selected.");
    }
    if (empty($skills) && empty($otherSkills)) {
        displayError("You must select at least one skill or provide details in the 'Other Skills' field.");
    }
    // Validate and sanitize the application date
    $applicationDate = sanitize($_POST["year"]) . "-" . sanitize($_POST["month"]) . "-" . sanitize($_POST["day"]);


    
    // Insert data into the eoi table
    $insertSQL = "INSERT INTO eoi (JobReferenceNumber, FirstName, LastName, StreetAddress, SuburbTown, State, Postcode, EmailAddress, PhoneNumber, Skill1, Skill2, Skill3, Skill4, Skill5, OtherSkills, ApplicationDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $insertSQL);
    mysqli_stmt_bind_param($stmt, "ssssssssssssssss", $jobRef, $firstName, $lastName, $streetAddress, $suburbTown, $state, $postcode, $email, $phoneNumber, $skill1, $skill2, $skill3, $skill4, $skill5, $otherSkills, $applicationDate);

    // Set variables from form data (sanitize and validate data here)
    $jobRef = $_POST["JRN"];
    $firstName = $_POST["firstname"];
    $lastName = $_POST["lastname"];
    $streetAddress = $_POST["streetaddress"];
    $suburbTown = $_POST["suburb/town"];
    $state = $_POST["state"];
    $postcode = $_POST["postcode"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phonenumber"];
    $skill1 = isset($_POST["category"][0]) ? $_POST["category"][0] : null;
    $skill2 = isset($_POST["category"][1]) ? $_POST["category"][1] : null;
    $skill3 = isset($_POST["category"][2]) ? $_POST["category"][2] : null;
    $skill4 = isset($_POST["category"][3]) ? $_POST["category"][3] : null;
    $skill5 = isset($_POST["category"][4]) ? $_POST["category"][4] : null;
    $otherSkills = $_POST["comments"];
    $applicationDate = $_POST["year"] . "-" . $_POST["month"] . "-" . $_POST["day"];

    if (mysqli_stmt_execute($stmt)) {
        $lastInsertedID = mysqli_insert_id($conn);
        echo "Your EOI has been successfully submitted. Your EOInumber is: " . $lastInsertedID;
    } else {
        echo "Error submitting your EOI: " . mysqli_error($conn);
    }

    

    mysqli_stmt_close($stmt);
}

// Redirect if accessed directly
else {
    header("Location: apply.php");
    exit();
}

// Function to perform data validation
// Function to perform data validation

function sanitize($input)
{
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Function to display an error message and redirect back to the form
function displayError($message)
{
    echo '<html><head><title>Error</title></head><body>';
    echo '<h2>Error:</h2>';
    echo '<p>' . $message . '</p>';
    echo '</body></html>';
    exit();
}

// Close the database connection
mysqli_close($conn);

?>

