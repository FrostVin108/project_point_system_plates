<?php
ob_clean();
header('Content-Type: application/json; charset=utf-8');

try {
    include 'database.php';
    $action = $_GET['action'] ?? $_POST['action'] ?? '';

    switch ($action) {

        // ── READ ─────────────────────────────────────────────────────
        case 'read':
            $stmt = $pdo->prepare("
                SELECT g.*,
                       m.name AS mapel_name,
                       u.id   AS user_id,
                       u.name AS user_name,
                       u.role AS user_role,
                       CASE WHEN g.id_user IS NOT NULL THEN 'Assigned' ELSE 'Belum Assign' END AS user_status
                FROM gurus g
                LEFT JOIN mapels m ON g.id_mapel = m.id
                LEFT JOIN users  u ON g.id_user  = u.id
                ORDER BY g.name ASC
            ");
            $stmt->execute();
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
            exit;

        // ── GET (untuk form edit) ─────────────────────────────────────
        case 'get':
            $id = (int) ($_GET['id'] ?? 0);
            $stmt = $pdo->prepare("
                SELECT g.*,
                       m.name AS mapel_name,
                       u.id   AS user_id,
                       u.name AS user_name,
                       u.role AS user_role
                FROM gurus g
                LEFT JOIN mapels m ON g.id_mapel = m.id
                LEFT JOIN users  u ON g.id_user  = u.id
                WHERE g.id = ?
            ");
            $stmt->execute([$id]);
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
            exit;

        // ── DETAIL (modal detail + password) ─────────────────────────
        case 'detail':
            $id = (int) ($_GET['id'] ?? 0);
            if ($id === 0) {
                echo json_encode(['success' => false]);
                exit;
            }
            $stmt = $pdo->prepare("
                SELECT g.*,
                       m.name     AS mapel_name,
                       u.id       AS user_id,
                       u.name     AS user_name,
                       u.password AS user_password,
                       u.role     AS user_role
                FROM gurus g
                LEFT JOIN mapels m ON g.id_mapel = m.id
                LEFT JOIN users  u ON g.id_user  = u.id
                WHERE g.id = ?
            ");
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($data ?: ['success' => false], JSON_UNESCAPED_UNICODE);
            exit;

        // ── ASSIGN_USERS (dropdown — role=guru, belum dipakai) ────────
        case 'assign_users':
            $stmt = $pdo->prepare("
                SELECT u.id, u.name
                FROM users u
                WHERE u.role = 'guru'
                AND u.id NOT IN (
                    SELECT DISTINCT id_user FROM gurus WHERE id_user IS NOT NULL
                )
                ORDER BY u.name ASC
            ");
            $stmt->execute();
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
            exit;

        // ── USERS (Select2 search — role=guru saja) ──────────────────
        case 'users':
            $search = trim($_GET['search'] ?? '');
            if ($search !== '') {
                $stmt = $pdo->prepare("
                    SELECT id, name FROM users
                    WHERE name LIKE ? AND role = 'guru'
                    ORDER BY name ASC LIMIT 50
                ");
                $stmt->execute(["%$search%"]);
            } else {
                $stmt = $pdo->query("
                    SELECT id, name FROM users
                    WHERE role = 'guru'
                    ORDER BY name ASC LIMIT 100
                ");
            }
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
            exit;

        // ── ASSIGN ───────────────────────────────────────────────────
        case 'assign':
            $guru_id = (int) ($_POST['guru_id'] ?? 0);
            $user_id = (int) ($_POST['user_id'] ?? 0);

            if ($guru_id === 0 || $user_id === 0) {
                echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
                exit;
            }

            // Validasi role harus guru
            $chkRole = $pdo->prepare("SELECT id FROM users WHERE id = ? AND role = 'guru'");
            $chkRole->execute([$user_id]);
            if (!$chkRole->fetch()) {
                echo json_encode(['success' => false, 'message' => 'User bukan role guru']);
                exit;
            }

            // Cek user sudah dipakai guru lain
            $chkAssigned = $pdo->prepare("SELECT id FROM gurus WHERE id_user = ? AND id != ?");
            $chkAssigned->execute([$user_id, $guru_id]);
            if ($chkAssigned->fetch()) {
                echo json_encode(['success' => false, 'message' => 'User sudah diassign ke guru lain']);
                exit;
            }

            $stmt = $pdo->prepare("UPDATE gurus SET id_user = ? WHERE id = ?");
            $success = $stmt->execute([$user_id, $guru_id]);
            echo json_encode(['success' => $success], JSON_UNESCAPED_UNICODE);
            exit;

        // ── UNASSIGN (lepas user dari guru) ──────────────────────────
        case 'unassign':
            $guru_id = (int) ($_POST['guru_id'] ?? 0);
            if ($guru_id === 0) {
                echo json_encode(['success' => false, 'message' => 'ID guru tidak valid']);
                exit;
            }
            $stmt = $pdo->prepare("UPDATE gurus SET id_user = NULL WHERE id = ?");
            $success = $stmt->execute([$guru_id]);
            echo json_encode(['success' => $success], JSON_UNESCAPED_UNICODE);
            exit;

        // ── ADD ──────────────────────────────────────────────────────
        case 'add':
            $name = trim($_POST['name'] ?? '');
            $nohp = trim($_POST['no_handphone'] ?? '');

            if (empty($name) || empty($nohp)) {
                echo json_encode(['success' => false, 'message' => 'Nama & No HP wajib!']);
                exit;
            }

            $stmt = $pdo->prepare("
                INSERT INTO gurus (name, no_handphone, id_mapel, id_user, alamat)
                VALUES (?, ?, ?, ?, ?)
            ");
            $success = $stmt->execute([
                $name,
                $nohp,
                !empty($_POST['id_mapel']) ? (int) $_POST['id_mapel'] : null,
                !empty($_POST['id_user']) ? (int) $_POST['id_user'] : null,
                trim($_POST['alamat'] ?? '')
            ]);
            echo json_encode(['success' => $success], JSON_UNESCAPED_UNICODE);
            exit;

        // ── EDIT ─────────────────────────────────────────────────────
        case 'edit':
            $id = (int) ($_POST['id'] ?? 0);
            $name = trim($_POST['name'] ?? '');
            $nohp = trim($_POST['no_handphone'] ?? '');

            if (empty($name) || empty($nohp)) {
                echo json_encode(['success' => false, 'message' => 'Nama & No HP wajib!']);
                exit;
            }

            $stmt = $pdo->prepare("
                UPDATE gurus
                SET name=?, no_handphone=?, id_mapel=?, id_user=?, alamat=?
                WHERE id=?
            ");
            $success = $stmt->execute([
                $name,
                $nohp,
                !empty($_POST['id_mapel']) ? (int) $_POST['id_mapel'] : null,
                !empty($_POST['id_user']) ? (int) $_POST['id_user'] : null,
                trim($_POST['alamat'] ?? ''),
                $id
            ]);
            echo json_encode(['success' => $success], JSON_UNESCAPED_UNICODE);
            exit;

        // ── DELETE ───────────────────────────────────────────────────
        case 'delete':
            $id = (int) ($_POST['id'] ?? 0);
            if ($id === 0) {
                echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
                exit;
            }
            $stmt = $pdo->prepare("DELETE FROM gurus WHERE id = ?");
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