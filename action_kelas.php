<?php
ob_clean();
header('Content-Type: application/json; charset=utf-8');

try {
    include 'database.php';
    $action = $_GET['action'] ?? $_POST['action'] ?? '';

    switch ($action) {

        // ── READ ──────────────────────────────────────────────────────
        case 'read':
            $stmt = $pdo->query("SELECT id, tingkat, jurusan, kelas FROM kelas ORDER BY tingkat ASC, jurusan ASC, kelas ASC");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
            exit;

        // ── GET single ────────────────────────────────────────────────
        case 'get':
            $id = (int) ($_GET['id'] ?? 0);
            if ($id === 0) {
                echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
                exit;
            }
            $stmt = $pdo->prepare("SELECT id, tingkat, jurusan, kelas FROM kelas WHERE id = ?");
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($data ?: ['success' => false, 'message' => 'Kelas tidak ditemukan'], JSON_UNESCAPED_UNICODE);
            exit;

        // ── ADD ───────────────────────────────────────────────────────
        case 'add':
            $tingkat = trim($_POST['tingkat'] ?? '');
            $jurusan = trim($_POST['jurusan'] ?? '');
            $kelas = trim($_POST['kelas'] ?? '');

            if (empty($tingkat) || empty($jurusan) || empty($kelas)) {
                echo json_encode(['success' => false, 'message' => 'Tingkat, jurusan, dan kelas wajib diisi!']);
                exit;
            }

            // Cek duplikat kombinasi tingkat+jurusan+kelas
            $chk = $pdo->prepare("SELECT id FROM kelas WHERE tingkat = ? AND jurusan = ? AND kelas = ?");
            $chk->execute([$tingkat, $jurusan, $kelas]);
            if ($chk->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Kelas dengan kombinasi tersebut sudah ada!']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO kelas (tingkat, jurusan, kelas) VALUES (?, ?, ?)");
            $success = $stmt->execute([$tingkat, $jurusan, $kelas]);
            echo json_encode(['success' => $success], JSON_UNESCAPED_UNICODE);
            exit;

        // ── EDIT ──────────────────────────────────────────────────────
        case 'edit':
            $id = (int) ($_POST['id'] ?? 0);
            $tingkat = trim($_POST['tingkat'] ?? '');
            $jurusan = trim($_POST['jurusan'] ?? '');
            $kelas = trim($_POST['kelas'] ?? '');

            if ($id === 0 || empty($tingkat) || empty($jurusan) || empty($kelas)) {
                echo json_encode(['success' => false, 'message' => 'ID, tingkat, jurusan, dan kelas wajib!']);
                exit;
            }

            // Cek duplikat (kecuali diri sendiri)
            $chk = $pdo->prepare("SELECT id FROM kelas WHERE tingkat = ? AND jurusan = ? AND kelas = ? AND id != ?");
            $chk->execute([$tingkat, $jurusan, $kelas, $id]);
            if ($chk->fetch()) {
                echo json_encode(['success' => false, 'message' => 'Kombinasi kelas sudah digunakan!']);
                exit;
            }

            $stmt = $pdo->prepare("UPDATE kelas SET tingkat=?, jurusan=?, kelas=? WHERE id=?");
            $success = $stmt->execute([$tingkat, $jurusan, $kelas, $id]);

            echo json_encode(['success' => $success], JSON_UNESCAPED_UNICODE);
            exit;

        // ── DELETE ────────────────────────────────────────────────────
        case 'delete':
            $id = (int) ($_POST['id'] ?? 0);
            if ($id === 0) {
                echo json_encode(['success' => false, 'message' => 'ID tidak valid']);
                exit;
            }

            // Opsional: Cek apakah kelas masih digunakan di tabel siswa
            // $check = $pdo->prepare("SELECT COUNT(*) FROM siswas WHERE id_kelas = ?");
            // $check->execute([$id]);
            // if ($check->fetchColumn() > 0) {
            //     echo json_encode(['success' => false, 'message' => 'Kelas masih memiliki siswa, tidak dapat dihapus!']);
            //     exit;
            // }

            $stmt = $pdo->prepare("DELETE FROM kelas WHERE id = ?");
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