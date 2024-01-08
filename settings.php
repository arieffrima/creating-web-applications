<?php

$host = "feenix-mariadb.swin.edu.au";
$user = "s104196233";
$pwd  = "170294";
$sql_db  = "s104196233_db";

$conn = @mysqli_connect($host, $user, $pwd);

// Check if the database connection is successful
if ($conn) {
    // Select the database
    mysqli_select_db($conn, $sql_db);

    // SQL query to check if the eoi table exists
    $checkTableQuery = "SHOW TABLES LIKE 'eoi'";
    $result = mysqli_query($conn, $checkTableQuery);

    // If the table doesn't exist, create it
    if (mysqli_num_rows($result) == 0) {
        $createTableQuery = "
            CREATE TABLE eoi (
                EOInumber INT AUTO_INCREMENT PRIMARY KEY,
                JobReferenceNumber VARCHAR(20),
                FirstName VARCHAR(20),
                LastName VARCHAR(20),
                StreetAddress VARCHAR(40),
                SuburbTown VARCHAR(40),
                State CHAR(3),
                Postcode CHAR(4),
                Email VARCHAR(255),
                PhoneNumber VARCHAR(12),
                Skill1 VARCHAR(255),
                OtherSkills TEXT,
                Status ENUM('New', 'Current', 'Final') DEFAULT 'New'
            )
        ";

        // Execute the CREATE TABLE query
        if (mysqli_query($conn, $createTableQuery)) {
            echo "EOI table created successfully.";
        } else {
            echo "Error creating EOI table: " . mysqli_error($conn);
        }
    }
} else {
    echo "Failed to connect to the database: " . mysqli_connect_error();
}

?>
