<?php
header('Content-Type: application/json');
include 'database.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'read':
        // 🔥 TAMBAH POINT & STATUS
        $stmt = $pdo->prepare("
            SELECT s.*, 
                   k.tingkat, k.jurusan, k.kelas as kelas_name,
                   CONCAT(k.tingkat, ' ', k.jurusan, ' ', k.kelas) as kelas_full,
                   s.point,  -- 🔥 POINT
                   '' as status  -- 🔥 STATUS (kosong dulu)
            FROM siswas s 
            LEFT JOIN kelas k ON s.id_kelas = k.id 
            ORDER BY s.id DESC
        ");
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    // ... case lain TIDAK BERUBAH ...
    case 'edit':
        $id = $_GET['id'] ?? 0;
        if ($id == 0) {
            echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
            break;
        }
        $stmt = $pdo->prepare("
            SELECT s.*, k.tingkat, k.jurusan, k.kelas as kelas_name, s.point
            FROM siswas s 
            LEFT JOIN kelas k ON s.id_kelas = k.id 
            WHERE s.id = ?
        ");
        $stmt->execute([$id]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
        break;

    case 'update':
        $name = $_POST['name'] ?? '';
        $nis = $_POST['nis'] ?? '';

        if (empty($name) || empty($nis)) {
            echo json_encode(['success' => false, 'message' => 'Nama & NIS wajib!']);
            break;
        }

        $stmt = $pdo->prepare("
            UPDATE siswas SET 
                name=?, nis=?, id_kelas=?, name_orang_tua=?, pekerjaan_orang_tua=?,
                telphone_orang_tua=?, telphone=?, alamat=?, alamat_orang_tua=?, 
                detail=?, point=?  -- 🔥 TAMBAH POINT
            WHERE id=?
        ");
        $success = $stmt->execute([
            $_POST['name'] ?? '',
            $_POST['nis'] ?? '',
            $_POST['id_kelas'] ?? null,
            $_POST['name_orang_tua'] ?? '',
            $_POST['pekerjaan_orang_tua'] ?? '',
            $_POST['telphone_orang_tua'] ?? '',
            $_POST['telphone'] ?? '',
            $_POST['alamat'] ?? '',
            $_POST['alamat_orang_tua'] ?? '',
            $_POST['detail'] ?? '',
            (int) ($_POST['point'] ?? 0),  // 🔥 POINT
            $_POST['id'] ?? 0
        ]);
        echo json_encode(['success' => $success]);
        break;

    case 'add':
        $name = $_POST['name'] ?? '';
        $nis = $_POST['nis'] ?? '';

        if (empty($name) || empty($nis)) {
            echo json_encode(['success' => false, 'message' => 'Nama & NIS wajib!']);
            break;
        }

        $stmt = $pdo->prepare("
            INSERT INTO siswas (
                name, nis, id_kelas, name_orang_tua, pekerjaan_orang_tua,
                telphone_orang_tua, telphone, alamat, alamat_orang_tua, detail, point
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $success = $stmt->execute([
            $name,
            $nis,
            $_POST['id_kelas'] ?? null,
            $_POST['name_orang_tua'] ?? '',
            $_POST['pekerjaan_orang_tua'] ?? '',
            $_POST['telphone_orang_tua'] ?? '',
            $_POST['telphone'] ?? '',
            $_POST['alamat'] ?? '',
            $_POST['alamat_orang_tua'] ?? '',
            $_POST['detail'] ?? '',
            0  // 🔥 POINT DEFAULT 0
        ]);
        echo json_encode(['success' => $success]);
        break;

    case 'delete':
        $stmt = $pdo->prepare("DELETE FROM siswas WHERE id=?");
        $success = $stmt->execute([$_POST['id'] ?? 0]);
        echo json_encode(['success' => $success]);
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Invalid action']);
}
?>