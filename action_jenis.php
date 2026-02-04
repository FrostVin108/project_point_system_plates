<?php
header('Content-Type: application/json');
include 'database.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'read':
        $stmt = $pdo->query("SELECT id, name, point FROM jenis_pelanggarans ORDER BY id");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'add':
        $stmt = $pdo->prepare("INSERT INTO jenis_pelanggarans (name, point) VALUES (?, ?)");
        $success = $stmt->execute([$_POST['name'], $_POST['point']]);
        echo json_encode(['success' => $success]);
        break;

    case 'edit':
        $stmt = $pdo->prepare("UPDATE jenis_pelanggarans SET name=?, point=? WHERE id=?");
        $success = $stmt->execute([$_POST['name'], $_POST['point'], $_POST['id']]);
        echo json_encode(['success' => $success]);
        break;

    case 'delete':
        $stmt = $pdo->prepare("DELETE FROM jenis_pelanggarans WHERE id=?");
        $success = $stmt->execute([$_POST['id']]);
        echo json_encode(['success' => $success]);
        break;
}
?>
