<?php
ob_clean();
header('Content-Type: application/json; charset=utf-8');

try {
    include 'database.php';
    $action = $_GET['action'] ?? '';

    switch ($action) {

        // ── STATS CARDS ──────────────────────────────────────────
        case 'stats':
            $stats = [];

            // Total siswa
            $stats['total_siswa'] = $pdo->query("SELECT COUNT(*) FROM siswas")->fetchColumn();

            // Total guru
            $stats['total_guru'] = $pdo->query("SELECT COUNT(*) FROM gurus")->fetchColumn();

            // Total pelanggaran bulan ini
            $stats['pelanggaran_bulan_ini'] = $pdo->query("
                SELECT COUNT(*) FROM pelanggarans
                WHERE MONTH(date) = MONTH(CURRENT_DATE())
                AND YEAR(date) = YEAR(CURRENT_DATE())
            ")->fetchColumn();

            // Total pelanggaran hari ini
            $stats['pelanggaran_hari_ini'] = $pdo->query("
                SELECT COUNT(*) FROM pelanggarans
                WHERE DATE(date) = CURDATE()
            ")->fetchColumn();

            // Total point pelanggaran bulan ini
            $stats['total_point_bulan_ini'] = $pdo->query("
                SELECT COALESCE(SUM(total_point), 0) FROM pelanggarans
                WHERE MONTH(date) = MONTH(CURRENT_DATE())
                AND YEAR(date) = YEAR(CURRENT_DATE())
            ")->fetchColumn();

            // Siswa dengan point tertinggi bulan ini
            $topSiswa = $pdo->query("
                SELECT s.name, COALESCE(SUM(p.total_point), 0) as total
                FROM siswas s
                LEFT JOIN pelanggarans p ON s.id = p.id_siswa
                    AND MONTH(p.date) = MONTH(CURRENT_DATE())
                    AND YEAR(p.date) = YEAR(CURRENT_DATE())
                GROUP BY s.id, s.name
                ORDER BY total DESC
                LIMIT 1
            ")->fetch(PDO::FETCH_ASSOC);
            $stats['top_siswa'] = $topSiswa;

            echo json_encode($stats, JSON_UNESCAPED_UNICODE);
            exit;

        // ── CHART: Perbandingan pelanggaran bulan lalu vs bulan ini ──
        case 'chart_monthly':
            // Ambil per-minggu untuk bulan ini dan bulan lalu
            // Atau per-hari 30 hari terakhir vs 30 hari sebelumnya
            // Kita buat per-tanggal untuk bulan ini dan bulan lalu side by side

            $thisMonth = $pdo->query("
                SELECT DAY(date) as day, COUNT(*) as count
                FROM pelanggarans
                WHERE MONTH(date) = MONTH(CURRENT_DATE())
                AND YEAR(date) = YEAR(CURRENT_DATE())
                GROUP BY DAY(date)
                ORDER BY day
            ")->fetchAll(PDO::FETCH_ASSOC);

            $lastMonth = $pdo->query("
                SELECT DAY(date) as day, COUNT(*) as count
                FROM pelanggarans
                WHERE MONTH(date) = MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH))
                AND YEAR(date) = YEAR(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH))
                GROUP BY DAY(date)
                ORDER BY day
            ")->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode([
                'this_month' => $thisMonth,
                'last_month' => $lastMonth,
                'this_month_name' => date('F Y'),
                'last_month_name' => date('F Y', strtotime('-1 month')),
            ], JSON_UNESCAPED_UNICODE);
            exit;

        // ── CHART: Breakdown jenis pelanggaran bulan ini ──
        case 'chart_jenis':
            $data = $pdo->query("
                SELECT jp.name, COUNT(p.id) as count, SUM(p.total_point) as total_point
                FROM pelanggarans p
                JOIN jenis_pelanggarans jp ON p.id_jenis_pelanggaran = jp.id
                WHERE MONTH(p.date) = MONTH(CURRENT_DATE())
                AND YEAR(p.date) = YEAR(CURRENT_DATE())
                GROUP BY jp.id, jp.name
                ORDER BY count DESC
            ")->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            exit;

        // ── LATEST PELANGGARAN ────────────────────────────────────
        case 'latest':
            $limit = (int) ($_GET['limit'] ?? 8);
            $stmt = $pdo->prepare("
                SELECT 
                    p.id,
                    p.date,
                    p.total_point,
                    p.status,
                    p.detail as keterangan,
                    s.name as siswa_name,
                    s.nis,
                    jp.name as jenis_name,
                    jp.point as jenis_point,
                    g.name as guru_name,
                    k.tingkat, k.jurusan, k.kelas as kelas_nama
                FROM pelanggarans p
                JOIN siswas s ON p.id_siswa = s.id
                JOIN jenis_pelanggarans jp ON p.id_jenis_pelanggaran = jp.id
                JOIN gurus g ON p.id_guru = g.id
                LEFT JOIN kelas k ON s.id_kelas = k.id
                ORDER BY p.date DESC, p.id DESC
                LIMIT ?
            ");
            $stmt->execute([$limit]);
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
            exit;

        // ── PELANGGARAN HARI INI ──────────────────────────────────
        case 'today':
            $stmt = $pdo->query("
                SELECT 
                    p.id,
                    p.date,
                    p.total_point,
                    p.status,
                    s.name as siswa_name,
                    s.nis,
                    jp.name as jenis_name,
                    g.name as guru_name,
                    k.tingkat, k.jurusan, k.kelas as kelas_nama
                FROM pelanggarans p
                JOIN siswas s ON p.id_siswa = s.id
                JOIN jenis_pelanggarans jp ON p.id_jenis_pelanggaran = jp.id
                JOIN gurus g ON p.id_guru = g.id
                LEFT JOIN kelas k ON s.id_kelas = k.id
                WHERE DATE(p.date) = CURDATE()
                ORDER BY p.id DESC
            ");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE);
            exit;

        // ── LOGIN USER INFO ───────────────────────────────────────
        case 'me':
            session_start();
            $userId = $_SESSION['user_id'] ?? null;
            if (!$userId) {
                echo json_encode(['error' => 'Not logged in']);
                exit;
            }
            $stmt = $pdo->prepare("SELECT id, name, role FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Cek apakah guru atau siswa
            if ($user['role'] === 'guru') {
                $detail = $pdo->prepare("SELECT g.name, m.name as mapel FROM gurus g LEFT JOIN mapels m ON g.id_mapel = m.id WHERE g.id_user = ?");
                $detail->execute([$userId]);
                $user['detail'] = $detail->fetch(PDO::FETCH_ASSOC);
            } elseif ($user['role'] === 'siswa') {
                $detail = $pdo->prepare("SELECT s.name, s.nis, k.tingkat, k.jurusan, k.kelas FROM siswas s LEFT JOIN kelas k ON s.id_kelas = k.id WHERE s.id_user = ?");
                $detail->execute([$userId]);
                $user['detail'] = $detail->fetch(PDO::FETCH_ASSOC);
            }

            echo json_encode($user, JSON_UNESCAPED_UNICODE);
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