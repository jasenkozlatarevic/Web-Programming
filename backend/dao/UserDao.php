<?php
require_once __DIR__ . '/BaseDao.php';

class UserDao extends BaseDao {
    public function __construct($conn) {
        parent::__construct($conn);
        $this->table = 'users';
    }

    public function create($data) {
        return $this->insert($data);
    }
}

