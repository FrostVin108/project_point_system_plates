<?php
require 'vendor/autoload.php';
include 'database.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;
use League\Plates\Engine;

function requireAdmin() {
    session_start();
    $role = $_SESSION['role'] ?? '';
    if ($role !== 'admin') {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Akses ditolak: hanya admin yang dapat melakukan ini']);
        exit;
    }
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

// Case export stream file Word, bukan JSON
if ($action !== 'export') {
    header('Content-Type: application/json');
}

switch ($action) {
    case 'read':
        $stmt = $pdo->prepare("
            SELECT p.*,
                   s.name  as siswas,
                   jp.name as jenis_pelanggarans,
                   g.name  as gurus,
                   ap.detail as alasan_pelanggaran
            FROM pelanggarans p
            LEFT JOIN siswas              s  ON p.id_siswa             = s.id
            LEFT JOIN jenis_pelanggarans  jp ON p.id_jenis_pelanggaran = jp.id
            LEFT JOIN gurus               g  ON p.id_guru              = g.id
            LEFT JOIN alasan_pelanggarans ap ON p.id_alasan_pelanggaran= ap.id
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
            WHERE p.id = ?
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

    case 'count_range':
        $date_start = $_GET['date_start'] ?? date('Y-m-01');
        $date_end = $_GET['date_end'] ?? date('Y-m-t');
        $stmt = $pdo->prepare("
            SELECT
                COUNT(*)                      AS total,
                COALESCE(SUM(total_point), 0) AS total_poin
            FROM pelanggarans
            WHERE DATE(date) BETWEEN ? AND ?
        ");
        $stmt->execute([$date_start, $date_end]);
        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        break;

    // ── EXPORT WORD ────────────────────────────────────────────────────────
    case 'export':
        $date_start = $_GET['date_start'] ?? date('Y-m-01');
        $date_end = $_GET['date_end'] ?? date('Y-m-t');

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_start))
            $date_start = date('Y-m-01');
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_end))
            $date_end = date('Y-m-t');
        if ($date_start > $date_end)
            [$date_start, $date_end] = [$date_end, $date_start];

        // Query data
        $stmt = $pdo->prepare("
            SELECT
                p.date,
                p.total_point,
                s.name      AS siswa_name,
                s.nis       AS siswa_nis,
                k.tingkat   AS kelas_tingkat,
                k.jurusan   AS kelas_jurusan,
                k.kelas     AS kelas_kelas,
                jp.name     AS jenis_name,
                ap.detail   AS alasan_detail
            FROM pelanggarans p
            LEFT JOIN siswas              s  ON p.id_siswa             = s.id
            LEFT JOIN kelas               k  ON s.id_kelas             = k.id
            LEFT JOIN jenis_pelanggarans  jp ON p.id_jenis_pelanggaran = jp.id
            LEFT JOIN alasan_pelanggarans ap ON p.id_alasan_pelanggaran= ap.id
            WHERE DATE(p.date) BETWEEN ? AND ?
            ORDER BY p.date ASC, s.name ASC
        ");
        $stmt->execute([$date_start, $date_end]);
        $rawRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Format tanggal Indonesia
        $bulan_id = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
        $fmtTgl = function (string $tgl) use ($bulan_id): string {
            if (!$tgl)
                return '-';
            $d = new DateTime(substr($tgl, 0, 10));
            return (int) $d->format('d') . ' ' . $bulan_id[(int) $d->format('m')] . ' ' . $d->format('Y');
        };

        // Transformasi rows untuk template
        $rows = array_map(function ($r) use ($fmtTgl) {
            $kelas = trim(
                ($r['kelas_tingkat'] ?? '') . ' ' .
                ($r['kelas_jurusan'] ?? '') . ' ' .
                ($r['kelas_kelas'] ?? '')
            ) ?: '-';
            return [
                'siswa_name' => $r['siswa_name'] ?? '-',
                'siswa_nis' => $r['siswa_nis'] ?? '-',
                'kelas' => $kelas,
                'jenis_name' => $r['jenis_name'] ?? '-',
                'alasan_detail' => $r['alasan_detail'] ?? '-',
                'date_fmt' => $fmtTgl($r['date'] ?? ''),
            ];
        }, $rawRows);

        $periode = ($date_start === $date_end)
            ? $fmtTgl($date_start)
            : $fmtTgl($date_start) . ' – ' . $fmtTgl($date_end);
        $cetak_pada = $fmtTgl(date('Y-m-d'));
        $total_data = count($rows);

        // Logo path (opsional, taruh logo_sekolah.png/jpg di root project)
        $logoPath = '';
        foreach (['logo_sekolah.png', 'logo_sekolah.jpg', 'logo_sekolah.jpeg'] as $f) {
            if (file_exists(__DIR__ . '/' . $f)) {
                $logoPath = __DIR__ . '/' . $f;
                break;
            }
        }

        // Buat dokumen Word via PhpWord native API
        // Template ada di templates/export_pelanggaran.php
        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(11);
        $section = $phpWord->addSection([
            'paperSize' => 'A4',
            'marginTop' => 1134,
            'marginBottom' => 1134,
            'marginLeft' => 1701,
            'marginRight' => 1134,
        ]);

        // Render template via extract + include
        extract([
            'periode' => $periode,
            'cetak_pada' => $cetak_pada,
            'total_data' => $total_data,
            'logoPath' => $logoPath,
            'rows' => $rows,
        ]);
        ob_start();
        include './templates/export_pelanggaran.php';
        $html = ob_get_clean();

        Html::addHtml($section, $html);

        // Stream ke browser
        $filename = 'laporan_pelanggaran_' . $date_start . '_sd_' . $date_end . '.docx';
        $tmpPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filename;
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tmpPath);

        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Content-Length: ' . filesize($tmpPath));
        header('Cache-Control: no-cache, must-revalidate');
        readfile($tmpPath);
        @unlink($tmpPath);
        exit;

    case 'add':
        $id_siswa = $_POST['id_siswa'];
        $point = (int) $_POST['total_point'];

        $pdo->beginTransaction();
        try {
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

            $stmt = $pdo->prepare("UPDATE siswas SET point = point + ? WHERE id = ?");
            $stmt->execute([$point, $id_siswa]);

            $pdo->commit();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'update':
        requireAdmin(); // <-- TAMBAH INI
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("SELECT id_siswa, total_point FROM pelanggarans WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            $old = $stmt->fetch(PDO::FETCH_ASSOC);

            $old_point = (int) $old['total_point'];
            $old_siswa = (int) $old['id_siswa'];
            $new_point = (int) $_POST['total_point'];
            $new_siswa = (int) $_POST['id_siswa'];

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

            if ($old_siswa === $new_siswa) {
                $diff = $new_point - $old_point;
                $pdo->prepare("UPDATE siswas SET point = point + ? WHERE id = ?")
                    ->execute([$diff, $new_siswa]);
            } else {
                $pdo->prepare("UPDATE siswas SET point = point - ? WHERE id = ?")
                    ->execute([$old_point, $old_siswa]);
                $pdo->prepare("UPDATE siswas SET point = point + ? WHERE id = ?")
                    ->execute([$new_point, $new_siswa]);
            }

            $pdo->commit();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'delete':
        requireAdmin(); // <-- TAMBAH INI
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("SELECT id_siswa, total_point FROM pelanggarans WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            $pdo->prepare("DELETE FROM pelanggarans WHERE id = ?")->execute([$_POST['id']]);

            if ($data) {
                $pdo->prepare("UPDATE siswas SET point = point - ? WHERE id = ?")
                    ->execute([$data['total_point'], $data['id_siswa']]);
            }

            $pdo->commit();
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Invalid action']);
}
?>