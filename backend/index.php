<?php
header('Content-Type: application/json');

require_once __DIR__ . '/dao/NoteDao.php';
require_once __DIR__ . '/dao/UserDao.php';

$db = new PDO("mysql:host=localhost;dbname=notes_app;charset=utf8", "root", "your_password");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// ===== NOTES API =====
$noteDao = new NoteDao($db);

if ($uri === '/notes' && $method === 'GET') {
    echo json_encode($noteDao->getAll());
}
elseif (preg_match('#^/notes/user/(\d+)$#', $uri, $matches) && $method === 'GET') {
    echo json_encode($noteDao->getByUser($matches[1]));
}
elseif ($uri === '/notes' && $method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    echo json_encode(['id' => $noteDao->create($data)]);
}
elseif (preg_match('#^/notes/(\d+)$#', $uri, $matches) && $method === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $noteDao->updateNote($matches[1], $data);
    echo json_encode(['message' => 'Note updated']);
}
elseif (preg_match('#^/notes/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    $noteDao->delete($matches[1]);
    echo json_encode(['message' => 'Note deleted']);
}
// ===== TAGS API =====
$tagDao = new TagDao($db);

if ($uri === '/tags' && $method === 'GET') {
    echo json_encode($tagDao->getAll());
}
elseif ($uri === '/tags' && $method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    echo json_encode(['id' => $tagDao->create($data)]);
}
elseif (preg_match('#^/tags/(\d+)$#', $uri, $matches) && $method === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $tagDao->updateTag($matches[1], $data);
    echo json_encode(['message' => 'Tag updated']);
}
elseif (preg_match('#^/tags/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    $tagDao->delete($matches[1]);
    echo json_encode(['message' => 'Tag deleted']);
}
// ===== NOTE_TAGS API =====
$noteTagDao = new NoteTagDao($db);

if (preg_match('#^/note_tags/(\d+)$#', $uri, $matches) && $method === 'GET') {
    echo json_encode($noteTagDao->getTagsForNote($matches[1]));
}
elseif ($uri === '/note_tags' && $method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $noteTagDao->addTagToNote($data['note_id'], $data['tag_id']);
    echo json_encode(['message' => 'Tag added to note']);
}
elseif ($uri === '/note_tags' && $method === 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);
    $noteTagDao->removeTagFromNote($data['note_id'], $data['tag_id']);
    echo json_encode(['message' => 'Tag removed from note']);
}
// ===== ATTACHMENTS API =====
$attachmentDao = new AttachmentDao($db);

if (preg_match('#^/attachments/note/(\d+)$#', $uri, $matches) && $method === 'GET') {
    echo json_encode($attachmentDao->getAllByNote($matches[1]));
}
elseif ($uri === '/attachments' && $method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    echo json_encode(['id' => $attachmentDao->create($data)]);
}
elseif (preg_match('#^/attachments/(\d+)$#', $uri, $matches) && $method === 'DELETE') {
    $attachmentDao->delete($matches[1]);
    echo json_encode(['message' => 'Attachment deleted']);
}

// ===== USERS API =====
$userDao = new UserDao($db);

if ($uri === '/users' && $method === 'GET') {
    echo json_encode($userDao->getAll());
}
elseif ($uri === '/users' && $method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    echo json_encode(['id' => $userDao->create($data)]);
}

else {
    http_response_code(404);
    echo json_encode(['error' => 'Route not found']);
}
