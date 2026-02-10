<?php
header('Content-Type: application/json');
include 'database.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'read':
        $stmt = $pdo->prepare("
            SELECT p.*, 
                   s.name as siswas,
                   jp.name as jenis_pelanggarans,
                   g.name as gurus,
                   ap.detail as alasan_pelanggaran
            FROM pelanggarans p
            LEFT JOIN siswas s ON p.id_siswa = s.id
            LEFT JOIN jenis_pelanggarans jp ON p.id_jenis_pelanggaran = jp.id
            LEFT JOIN gurus g ON p.id_guru = g.id
            LEFT JOIN alasan_pelanggarans ap ON p.id_alasan_pelanggaran = ap.id
            ORDER BY p.id DESC
        ");
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'get':
        $id = (int) $_GET['id'];
        $stmt = $pdo->prepare("
            SELECT p.*, ap.id as alasan_id
            FROM pelanggarans p
            LEFT JOIN alasan_pelanggarans ap ON p.id_alasan_pelanggaran = ap.id
            WHERE p.id=?
        ");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $data ?: []]);
        break;

    case 'siswa':
        $stmt = $pdo->query("SELECT id, name FROM siswas ORDER BY name ASC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'guru':
        $stmt = $pdo->query("SELECT id, name FROM gurus ORDER BY name ASC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'jenis':
        $stmt = $pdo->query("SELECT id, name FROM jenis_pelanggarans ORDER BY name ASC");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'alasan':
        $id_jenis = (int) $_GET['id_jenis'];
        $stmt = $pdo->prepare("
            SELECT ap.id, ap.detail
            FROM alasan_pelanggarans ap
            WHERE ap.id_jenis_pelanggaran = ?
            ORDER BY ap.detail ASC
        ");
        $stmt->execute([$id_jenis]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'jenis_point':
        $id_jenis = (int) $_GET['id_jenis'];
        $stmt = $pdo->prepare("SELECT point FROM jenis_pelanggarans WHERE id = ?");
        $stmt->execute([$id_jenis]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['point' => $result['point'] ?? 0]);
        break;

    case 'add':
        $id_siswa = $_POST['id_siswa'];
        $point = (int) $_POST['total_point'];

        $pdo->beginTransaction();
        try {
            // 1. INSERT pelanggaran
            $stmt = $pdo->prepare("
                INSERT INTO pelanggarans 
                (id_siswa, id_guru, id_jenis_pelanggaran, id_alasan_pelanggaran, total_point, date) 
                VALUES (?, ?, ?, ?, ?, CURDATE())
            ");
            $stmt->execute([
                $id_siswa,
                $_POST['id_guru'],
                $_POST['id_jenis_pelanggaran'],
                $_POST['id_alasan_pelanggaran'],
                $point
            ]);

            // 2. AUTO + POINT ke siswa
            $stmt = $pdo->prepare("UPDATE siswas SET point = point + ? WHERE id = ?");
            $stmt->execute([$point, $id_siswa]);

            $pdo->commit();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false]);
        }
        break;

    case 'update':
        $pdo->beginTransaction();
        try {
            // 1. Ambil data lama
            $stmt = $pdo->prepare("SELECT id_siswa, total_point FROM pelanggarans WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            $old = $stmt->fetch(PDO::FETCH_ASSOC);

            $old_point = $old['total_point'];
            $old_siswa = $old['id_siswa'];
            $new_point = (int) $_POST['total_point'];
            $new_siswa = $_POST['id_siswa'];

            // 2. Update pelanggaran
            $stmt = $pdo->prepare("
                UPDATE pelanggarans SET 
                id_siswa=?, id_guru=?, id_jenis_pelanggaran=?, 
                id_alasan_pelanggaran=?, total_point=? 
                WHERE id=?
            ");
            $stmt->execute([
                $new_siswa,
                $_POST['id_guru'],
                $_POST['id_jenis_pelanggaran'],
                $_POST['id_alasan_pelanggaran'],
                $new_point,
                $_POST['id']
            ]);

            // 3. Update point siswa
            if ($old_siswa == $new_siswa) {
                // Siswa sama = hitung selisih
                $diff = $new_point - $old_point;
                $stmt = $pdo->prepare("UPDATE siswas SET point = point + ? WHERE id = ?");
                $stmt->execute([$diff, $new_siswa]);
            } else {
                // Siswa berbeda
                $stmt = $pdo->prepare("UPDATE siswas SET point = point - ? WHERE id = ?");
                $stmt->execute([$old_point, $old_siswa]);
                $stmt = $pdo->prepare("UPDATE siswas SET point = point + ? WHERE id = ?");
                $stmt->execute([$new_point, $new_siswa]);
            }

            $pdo->commit();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false]);
        }
        break;

    case 'delete':
        $pdo->beginTransaction();
        try {
            // 1. Ambil point sebelum hapus
            $stmt = $pdo->prepare("SELECT id_siswa, total_point FROM pelanggarans WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            // 2. Hapus pelanggaran
            $stmt = $pdo->prepare("DELETE FROM pelanggarans WHERE id = ?");
            $stmt->execute([$_POST['id']]);

            // 3. Kurangi point siswa
            if ($data) {
                $stmt = $pdo->prepare("UPDATE siswas SET point = point - ? WHERE id = ?");
                $stmt->execute([$data['total_point'], $data['id_siswa']]);
            }

            $pdo->commit();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false]);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Invalid action']);
}
?>
