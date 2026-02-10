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
            SELECT p.*, 
                   ap.id as alasan_id
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
        $data = [
            $_POST['id_siswa'],
            $_POST['id_guru'],
            $_POST['id_jenis_pelanggaran'],
            $_POST['id_alasan_pelanggaran'],
            (int) $_POST['total_point']
        ];
        $stmt = $pdo->prepare("
            INSERT INTO pelanggarans 
            (id_siswa, id_guru, id_jenis_pelanggaran, id_alasan_pelanggaran, total_point, date) 
            VALUES (?, ?, ?, ?, ?, CURDATE())
        ");
        echo json_encode(['success' => $stmt->execute($data)]);
        break;

    case 'update':
        $data = [
            $_POST['id_siswa'],
            $_POST['id_guru'],
            $_POST['id_jenis_pelanggaran'],
            $_POST['id_alasan_pelanggaran'],
            (int) $_POST['total_point'],
            (int) $_POST['id']
        ];
        $stmt = $pdo->prepare("
            UPDATE pelanggarans 
            SET id_siswa=?, id_guru=?, id_jenis_pelanggaran=?, id_alasan_pelanggaran=?, total_point=? 
            WHERE id=?
        ");
        echo json_encode(['success' => $stmt->execute($data)]);
        break;

    case 'delete':
        $id = (int) $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM pelanggarans WHERE id=?");
        echo json_encode(['success' => $stmt->execute([$id])]);
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Invalid action']);
}
?>
