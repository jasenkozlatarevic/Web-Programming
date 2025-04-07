<?php
require_once __DIR__ . '/BaseDao.php';

class TagDao extends BaseDao {
    public function __construct($conn) {
        parent::__construct($conn);
        $this->table = 'tags';
    }

    public function create($data) {
        return $this->insert($data);
    }

    public function updateTag($id, $data) {
        $this->update($id, $data);
    }
}
