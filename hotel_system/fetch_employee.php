<?php

// calls the employee system json with api using
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? ($_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']);
$api_url = $scheme . '://' . $host . '/employee_system/api.php';


header("Content-Type: application/json");

// call the Employee System API 
$json_data = false;
if (ini_get('allow_url_fopen')) {
    $json_data = @file_get_contents($api_url);
}

if ($json_data !== false && trim($json_data) !== '') {
    $decoded = json_decode($json_data, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        echo json_encode($decoded);
        return;
    }
}

// if the HTTP request failed or returned invalid JSON, fall back to a local DB query.
$employeeDbFile = __DIR__ . '/../employee_system/db_config.php';
if (file_exists($employeeDbFile)) {
    include $employeeDbFile;

    if ($conn) {
        $sql = "SELECT id, employee_name, position, department FROM employee";
        $result = mysqli_query($conn, $sql);
        $employees = [];

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $employees[] = $row;
            }
        }

        mysqli_close($conn);
        echo json_encode($employees);
        return;
    }
}

// return empty array
echo json_encode([]);
?>
