<?php

include "db_config.php";


$sql = "SELECT id, employee_name, position, department FROM employee ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="card">
        <div class="header">
            <h1>Employee Management System</h1>
        </div>

        <div class="content">

            <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
                <p class="success-message">Employee Added Successfully</p>
            <?php endif; ?>

            
            <h2>Add New Employee</h2>
            <form action="add_employee.php" method="POST">

                <label for="employee_name">Employee Name</label>
                <input type="text" id="employee_name" name="employee_name" required>

                <label for="position">Position</label>
                <input type="text" id="position" name="position" required>

                <label for="department">Department</label>
                <input type="text" id="department" name="department" required>

                <button type="submit">Add Employee</button>
            </form>

            <hr>

            
            <h2>Employee List</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['employee_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['position']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['department']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

            <p class="api-note">
                JSON API available at: <code>api.php</code>
            </p>

        </div>
    </div>

</body>
</html>
<?php mysqli_close($conn); ?>
