<?php
ob_clean();
header('Content-Type: application/json; charset=utf-8');

try {
    include 'database.php';
    $action = $_GET['action'] ?? $_POST['action'] ?? '';

    switch ($action) {

        // ── READ ──────────────────────────────────────────────────────
        case 'read':
            $stmt = $pdo->query("SELECT id, name, role FROM users ORDER BY id ASC");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
            exit;

        // ── GET single ────────────────────────────────────────────────
        case 'get':
            $id = (int) ($_GET['id'] ?? 0);
            if ($id === 0) {
                echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
                exit;
            }
            $stmt = $pdo->prepare("SELECT id, name, role FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($data ?: ['success' => false, 'message' => 'User tidak ditemukan'], JSON_UNESCAPED_UNICODE);
            exit;

        // ── ADD ───────────────────────────────────────────────────────
        case 'add':
            $name = trim($_POST['name'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $role = trim($_POST['role'] ?? '');

            if (empty($name) || empty($password) || empty($role)) {
                echo json_encode(['success' => false, 'message' => 'Nama, password, dan role wajib diisi!']);
                exit;
            }

            // Cek duplikat nama
            $chk = $pdo->prepare("SELECT id FROM users WHERE name = ?");
            $chk->execute([$name]);
            if ($chk->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Nama user sudah digunakan!']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO users (name, password, role) VALUES (?, ?, ?)");
            $success = $stmt->execute([$name, $password, $role]);
            echo json_encode(['success' => $success], JSON_UNESCAPED_UNICODE);
            exit;

        // ── EDIT ──────────────────────────────────────────────────────
        case 'edit':
            $id = (int) ($_POST['id'] ?? 0);
            $name = trim($_POST['name'] ?? '');
            $role = trim($_POST['role'] ?? '');
            $password = trim($_POST['password'] ?? ''); // kosong = tidak ganti

            if ($id === 0 || empty($name) || empty($role)) {
                echo json_encode(['success' => false, 'message' => 'ID, nama, dan role wajib!']);
                exit;
            }

            // Cek duplikat nama (kecuali diri sendiri)
            $chk = $pdo->prepare("SELECT id FROM users WHERE name = ? AND id != ?");
            $chk->execute([$name, $id]);
            if ($chk->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Nama sudah digunakan user lain!']);
                exit;
            }

            if ($password !== '') {
                $stmt = $pdo->prepare("UPDATE users SET name=?, password=?, role=? WHERE id=?");
                $success = $stmt->execute([$name, $password, $role, $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE users SET name=?, role=? WHERE id=?");
                $success = $stmt->execute([$name, $role, $id]);
            }

            echo json_encode(['success' => $success], JSON_UNESCAPED_UNICODE);
            exit;

        // ── DELETE ────────────────────────────────────────────────────
        case 'delete':
            $id = (int) ($_POST['id'] ?? 0);
            if ($id === 0) {
                echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
                exit;
            }

            // Lepas relasi agar tidak orphan
            $pdo->prepare("UPDATE siswas SET id_user = NULL WHERE id_user = ?")->execute([$id]);
            $pdo->prepare("UPDATE gurus  SET id_user = NULL WHERE id_user = ?")->execute([$id]);

            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $success = $stmt->execute([$id]);
            echo json_encode(['success' => $success], JSON_UNESCAPED_UNICODE);
            exit;

        default:
            http_response_code(404);
            echo json_encode(['error' => 'Invalid action']);
            exit;
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server Error: ' . $e->getMessage()]);
    exit;
}
?>