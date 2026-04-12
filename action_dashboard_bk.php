    <?php
require 'vendor/autoload.php';
include 'database.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

switch ($action) {
    // ═══════════════════════════════════════════════════════════════════════════
    // DASHBOARD pelanggaran STATISTICS
    // ═══════════════════════════════════════════════════════════════════════════
    case 'stats':
        $currentMonth = date('Y-m');
        $lastMonth = date('Y-m', strtotime('-1 month'));

        // Total pelanggaran bulan ini
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM pelanggarans WHERE DATE_FORMAT(date, '%Y-%m') = ?");
        $stmt->execute([$currentMonth]);
        $totalPelanggaran = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Total siswa yang melanggar (unique)
        $stmt = $pdo->prepare("SELECT COUNT(DISTINCT id_siswa) as total FROM pelanggarans WHERE DATE_FORMAT(date, '%Y-%m') = ?");
        $stmt->execute([$currentMonth]);
        $totalSiswa = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Total points bulan ini
        $stmt = $pdo->prepare("SELECT COALESCE(SUM(total_point), 0) as total FROM pelanggarans WHERE DATE_FORMAT(date, '%Y-%m') = ?");
        $stmt->execute([$currentMonth]);
        $totalPoints = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        // Total guru yang aktif melaporkan bulan ini
        $stmt = $pdo->prepare("SELECT COUNT(DISTINCT id_guru) as total FROM pelanggarans WHERE DATE_FORMAT(date, '%Y-%m') = ?");
        $stmt->execute([$currentMonth]);
        $totalGuru = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        echo json_encode([
            'total_pelanggaran' => (int)$totalPelanggaran,
            'total_siswa' => (int)$totalSiswa,
            'total_points' => (int)$totalPoints,
            'total_guru' => (int)$totalGuru
        ]);
        break;

    // ═══════════════════════════════════════════════════════════════════════════
    // TREND DATA (7 HARI TERAKHIR)
    // ═══════════════════════════════════════════════════════════════════════════
case 'trend':
    $date_start = $_GET['date_start'] ?? date('Y-m-d', strtotime('-6 days'));
    $date_end   = $_GET['date_end']   ?? date('Y-m-d');

    $labels = [];
    $values = [];

    $current = new DateTime($date_start);
    $end     = new DateTime($date_end);

    // Ambil semua data dalam range sekaligus (lebih efisien)
    $stmt = $pdo->prepare("
        SELECT DATE(date) as tgl, COUNT(*) as total 
        FROM pelanggarans 
        WHERE DATE(date) BETWEEN ? AND ?
        GROUP BY DATE(date)
    ");
    $stmt->execute([$date_start, $date_end]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Buat map tanggal => total
    $dataMap = [];
    foreach ($rows as $row) {
        $dataMap[$row['tgl']] = (int)$row['total'];
    }

    // Loop setiap hari agar hari kosong tetap muncul sebagai 0
    while ($current <= $end) {
        $key      = $current->format('Y-m-d');
        $labels[] = $current->format('d/m');
        $values[] = $dataMap[$key] ?? 0;
        $current->modify('+1 day');
    }

    echo json_encode([
        'labels' => $labels,
        'values' => $values
    ]);
    break;

    // ═══════════════════════════════════════════════════════════════════════════
    // JENIS PELANGGARAN DISTRIBUTION
    // ═══════════════════════════════════════════════════════════════════════════
    case 'jenis_dist':
        $stmt = $pdo->query("
            SELECT 
                jp.name as jenis_name,
                COUNT(p.id) as total
            FROM jenis_pelanggarans jp
            LEFT JOIN pelanggarans p ON jp.id = p.id_jenis_pelanggaran 
                AND DATE_FORMAT(p.date, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')
            GROUP BY jp.id, jp.name
            ORDER BY total DESC
            LIMIT 7
        ");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $labels = array_column($data, 'jenis_name');
        $values = array_map('intval', array_column($data, 'total'));

        echo json_encode([
            'labels' => $labels,
            'values' => $values
        ]);
        break;

    // ═══════════════════════════════════════════════════════════════════════════
    // TOP 10 VIOLATORS (POINT TERTINGGI)
    // ═══════════════════════════════════════════════════════════════════════════
    case 'top_violators':
        $stmt = $pdo->query("
            SELECT 
                s.name as siswa_name,
                CONCAT(k.tingkat, ' ', k.jurusan, ' ', k.kelas) as kelas,
                COALESCE(SUM(p.total_point), 0) as total_point
            FROM siswas s
            LEFT JOIN kelas k ON s.id_kelas = k.id
            LEFT JOIN pelanggarans p ON s.id = p.id_siswa
            GROUP BY s.id, s.name, k.tingkat, k.jurusan, k.kelas
            HAVING total_point > 0
            ORDER BY total_point DESC
            LIMIT 10
        ");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    // ═══════════════════════════════════════════════════════════════════════════
    // RECENT ACTIVITY (5 TERAKHIR)
    // ═══════════════════════════════════════════════════════════════════════════
    case 'recent':
        $stmt = $pdo->query("
            SELECT 
                p.date,
                p.total_point,
                s.name as siswa_name,
                jp.name as jenis_pelanggaran,
                ap.detail as alasan_pelanggaran
            FROM pelanggarans p
            LEFT JOIN siswas s ON p.id_siswa = s.id
            LEFT JOIN jenis_pelanggarans jp ON p.id_jenis_pelanggaran = jp.id
            LEFT JOIN alasan_pelanggarans ap ON p.id_alasan_pelanggaran = ap.id
            ORDER BY p.id DESC
            LIMIT 5
        ");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    // ═══════════════════════════════════════════════════════════════════════════
    // RECENT DATA FOR TABLE (6 HARI TERAKHIR)
    // ═══════════════════════════════════════════════════════════════════════════
    case 'recent_table':
        $date_start = $_GET['date_start'] ?? date('Y-m-d', strtotime('-6 days'));
        $date_end = $_GET['date_end'] ?? date('Y-m-d');
        
        $stmt = $pdo->prepare("
            SELECT 
                p.date,
                p.total_point,
                s.name as siswa_name,
                CONCAT(k.tingkat, ' ', k.jurusan, ' ', k.kelas) as kelas,
                jp.name as jenis_pelanggaran,
                g.name as guru_name
            FROM pelanggarans p
            LEFT JOIN siswas s ON p.id_siswa = s.id
            LEFT JOIN kelas k ON s.id_kelas = k.id
            LEFT JOIN jenis_pelanggarans jp ON p.id_jenis_pelanggaran = jp.id
            LEFT JOIN gurus g ON p.id_guru = g.id
            WHERE DATE(p.date) BETWEEN ? AND ?
            ORDER BY p.id DESC
        ");
        $stmt->execute([$date_start, $date_end]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Invalid action']);
}
?>