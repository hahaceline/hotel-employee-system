<?php

include "db_config.php";


header("Content-Type: application/json");


$sql = "SELECT id, employee_name, position, department FROM employee";
$result = mysqli_query($conn, $sql);

// hold employee roles
$employees = array();


if ($result) {
    // loop rows
    while ($row = mysqli_fetch_assoc($result)) {
        // Add this employee row to the array
        $employees[] = $row;
    }
}

// convert the PHP array into JSON text and print it out
echo json_encode($employees);

// Close the database connection
mysqli_close($conn);
?>
