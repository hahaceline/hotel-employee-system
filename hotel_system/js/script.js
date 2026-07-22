document.addEventListener('DOMContentLoaded', function () {
    const employeeSelect = document.getElementById('employee');
    const employeeIdInput = document.getElementById('employee_id');
    const employeeNameInput = document.getElementById('employee_name');

    if (!employeeSelect || !employeeIdInput || !employeeNameInput) {
        return;
    }

    function setEmployeeFields(option) {
        if (!option || !option.value) {
            employeeIdInput.value = '';
            employeeNameInput.value = '';
            return;
        }
        employeeIdInput.value = option.value;
        employeeNameInput.value = option.dataset.name || '';
    }

    employeeSelect.addEventListener('change', function () {
        setEmployeeFields(employeeSelect.options[employeeSelect.selectedIndex]);
    });
});
