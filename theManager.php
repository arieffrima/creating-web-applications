
<?php

include('settings.php');

// Function to sanitize user input
function sanitize($input)
{
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Default sorting column and order
$sortColumn = isset($_GET['sortColumn']) ? sanitize($_GET['sortColumn']) : 'EOInumber';
$sortOrder = isset($_GET['sortOrder']) ? sanitize($_GET['sortOrder']) : 'ASC';

// Query to fetch EOIs with sorting options
$query = "SELECT * FROM eoi ORDER BY $sortColumn $sortOrder";
$result = mysqli_query($conn, $query);

if (!$result) {
    echo 'Error: ' . mysqli_error($conn);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager</title>
</head>
<body>
    <h1>This page only for Manager</h1>
 <!-- List of EOIs with sorting applied -->
 <p>Provide the manager with the ability to select the field on which to sort the order in
which the EOI records are displayed</p>
    <!-- Sorting options form -->
    <form method="get">
        <label for="sortColumn">Sort by:</label>
        <select id="sortColumn" name="sortColumn">
            <option value="EOInumber" <?php if ($sortColumn === 'EOInumber') echo 'selected'; ?>>EOInumber</option>
            <option value="JobReferenceNumber" <?php if ($sortColumn === 'JobReferenceNumber') echo 'selected'; ?>>Job Reference</option>
            <option value="FirstName" <?php if ($sortColumn === 'FirstName') echo 'selected'; ?>>First Name</option>
            <option value="LastName" <?php if ($sortColumn === 'LastName') echo 'selected'; ?>>Last Name</option>
            <option value="Status" <?php if ($sortColumn === 'Status') echo 'selected'; ?>>Status</option>
        </select>
        <label for="sortOrder">Order:</label>
        <select id="sortOrder" name="sortOrder">
            <option value="ASC" <?php if ($sortOrder === 'ASC') echo 'selected'; ?>>Ascending</option>
            <option value="DESC" <?php if ($sortOrder === 'DESC') echo 'selected'; ?>>Descending</option>
        </select>
        <input type="submit" value="Sort">
    </form>

    <h3>List of All EOIs :</h3>
    <?php
    if (mysqli_num_rows($result) > 0) {
        echo '<table border="1">';
        echo '<tr><th>EOInumber</th><th>Job Reference</th><th>First Name</th><th>Last Name</th><th>Status</th></tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['EOInumber'] . '</td>';
            echo '<td>' . $row['JobReferenceNumber'] . '</td>';
            echo '<td>' . $row['FirstName'] . '</td>';
            echo '<td>' . $row['LastName'] . '</td>';
            echo '<td>' . $row['Status'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No EOIs found.';
    }
    
    ?>


<?php
// Retrieve user data from the eoi table
$query = "SELECT * FROM eoi";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>
    
    <h3>All Users Information :</h3>
    
    
    <table border="1">
        <tr>
            <th>EOInumber</th>
            <th>Job Reference Number</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Street Address</th>
            <th>Suburb/Town</th>
            <th>State</th>
            <th>Postcode</th>
            <th>Email Address</th>
            <th>Phone Number</th>
            <th>Skill1</th>
            <th>Skill2</th>
            <th>Skill3</th>
            <th>Skill4</th>
            <th>Skill5</th>
            <th>Other Skills</th>
            <th>Application Date</th>
            <th>Status</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['EOInumber'] . "</td>";
            echo "<td>" . $row['JobReferenceNumber'] . "</td>";
            echo "<td>" . $row['FirstName'] . "</td>";
            echo "<td>" . $row['LastName'] . "</td>";
            echo "<td>" . $row['StreetAddress'] . "</td>";
            echo "<td>" . $row['SuburbTown'] . "</td>";
            echo "<td>" . $row['State'] . "</td>";
            echo "<td>" . $row['Postcode'] . "</td>";
            echo "<td>" . $row['EmailAddress'] . "</td>";
            echo "<td>" . $row['PhoneNumber'] . "</td>";
            echo "<td>" . $row['Skill1'] . "</td>";
            echo "<td>" . $row['Skill2'] . "</td>";
            echo "<td>" . $row['Skill3'] . "</td>";
            echo "<td>" . $row['Skill4'] . "</td>";
            echo "<td>" . $row['Skill5'] . "</td>";
            echo "<td>" . $row['OtherSkills'] . "</td>";
            echo "<td>" . $row['ApplicationDate'] . "</td>";
            echo "<td>" . $row['Status'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <!-- Close the database connection -->
    <?php mysqli_close($conn); ?>

</body>
</html>
