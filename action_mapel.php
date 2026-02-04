<?php
header('Content-Type: application/json');
include 'database.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'read':
        $stmt = $pdo->prepare("SELECT * FROM mapels ORDER BY name ASC");
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'get': // 🔥 GET single record untuk populate form
        $id = $_GET['id'] ?? 0;
        if ($id <= 0) {
            echo json_encode([]);
            exit;
        }

        $stmt = $pdo->prepare("SELECT * FROM mapels WHERE id = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
        break;

    case 'add':
        $name = trim($_POST['name'] ?? '');
        if (empty($name)) {
            echo json_encode(['success' => false, 'message' => 'Nama mapel wajib!']);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO mapels (name) VALUES (?)");
        $success = $stmt->execute([$name]);
        echo json_encode(['success' => $success]);
        break;

    case 'edit': // 🔥 POST untuk UPDATE
        $id = (int) ($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');

        if ($id <= 0 || empty($name)) {
            echo json_encode(['success' => false, 'message' => 'ID dan nama wajib!']);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE mapels SET name = ? WHERE id = ?");
        $success = $stmt->execute([$name, $id]);
        echo json_encode(['success' => $success]);
        break;

    case 'delete':
        $id = (int) ($_POST['id'] ?? 0);
        $stmt = $pdo->prepare("DELETE FROM mapels WHERE id = ?");
        $success = $stmt->execute([$id]);
        echo json_encode(['success' => $success]);
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Invalid action']);
        break;
}
?>