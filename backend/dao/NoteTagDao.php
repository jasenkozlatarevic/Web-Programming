<?php

class NoteTagDao {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getTagsForNote($note_id) {
        $stmt = $this->conn->prepare("
            SELECT tags.* FROM tags 
            INNER JOIN note_tags ON tags.id = note_tags.tag_id 
            WHERE note_tags.note_id = ?
        ");
        $stmt->execute([$note_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addTagToNote($note_id, $tag_id) {
        $stmt = $this->conn->prepare("INSERT INTO note_tags (note_id, tag_id) VALUES (?, ?)");
        $stmt->execute([$note_id, $tag_id]);
    }

    public function removeTagFromNote($note_id, $tag_id) {
        $stmt = $this->conn->prepare("DELETE FROM note_tags WHERE note_id = ? AND tag_id = ?");
        $stmt->execute([$note_id, $tag_id]);
    }
}
