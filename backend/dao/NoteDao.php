<?php
require_once __DIR__ . '/BaseDao.php';

class NoteDao extends BaseDao {
    public function __construct($conn) {
        parent::__construct($conn);
        $this->table = 'notes';
    }

    public function create($data) {
        return $this->insert($data);
    }

    public function updateNote($id, $data) {
        $this->update($id, $data);
    }

    public function getByUser($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
