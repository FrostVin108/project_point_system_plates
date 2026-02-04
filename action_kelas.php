<?php
header('Content-Type: application/json');
include 'database.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'read':
        $stmt = $pdo->query("SELECT id, tingkat, jurusan, kelas FROM kelas ORDER BY id");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;
    case 'add':
        $stmt = $pdo->prepare("INSERT INTO kelas (tingkat, jurusan, kelas) VALUES (?, ?, ?)");
        $success = $stmt->execute([$_POST['tingkat'], $_POST['jurusan'], $_POST['kelas']]);
        echo json_encode(['success' => $success]);
        break;
    case 'edit':
        $stmt = $pdo->prepare("UPDATE kelas SET tingkat=?, jurusan=?, kelas=? WHERE id=?");
        $success = $stmt->execute([$_POST['tingkat'], $_POST['jurusan'], $_POST['kelas'], $_POST['id']]);
        echo json_encode(['success' => $success]);
        break;
    case 'delete':
        $stmt = $pdo->prepare("DELETE FROM kelas WHERE id=?");
        $success = $stmt->execute([$_POST['id']]);
        echo json_encode(['success' => $success]);
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Invalid action']);
}
?>
