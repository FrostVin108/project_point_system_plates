<?php
ob_clean();
header('Content-Type: application/json; charset=utf-8');

try {
    include 'database.php';
    $action = $_GET['action'] ?? $_POST['action'] ?? '';

    switch ($action) {
        case 'read':
            $stmt = $pdo->prepare("
                SELECT s.*, 
                       k.tingkat, k.jurusan, k.kelas as kelas_name,
                       CONCAT(COALESCE(k.tingkat, ''), ' ', COALESCE(k.jurusan, ''), ' ', COALESCE(k.kelas, '')) as kelas_full,
                       CASE WHEN s.id_user IS NOT NULL THEN 'Assigned' ELSE 'Belum Assign' END as user_status
                FROM siswas s 
                LEFT JOIN kelas k ON s.id_kelas = k.id 
                ORDER BY s.id DESC
            ");
            $stmt->execute();
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
            exit;
            break;

        case 'edit':
            $id = (int) ($_GET['id'] ?? 0);
            if ($id == 0) {
                echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
                exit;
            }
            $stmt = $pdo->prepare("
                SELECT s.*, k.tingkat, k.jurusan, k.kelas as kelas_name
                FROM siswas s 
                LEFT JOIN kelas k ON s.id_kelas = k.id 
                WHERE s.id = ?
            ");
            $stmt->execute([$id]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            exit;
            break;

        case 'detail':
            $id = (int) ($_GET['id'] ?? 0);
            if ($id == 0) {
                echo json_encode(['success' => false]);
                exit;
            }
            $stmt = $pdo->prepare("
                SELECT s.*, 
                       k.tingkat, k.jurusan, k.kelas as kelas_name,
                       u.id as user_id, u.name as user_name, u.password as user_password, u.role
                FROM siswas s 
                LEFT JOIN kelas k ON s.id_kelas = k.id
                LEFT JOIN users u ON s.id_user = u.id
                WHERE s.id = ?
            ");
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($data ?: ['success' => false], JSON_UNESCAPED_UNICODE);
            exit;
            break;

        case 'assign_users':
            $stmt = $pdo->prepare("
                SELECT u.id, u.name, u.password 
                FROM users u 
                WHERE u.role = 'siswa' 
                AND u.id NOT IN (
                    SELECT DISTINCT id_user FROM siswas WHERE id_user IS NOT NULL
                )
                ORDER BY u.name ASC
            ");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            exit;
            break;

        case 'update':
            $name = trim($_POST['name'] ?? '');
            $nis = trim($_POST['nis'] ?? '');

            if (empty($name) || empty($nis)) {
                echo json_encode(['success' => false, 'message' => 'Nama & NIS wajib!']);
                exit;
            }

            $stmt = $pdo->prepare("
                UPDATE siswas SET 
                    name = ?, nis = ?, id_kelas = ?, name_orang_tua = ?, 
                    pekerjaan_orang_tua = ?, alamat_orang_tua = ?, alamat = ?, 
                    telphone_orang_tua = ?, telphone = ?, detail = ?, point = ?, id_user = ?
                WHERE id = ?
            ");

            $success = $stmt->execute([
                $name,
                $nis,
                !empty($_POST['id_kelas']) ? (int) $_POST['id_kelas'] : null,
                trim($_POST['name_orang_tua'] ?? ''),
                trim($_POST['pekerjaan_orang_tua'] ?? ''),
                trim($_POST['alamat_orang_tua'] ?? ''),
                trim($_POST['alamat'] ?? ''),
                trim($_POST['telphone_orang_tua'] ?? ''),
                trim($_POST['telphone'] ?? ''),
                trim($_POST['detail'] ?? ''),
                (int) ($_POST['point'] ?? 0),
                !empty($_POST['id_user']) ? (int) $_POST['id_user'] : null,
                (int) ($_POST['id'] ?? 0)
            ]);
            echo json_encode(['success' => $success]);
            exit;
            break;

        case 'add':
            $name = trim($_POST['name'] ?? '');
            $nis = trim($_POST['nis'] ?? '');

            if (empty($name) || empty($nis)) {
                echo json_encode(['success' => false, 'message' => 'Nama & NIS wajib!']);
                exit;
            }

            $stmt = $pdo->prepare("
                INSERT INTO siswas (
                    name, nis, id_kelas, name_orang_tua, pekerjaan_orang_tua,
                    alamat_orang_tua, alamat, telphone_orang_tua, telphone, 
                    detail, point, sp, id_user, created_at
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
            ");

            $success = $stmt->execute([
                $name,
                $nis,
                !empty($_POST['id_kelas']) ? (int) $_POST['id_kelas'] : null,
                trim($_POST['name_orang_tua'] ?? ''),
                trim($_POST['pekerjaan_orang_tua'] ?? ''),
                trim($_POST['alamat_orang_tua'] ?? ''),
                trim($_POST['alamat'] ?? ''),
                trim($_POST['telphone_orang_tua'] ?? ''),
                trim($_POST['telphone'] ?? ''),
                trim($_POST['detail'] ?? ''),
                0,
                0,
                null
            ]);
            echo json_encode(['success' => $success]);
            exit;
            break;

        case 'assign':
            $siswa_id = (int) ($_POST['siswa_id'] ?? 0);
            $user_id  = (int) ($_POST['user_id']  ?? 0);

            if ($siswa_id == 0 || $user_id == 0) {
                echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
                exit;
            }

            $checkRole = $pdo->prepare("SELECT id FROM users WHERE id = ? AND role = 'siswa'");
            $checkRole->execute([$user_id]);
            if (!$checkRole->fetch()) {
                echo json_encode(['success' => false, 'message' => 'User bukan role siswa']);
                exit;
            }

            $checkAssigned = $pdo->prepare("SELECT id FROM siswas WHERE id_user = ? AND id != ?");
            $checkAssigned->execute([$user_id, $siswa_id]);
            if ($checkAssigned->fetch()) {
                echo json_encode(['success' => false, 'message' => 'User sudah diassign ke siswa lain']);
                exit;
            }

            $stmt = $pdo->prepare("UPDATE siswas SET id_user = ? WHERE id = ?");
            $success = $stmt->execute([$user_id, $siswa_id]);
            echo json_encode(['success' => $success]);
            exit;
            break;

        // ============================================================
        // ACTION: issue_sp
        // Reset point → 0, tambah sp +1
        // Status ditentukan dari nilai sp (0 = Aman, >=1 = Warned)
        // ============================================================
        case 'issue_sp':
            $id = (int) ($_POST['id'] ?? 0);
            if ($id == 0) {
                echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
                exit;
            }

            // Ambil data siswa dulu untuk validasi point >= 100
            $check = $pdo->prepare("SELECT id, point, sp FROM siswas WHERE id = ?");
            $check->execute([$id]);
            $siswa = $check->fetch(PDO::FETCH_ASSOC);

            if (!$siswa) {
                echo json_encode(['success' => false, 'message' => 'Siswa tidak ditemukan']);
                exit;
            }

            if ((int)$siswa['point'] < 100) {
                echo json_encode(['success' => false, 'message' => 'Point belum mencapai 100']);
                exit;
            }

            $newSp = (int)$siswa['sp'] + 1;

            // Reset point ke 0, tambah sp (TANPA update status)
            $stmt = $pdo->prepare("
                UPDATE siswas 
                SET point = 0, sp = ?
                WHERE id = ?
            ");
            $success = $stmt->execute([$newSp, $id]);

            echo json_encode([
                'success' => $success,
                'new_sp'  => $newSp,
                'message' => $success ? "SP{$newSp} berhasil diterbitkan" : 'Gagal menerbitkan SP'
            ]);
            exit;
            break;

        case 'delete':
            $id = (int) ($_POST['id'] ?? 0);
            $stmt = $pdo->prepare("DELETE FROM siswas WHERE id = ?");
            $success = $stmt->execute([$id]);
            echo json_encode(['success' => $success]);
            exit;
            break;

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