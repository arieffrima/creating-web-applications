<?php
// Include the settings.php file to establish a database connection
include('settings.php');


// Function to retrieve all EOIs from the database
function getAllEOIs($conn) {
    $query = "SELECT * FROM eoi";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Function to retrieve EOIs for a specific job reference number
function getEOIsByRefNumber($conn, $jobReferenceNumber) {
    $query = "SELECT * FROM eoi WHERE JobReferenceNumber = '$jobReferenceNumber'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Function to retrieve EOIs for a specific applicant (by first name, last name, or both)
function getEOIsByApplicant($conn, $firstName, $lastName) {
    $query = "SELECT * FROM eoi WHERE FirstName LIKE '%$firstName%' AND LastName LIKE '%$lastName%'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Function to change the status of an EOI for a particular applicant
function changeStatus($conn, $applicantId, $newStatus) {
    $query = "UPDATE eoi SET Status = '$newStatus' WHERE EOInumber = $applicantId";
    return mysqli_query($conn, $query);
}

// Function to delete all EOIs with a specified job reference number
function deleteEOIsByRefNumber($conn, $jobReferenceNumber) {
    $query = "DELETE FROM eoi WHERE JobReferenceNumber = '$jobReferenceNumber'";
    return mysqli_query($conn, $query);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'changeStatus') {
            // Change the status of an EOI
            $applicantId = $_POST['applicantId'];
            $newStatus = $_POST['newStatus'];

            if (changeStatus($conn, $applicantId, $newStatus)) {
                echo "Status changed successfully.";
            } else {
                echo "Error changing status.";
            }
        } elseif ($action === 'deleteEOIs') {
            // Delete EOIs with a specified job reference number
            $jobReferenceNumber = $_POST['jobReferenceNumber'];

            if (deleteEOIsByRefNumber($conn, $jobReferenceNumber)) {
                echo "EOIs deleted successfully.";
            } else {
                echo "Error deleting EOIs.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage EOIs</title>
    <script src="scripts/apply.js"></script>
</head>
<body>
    <h1>Manage EOIs</h1>

    <h2>List of All EOIs</h2>
    <?php
    // Retrieve and display all EOIs
    $allEOIs = getAllEOIs($conn);
    if (!empty($allEOIs)) {
        echo "<ul>";
        foreach ($allEOIs as $eoi) {
            echo "<li>EOInumber: {$eoi['EOInumber']}, Name: {$eoi['FirstName']} {$eoi['LastName']}, Status: {$eoi['Status']}</li>";
        }
        echo "</ul>";
    } else {
        echo "No EOIs found.";
    }
    ?>

    <h2>List of EOIs for a Specific Job Reference Number</h2>
    <form method="post">
        <input type="text" name="jobReferenceNumber" placeholder="Job Reference Number">
        <input type="hidden" name="action" value="getEOIsByRefNumber">
        <button type="submit">Get EOIs</button>
    </form>
    <?php
    // Display EOIs for a specific job reference number if submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'getEOIsByRefNumber') {
        $jobReferenceNumber = $_POST['jobReferenceNumber'];
        $eoisByRefNumber = getEOIsByRefNumber($conn, $jobReferenceNumber);

        if (!empty($eoisByRefNumber)) {
            echo "<ul>";
            foreach ($eoisByRefNumber as $eoi) {
                echo "<li>EOInumber: {$eoi['EOInumber']}, Name: {$eoi['FirstName']} {$eoi['LastName']}, Status: {$eoi['Status']}</li>";
            }
            echo "</ul>";
        } else {
            echo "No EOIs found for Job Reference Number: $jobReferenceNumber";
        }
    }
    ?>

    <h2>List of EOIs for a Specific Applicant</h2>
    <form method="post">
        <input type="text" name="firstName" placeholder="First Name">
        <input type="text" name="lastName" placeholder="Last Name">
        <input type="hidden" name="action" value="getEOIsByApplicant">
        <button type="submit">Get EOIs</button>
    </form>
    <?php
    // Display EOIs for a specific applicant if submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'getEOIsByApplicant') {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $eoisByApplicant = getEOIsByApplicant($conn, $firstName, $lastName);

        if (!empty($eoisByApplicant)) {
            echo "<ul>";
            foreach ($eoisByApplicant as $eoi) {
                echo "<li>EOInumber: {$eoi['EOInumber']}, Name: {$eoi['FirstName']} {$eoi['LastName']}, Status: {$eoi['Status']}</li>";
            }
            echo "</ul>";
        } else {
            echo "No EOIs found for the specified applicant.";
        }
    }
    
    
    ?>

    <h2>Change Status of an EOI</h2>
    <form method="post">
        <input type="text" name="applicantId" placeholder="EOInumber">
        <select name="newStatus">
            <option value="New">New</option>
            <option value="Current">Current</option>
            <option value="Final">Final</option>
        </select>
        <input type="hidden" name="action" value="changeStatus">
        <button type="submit">Change Status</button>
    </form>

    <h2>Delete EOIs by Job Reference Number</h2>
    <form method="post">
        <input type="text" name="jobReferenceNumber" placeholder="Job Reference Number">
        <input type="hidden" name="action" value="deleteEOIs">
        <button type="submit">Delete EOIs</button>
    </form>
    <?php include('footer.inc'); ?>
</body>
</html>
