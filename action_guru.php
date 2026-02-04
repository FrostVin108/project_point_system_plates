<?php
header('Content-Type: application/json');
include 'database.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'read':
        $stmt = $pdo->prepare("
            SELECT g.*, m.name as mapel_name, 
                   u.name as user_name     -- 🔥 TAMBAH INI
            FROM gurus g 
            LEFT JOIN mapels m ON g.id_mapel = m.id 
            LEFT JOIN users u ON g.id_user = u.id  -- 🔥 TAMBAH INI
            ORDER BY g.name ASC
        ");
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'get':
        $id = $_GET['id'] ?? 0;
        $stmt = $pdo->prepare("SELECT * FROM gurus WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'add':
        $data = [
            $_POST['name'] ?? '',
            $_POST['no_handphone'] ?? '',
            $_POST['id_mapel'] ?? null,
            $_POST['id_user'] ?? null,
            $_POST['alamat'] ?? ''
        ];

        if (empty($data[0]) || $data[1] == 0) {
            echo json_encode(['success' => false, 'message' => 'Nama & No HP wajib!']);
            exit;
        }

        $stmt = $pdo->prepare("INSERT INTO gurus (name, no_handphone, id_mapel, id_user, alamat) VALUES (?, ?, ?, ?, ?)");
        $success = $stmt->execute($data);
        echo json_encode(['success' => $success]);
        break;

    case 'edit':
        $id = (int) ($_POST['id'] ?? 0);
        $data = [
            $_POST['name'] ?? '',
            (int) ($_POST['no_handphone'] ?? 0),
            $_POST['id_mapel'] ?? null,
            $_POST['id_user'] ?? null,
            $_POST['alamat'] ?? '',
            $id
        ];

        $stmt = $pdo->prepare("UPDATE gurus SET name=?, no_handphone=?, id_mapel=?, id_user=?, alamat=? WHERE id=?");
        $success = $stmt->execute($data);
        echo json_encode(['success' => $success]);
        break;

    case 'delete':
        $id = (int) ($_POST['id'] ?? 0);
        $stmt = $pdo->prepare("DELETE FROM gurus WHERE id=?");
        $success = $stmt->execute([$id]);
        echo json_encode(['success' => $success]);
        break;

    // 🔥 TAMBAH CASE INI UNTUK SELECT2 USER SEARCH
    case 'users':
        $search = $_GET['search'] ?? '';
        if ($search) {
            $stmt = $pdo->prepare("SELECT id, name FROM users WHERE name LIKE ? ORDER BY name ASC LIMIT 50");
            $stmt->execute(["%$search%"]);
        } else {
            $stmt = $pdo->query("SELECT id, name FROM users ORDER BY name ASC LIMIT 100");
        }
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Invalid action']);
}
?>
