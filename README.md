# Hotel + Employee System (PHP, MySQLi, JSON API)

Two independent PHP/MySQL systems that talk to each other through a JSON API:

- **employee_system/** – stores employees, exposes them via `api.php` (JSON).
- **hotel_system/** – reservation form; gets its Employee dropdown by calling
  the Employee System's API (no local employee table).

No frameworks are used anywhere — plain HTML, CSS, JavaScript, PHP (MySQLi), and MySQL.

## How the two systems talk to each other

1. `employee_system/api.php` reads the `employee` table and prints it as JSON
   (`header("Content-Type: application/json"); echo json_encode($employees);`).
2. `hotel_system/fetch_employee.php` calls that API with
   `file_get_contents("http://localhost/employee_system/api.php")` and echoes
   the JSON straight back out.
3. `hotel_system/js/script.js` calls `fetch("fetch_employee.php")` from the
   browser and uses the result to build the `<option>` list in the
   reservation form's Employee dropdown. Each option's value is
   `employee_id|employee_name`.
4. When the reservation form is submitted, `hotel_system/create.php` runs
   `explode("|", $_POST['employee'])` to pull the id and name back apart and
   saves both into the `reservation` table.

## Setup instructions (XAMPP)

1. **Install XAMPP** and start **Apache** and **MySQL** from the XAMPP
   Control Panel.

2. **Copy the project folders** into your XAMPP web root so you end up with:

   ```
   C:\xampp\htdocs\employee_system\
   C:\xampp\htdocs\hotel_system\
   ```

   (On macOS/Linux this is usually `/Applications/XAMPP/htdocs/` or
   `/opt/lampp/htdocs/`.)

   Both folders must sit **side by side** directly inside `htdocs`, because
   the Hotel System calls the Employee System at
   `http://localhost/employee_system/api.php`.

3. **Create the databases.**
   Open **phpMyAdmin** (`http://localhost/phpmyadmin`), then:
   - Click **SQL**, paste the contents of
     `employee_system/database/employee_db.sql`, and run it. This creates
     `employee_db`, the `employee` table, and 10 sample employees.
   - Click **SQL** again, paste the contents of
     `hotel_system/database/hotel_db.sql`, and run it. This creates
     `hotel_db` and the empty `reservation` table.

4. **Check the database settings.**
   Both `db_config.php` files use the XAMPP defaults
   (`host = localhost`, `user = root`, `pass = ""`). If your MySQL setup is
   different, edit the values at the top of:
   - `employee_system/db_config.php`
   - `hotel_system/db_config.php`

5. **Test the Employee System first.**
   Visit `http://localhost/employee_system/index.php`
   - You should see the 10 sample employees listed.
   - Try adding a new employee with the form at the top.
   - Visit `http://localhost/employee_system/api.php` directly — you should
     see raw JSON employee data in the browser.

6. **Test the Hotel System.**
   Visit `http://localhost/hotel_system/index.php`
   - The Employee dropdown should automatically fill in with names pulled
     live from the Employee System's API.
   - Fill in Customer Name, Check-In, Check-Out, pick an Employee, and click
     **Save Reservation**.
   - You should see the message **"Reservation Saved Successfully"**.
   - Check the `reservation` table in phpMyAdmin (`hotel_db` database) to
     confirm the row was saved with the correct `employee_id` and
     `employee_name`.

## Folder structure

```
hotel_system/
├── index.php          # Reservation form (Employee dropdown starts empty)
├── create.php          # Handles form submission, saves reservation
├── db_config.php        # MySQLi connection to hotel_db
├── fetch_employee.php    # Calls employee_system/api.php, returns JSON
├── css/style.css
├── js/script.js         # Fetch API -> fills the Employee dropdown
└── database/hotel_db.sql

employee_system/
├── index.php          # Add Employee form + Employee list
├── add_employee.php    # Handles the "Add Employee" form
├── api.php              # JSON API: returns all employees
├── db_config.php        # MySQLi connection to employee_db
├── css/style.css
└── database/employee_db.sql
```

## Troubleshooting

- **Dropdown says "Could not load employees"** → Make sure Apache is running
  and the `employee_system` folder is reachable at
  `http://localhost/employee_system/api.php`. Also make sure
  `allow_url_fopen` is enabled in `php.ini` (it is enabled by default in
  XAMPP), since `fetch_employee.php` needs it for `file_get_contents()`.
- **"Connection failed" error** → Double-check the `$user` / `$pass` values
  in `db_config.php` and that MySQL is running in the XAMPP Control Panel.
- **Reservation not saving** → Confirm `hotel_db.sql` was run successfully
  and the `reservation` table exists in phpMyAdmin.
