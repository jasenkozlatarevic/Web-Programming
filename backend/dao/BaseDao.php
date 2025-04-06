<?php

class BaseDao {
    protected $conn;
    protected $table;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function insert($data) {
        $keys = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} ($keys) VALUES ($placeholders)");
        $stmt->execute(array_values($data));
        return $this->conn->lastInsertId();
    }

    public function update($id, $data) {
        $fields = implode(", ", array_map(fn($key) => "$key = ?", array_keys($data)));
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET $fields WHERE id = ?");
        $stmt->execute([...array_values($data), $id]);
    }
}
