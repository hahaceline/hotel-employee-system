<?php

include "db_config.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get the form values sent from index.php
    // mysqli_real_escape_string() protects against SQL injection
    $employee_name = mysqli_real_escape_string($conn, $_POST['employee_name']);
    $position      = mysqli_real_escape_string($conn, $_POST['position']);
    $department    = mysqli_real_escape_string($conn, $_POST['department']);

    $sql = "INSERT INTO employee (employee_name, position, department)
            VALUES ('$employee_name', '$position', '$department')";

    // run the query
    if (mysqli_query($conn, $sql)) {
        // Success: send the user back to index.php
        header("Location: index.php?status=success");
        exit();
    } else {
        // show error
        echo "Error adding employee: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
