<?php
require_once __DIR__ . '/../config/Database.php'; // ako koristiš konekciju tu

class UserDao {
    public function get_all() {
        // zamijeni sa svojom logikom ako imaš bazu
        return [
            ["id" => 1, "name" => "Tarik"],
            ["id" => 2, "name" => "Jasenko"]
        ];
    }

    public function get_by_id($id) {
        return ["id" => $id, "name" => "Test"];
    }

    public function delete($id) {
        return true;
    }
}
