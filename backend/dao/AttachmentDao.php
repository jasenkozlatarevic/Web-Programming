<?php
require_once __DIR__ . '/BaseDao.php';

class AttachmentDao extends BaseDao {
    public function __construct($conn) {
        parent::__construct($conn);
        $this->table = 'attachments';
    }

    public function create($data) {
        return $this->insert($data);
    }

    public function getAllByNote($note_id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE note_id = ?");
        $stmt->execute([$note_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
