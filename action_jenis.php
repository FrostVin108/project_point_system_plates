<?php
ob_clean();
header('Content-Type: application/json; charset=utf-8');

try {
    include 'database.php';
    $action = $_POST['action'] ?? $_GET['action'] ?? '';

    switch ($action) {
        case 'read':
            $stmt = $pdo->query("SELECT id, name, point FROM jenis_pelanggarans ORDER BY id");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;

        case 'add':
            $name = trim($_POST['name'] ?? '');
            $point = (int)($_POST['point'] ?? 0);
            
            if (empty($name) || $point <= 0) {
                echo json_encode(['success' => false, 'message' => 'Nama dan point wajib diisi!']);
                exit;
            }
            
            $stmt = $pdo->prepare("INSERT INTO jenis_pelanggarans (name, point) VALUES (?, ?)");
            $success = $stmt->execute([$name, $point]);
            echo json_encode(['success' => $success, 'message' => $success ? 'Data berhasil ditambahkan' : 'Gagal menambahkan data']);
            break;

        case 'edit':
            $id = (int)($_POST['id'] ?? 0);
            $name = trim($_POST['name'] ?? '');
            $point = (int)($_POST['point'] ?? 0);
            
            if ($id <= 0 || empty($name) || $point <= 0) {
                echo json_encode(['success' => false, 'message' => 'Data tidak valid!']);
                exit;
            }
            
            $stmt = $pdo->prepare("UPDATE jenis_pelanggarans SET name=?, point=? WHERE id=?");
            $success = $stmt->execute([$name, $point, $id]);
            echo json_encode(['success' => $success, 'message' => $success ? 'Data berhasil diupdate' : 'Gagal mengupdate data']);
            break;

        case 'delete':
            $id = (int)($_POST['id'] ?? 0);
            
            if ($id <= 0) {
                echo json_encode(['success' => false, 'message' => 'ID tidak valid!']);
                exit;
            }
            
            // Cek apakah jenis pelanggaran masih digunakan di alasan_pelanggarans
            $check = $pdo->prepare("SELECT COUNT(*) FROM alasan_pelanggarans WHERE id_jenis_pelanggaran = ?");
            $check->execute([$id]);
            if ($check->fetchColumn() > 0) {
                echo json_encode(['success' => false, 'message' => 'Jenis pelanggaran masih memiliki alasan, tidak dapat dihapus!']);
                exit;
            }
            
            $stmt = $pdo->prepare("DELETE FROM jenis_pelanggarans WHERE id=?");
            $success = $stmt->execute([$id]);
            echo json_encode(['success' => $success, 'message' => $success ? 'Data berhasil dihapus' : 'Gagal menghapus data']);
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Action tidak valid']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>