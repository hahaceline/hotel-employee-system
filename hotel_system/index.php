<?php
$employees = [];
$employeeDbFile = __DIR__ . '/../employee_system/db_config.php';
if (file_exists($employeeDbFile)) {
    include $employeeDbFile;
    if (!empty($conn)) {
        $sql = "SELECT id, employee_name FROM employee ORDER BY id ASC";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $employees[] = $row;
            }
            mysqli_free_result($result);
        }
        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>St. Celine Hotel - Reservation</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
       
        .receipt-overlay { margin-top: 20px; }
        .receipt-card { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); padding: 20px; border-radius: 16px; color: #fff; }
        .receipt-row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid rgba(255,255,255,0.06); }
        .receipt-row:last-child { border-bottom: none; }
        .receipt-title { font-family: 'Playfair Display', serif; font-size:22px; margin:0 0 8px 0; }
    </style>
</head>
<body>
    <div class="reservation-page">
        <div class="page-overlay"></div>

        <div class="promo-card">
            <h2 class="promo-title">St. Celine Hotel</h2>
            <p class="promo-text">Experience refined comfort and heartfelt service. Book a stay and enjoy our curated hospitality.</p>
            <div class="promo-footer">
                <div class="dot active"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>

        <div class="reservation-card">
            <div class="top-logo">
                <div class="logo-icon">SC</div>
                <div class="logo-text">St. Celine</div>
            </div>

            <div class="reservation-header">
                <h1>Reserve your stay</h1>
                <p class="reservation-subtitle">Simple booking — quick confirmation</p>
            </div>

            <form id="reservationForm" class="reservation-form" action="create.php" method="post">
                <div class="field-group">
                    <label class="field-step">01 NAME OF CUSTOMER</label>
                    <input id="customer_name" name="customer_name" class="custom-input" type="text" />
                </div>

                <div class="date-row">
                    <div class="field-group">
                        <label class="field-step">02 CHECK IN</label>
                        <input id="check_in" name="check_in" class="custom-input" type="date" />
                    </div>
                    <div class="field-group">
                        <label class="field-step">03 CHECK OUT</label>
                        <input id="check_out" name="check_out" class="custom-input" type="date" />
                    </div>
                </div>

                <div class="field-group">
                    <label class="field-step">04 ATTENDING EMPLOYEE</label>
                    <select id="employee" name="employee" class="custom-select">
                        <?php if (count($employees) > 0): ?>
                            <option value="" selected disabled>▼ Select Employee</option>
                            <?php foreach ($employees as $employee): ?>
                                <option value="<?= htmlspecialchars($employee['id'], ENT_QUOTES) ?>" data-name="<?= htmlspecialchars($employee['employee_name'], ENT_QUOTES) ?>"><?= htmlspecialchars($employee['employee_name']) ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="" disabled>No employees available</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="field-group">
                    <label class="field-step">05 EMPLOYEE ID (AUTO-FILLED)</label>
                    <input id="employee_id" name="employee_id" class="custom-input" readonly />
                    <input id="employee_name" name="employee_name" type="hidden" />
                </div>

                <button id="reserveBtn" type="submit" class="reserve-button">Create Reservation</button>
            </form>

            <div id="receipt" class="receipt-overlay" style="display:none;">
                <div class="receipt-card">
                    <div class="receipt-title">Reservation Confirmed</div>
                    <div class="receipt-row"><div>Booking ID</div><div id="r_booking">SC-XXXXX</div></div>
                    <div class="receipt-row"><div>Guest</div><div id="r_name"></div></div>
                    <div class="receipt-row"><div>Check-In</div><div id="r_checkin"></div></div>
                    <div class="receipt-row"><div>Check-Out</div><div id="r_checkout"></div></div>
                    <div class="receipt-row"><div>Employee</div><div id="r_employee"></div></div>
                    <div class="receipt-row"><div>Employee ID</div><div id="r_employee_id"></div></div>
                    <div style="text-align:center; margin-top:12px;"><button id="newBtn" class="reserve-button">New Reservation</button></div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/script.js?v=2"></script>
    <script>
        
        (function(){
            const form = document.getElementById('reservationForm');
            const receipt = document.getElementById('receipt');
            const newBtn = document.getElementById('newBtn');

            function genBookingId(){
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                let id = 'SC-';
                for(let i=0;i<6;i++) id += chars.charAt(Math.floor(Math.random()*chars.length));
                return id;
            }

            form.addEventListener('submit', function(e){
                e.preventDefault();
                const formData = new FormData(form);
                const name = formData.get('customer_name')?.toString().trim();
                const checkin = formData.get('check_in')?.toString();
                const checkout = formData.get('check_out')?.toString();
                const employeeId = formData.get('employee')?.toString();
                const employee = formData.get('employee_name')?.toString();

                if(!name || !checkin || !checkout || !employeeId){
                    alert('Please complete all fields');
                    return;
                }

                fetch('create.php', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert(data.error || 'Unable to save reservation.');
                        return;
                    }

                    document.getElementById('r_booking').textContent = genBookingId();
                    document.getElementById('r_name').textContent = name;
                    document.getElementById('r_checkin').textContent = checkin;
                    document.getElementById('r_checkout').textContent = checkout;
                    document.getElementById('r_employee').textContent = employee;
                    document.getElementById('r_employee_id').textContent = employeeId;

                    form.style.display = 'none';
                    receipt.style.display = 'block';
                })
                .catch(() => {
                    alert('Unable to save reservation. Please try again.');
                });
            });

            newBtn.addEventListener('click', function(){
                form.reset();
                document.getElementById('employee_id').value = '';
                document.getElementById('employee_name').value = '';
                receipt.style.display = 'none';
                form.style.display = '';
            });
        })();
    </script>
</body>
</html>
