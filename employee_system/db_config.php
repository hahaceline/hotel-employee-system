<?php

// db connection settings 
$host = "localhost";   
$user = "root";        
$pass = "";            
$dbname = "employee_db"; 

// connection of msql
$conn = mysqli_connect($host, $user, $pass, $dbname);


if (!$conn) {
    // Stop the script and show the error message
    die("Connection to employee_db failed: " . mysqli_connect_error());
}
?>
