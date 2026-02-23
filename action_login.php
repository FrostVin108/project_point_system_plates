<?php
header('Content-Type: application/json');
session_start();
include 'database.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'login':
        $name = trim($_POST['name'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($name) || empty($password)) {
            echo json_encode(['success' => false, 'message' => 'Name & password wajib!']);
            exit;
        }

        // 🔥 PLAIN TEXT - SESUAI TABEL ANDA
        $stmt = $pdo->prepare("SELECT id, name, password, role FROM users WHERE name = ? AND password = ?");
        $stmt->execute([$name, $password]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            echo json_encode(['success' => true, 'role' => $user['role'], 'name' => $user['name']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Name atau password salah!']);
        }
        break;

    case 'logout':
        session_destroy();
        echo json_encode(['success' => true]);
        break;

    case 'check':
        if (isset($_SESSION['user_id'])) {
            echo json_encode([
                'success' => true,
                'user' => [
                    'id' => $_SESSION['user_id'],
                    'name' => $_SESSION['user_name'] ?? '',
                    'role' => $_SESSION['role'] ?? ''
                ]
            ]);
        } else {
            echo json_encode(['success' => false]);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Invalid action']);
}
?>