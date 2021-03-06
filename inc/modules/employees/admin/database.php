<?php

class Employees_Database extends Database {

    public function is_valid($fields) {
        return $this->query_for_one("SELECT COUNT(*) FROM employees WHERE mail = :mail AND password = :password", $fields);
    }

    public function insert(array $fields) {
        $this->run("INSERT INTO employees (id, first_name, last_name, mail, password, role_id) VALUES (null, :first_name, :last_name, :mail, :password, :role)", $fields);
    }

    public function update(array $fields) {
        $this->run("UPDATE employees SET first_name = :first_name, last_name = :last_name, mail = :mail, role_id = :role WHERE id = :employee_id", $fields);
    }

    public function get($employee_id) {
        $fields = array('employee_id' => $employee_id);
        return $this->query_for_row("SELECT id, first_name, last_name, mail, role_id FROM employees WHERE id = :employee_id", $fields);
    }

    public function get_by_mail($mail) {
        $fields = array('mail' => $mail);
        return $this->query_for_row("SELECT id, first_name, last_name, mail, role_id FROM employees WHERE mail = :mail", $fields);
    }

    public function all() {
        return $this->query("SELECT id, first_name, last_name, mail, role_id FROM employees");
    }

    // Roles

    public function roles_all() {
        return $this->query("SELECT name role FROM roles ORDER BY name");
    }

    public function roles_all_options() {
        return $this->query("SELECT id, name FROM roles ORDER BY name");
    }

    public function roles_all_paths() {
        return $this->query("SELECT p.path, r.role, coalesce(j.role, '0') checked FROM (SELECT * FROM employee_roles WHERE role = 'Admin') p INNER JOIN (SELECT DISTINCT role FROM employee_roles WHERE role != 'Admin') r LEFT JOIN employee_roles j ON p.path = j.path AND r.role = j.role ORDER BY p.path, r.role");
    }

    public function roles_insert($path, $role) {
        $this->run("INSERT INTO employee_roles VALUES (?, ?)", array($role, $path));
    }

    public function roles_delete($path, $role) {
        $this->run("DELETE FROM employee_roles WHERE role = ? AND path = ?", array($role, $path));
    }
}
