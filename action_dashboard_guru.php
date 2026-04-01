<?php
session_start();
require 'database.php';

header('Content-Type: application/json');

// ============================================
// AUTO-DETECT GURU DARI USER SESSION
// ============================================
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo json_encode([
        'success' => false,
        'message' => 'Sesi tidak valid, silakan login ulang'
    ]);
    exit;
}

// Cari data guru berdasarkan id_user
$stmt = $pdo->prepare("SELECT id, name FROM gurus WHERE id_user = ? LIMIT 1");
$stmt->execute([$user_id]);
$guru = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$guru) {
    echo json_encode([
        'success' => false,
        'message' => 'Anda tidak terdaftar sebagai guru dalam sistem'
    ]);
    exit;
}

$logged_in_guru_id = $guru['id'];
$logged_in_guru_name = $guru['name'];

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'get_data':
        $filter = $_GET['filter'] ?? 'month';
        
        if ($filter === 'today') {
            $date_start = date('Y-m-d');
            $date_end = date('Y-m-d');
        } else {
            $date_start = date('Y-m-01');
            $date_end = date('Y-m-t');
        }
        
        try {
            // Get items
            $stmt = $pdo->prepare("
                SELECT 
                    p.id,
                    p.date,
                    p.total_point,
                    s.name as siswa_name,
                    s.nis as siswa_nis,
                    jp.name as jenis_name,
                    ap.detail as alasan_detail,
                    g.name as guru_name
                FROM pelanggarans p
                LEFT JOIN siswas s ON p.id_siswa = s.id
                LEFT JOIN jenis_pelanggarans jp ON p.id_jenis_pelanggaran = jp.id
                LEFT JOIN alasan_pelanggarans ap ON p.id_alasan_pelanggaran = ap.id
                LEFT JOIN gurus g ON p.id_guru = g.id
                WHERE DATE(p.date) BETWEEN ? AND ?
                ORDER BY p.date DESC, p.id DESC
            ");
            $stmt->execute([$date_start, $date_end]);
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Get stats
            $stmt = $pdo->prepare("
                SELECT 
                    COUNT(*) as total,
                    COALESCE(SUM(total_point), 0) as total_points
                FROM pelanggarans
                WHERE DATE(date) BETWEEN ? AND ?
            ");
            $stmt->execute([$date_start, $date_end]);
            $stats = $stmt->fetch(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'success' => true,
                'items' => $items,
                'total' => (int)$stats['total'],
                'total_points' => (int)$stats['total_points']
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        break;
        
    case 'alasan':
        $id_jenis = (int) ($_GET['id_jenis'] ?? 0);
        
        try {
            $stmt = $pdo->prepare("
                SELECT ap.id, ap.detail
                FROM alasan_pelanggarans ap
                WHERE ap.id_jenis_pelanggaran = ?
                ORDER BY ap.detail ASC
            ");
            $stmt->execute([$id_jenis]);
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        break;
        
    case 'add':
        try {
            $id_siswa = $_POST['id_siswa'] ?? '';
            $id_jenis_pelanggaran = $_POST['id_jenis_pelanggaran'] ?? '';
            $id_alasan_pelanggaran = $_POST['id_alasan_pelanggaran'] ?? '';
            $total_point = (int) ($_POST['total_point'] ?? 0);
            
            // Validasi input
            if (!$id_siswa || !$id_jenis_pelanggaran || !$id_alasan_pelanggaran) {
                throw new Exception('Semua field harus diisi');
            }
            
            // Gunakan guru_id yang sudah terdeteksi otomatis
            // Tidak menerima id_guru dari POST untuk keamanan!
            
            $pdo->beginTransaction();
            
            // Insert pelanggaran dengan guru yang terdeteksi otomatis
            $stmt = $pdo->prepare("
                INSERT INTO pelanggarans 
                    (id_siswa, id_guru, id_jenis_pelanggaran, id_alasan_pelanggaran, total_point, date)
                VALUES (?, ?, ?, ?, ?, CURDATE())
            ");
            $stmt->execute([
                $id_siswa,
                $logged_in_guru_id,  // ← AUTO-DETECTED, tidak dari POST
                $id_jenis_pelanggaran,
                $id_alasan_pelanggaran,
                $total_point
            ]);
            
            // Update point siswa
            $stmt = $pdo->prepare("UPDATE siswas SET point = point + ? WHERE id = ?");
            $stmt->execute([$total_point, $id_siswa]);
            
            $pdo->commit();
            
            echo json_encode([
                'success' => true,
                'message' => 'Pelanggaran berhasil dicatat oleh ' . $logged_in_guru_name
            ]);
            
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        break;
        
    default:
        echo json_encode(['error' => 'Invalid action']);
}
?>