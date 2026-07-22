<?php


// db settings
$host = "localhost";   // mysql host
$user = "root";        // mysql user
$pass = "";            // mysql password
$dbname = "hotel_db";  // database name

// establish connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection to hotel_db failed: " . mysqli_connect_error());
}
?>
