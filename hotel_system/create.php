<?php

include "db_config.php";
$hotelConn = $conn;
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $customer_name = trim($_POST['customer_name'] ?? '');
    $check_in      = trim($_POST['check_in'] ?? '');
    $check_out     = trim($_POST['check_out'] ?? '');
    $employee_id   = isset($_POST['employee']) ? (int) $_POST['employee'] : 0;
    $employee_name = trim($_POST['employee_name'] ?? '');

    if ($customer_name === '' || $check_in === '' || $check_out === '' || $employee_id <= 0 || $employee_name === '') {
        $error = 'Invalid reservation data. Please complete the form correctly.';
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => $error]);
        } else {
            echo $error;
        }
        mysqli_close($hotelConn);
        exit;
    }

    $insertQuery = "INSERT INTO reservation (customer_name, check_in, check_out, employee_id, employee_name) VALUES (?, ?, ?, ?, ?)";
    $insertStmt = mysqli_prepare($hotelConn, $insertQuery);
    if ($insertStmt) {
        mysqli_stmt_bind_param($insertStmt, 'sssis', $customer_name, $check_in, $check_out, $employee_id, $employee_name);
        if (mysqli_stmt_execute($insertStmt)) {
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
            } else {
                echo "<h2 style='text-align:center; font-family:Arial, sans-serif; color:#1e7e34;'>Reservation Saved Successfully</h2>";
                echo "<p style='text-align:center;'><a href='index.php'>Back to Reservation Form</a></p>";
            }
        } else {
            $error = 'Error saving reservation: ' . mysqli_error($hotelConn);
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => $error]);
            } else {
                echo $error;
            }
        }
        mysqli_stmt_close($insertStmt);
    } else {
        $error = 'Database error: ' . mysqli_error($hotelConn);
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => $error]);
        } else {
            echo $error;
        }
    }
}

mysqli_close($hotelConn);
?>
