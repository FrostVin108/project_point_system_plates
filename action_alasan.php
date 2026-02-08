<?php
header('Content-Type: application/json');
include 'database.php'; // Sesuaikan path ke database.php

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'read':
        $stmt = $pdo->prepare("
            SELECT ap.*, jp.name as jenis_pelanggarans
            FROM alasan_pelanggarans ap
            LEFT JOIN jenis_pelanggarans jp ON ap.id_jenis_pelanggaran = jp.id
            ORDER BY ap.id DESC
        ");
        $stmt->execute();
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'get':
        $id = (int) ($_GET['id'] ?? 0);
        $stmt = $pdo->prepare("SELECT * FROM alasan_pelanggarans WHERE id=?");
        $stmt->execute([$id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            // Get jenis pelanggaran name
            $stmt_jp = $pdo->prepare("SELECT name FROM jenis_pelanggarans WHERE id=?");
            $stmt_jp->execute([$data['id_jenis_pelanggaran']]);
            $jp = $stmt_jp->fetch(PDO::FETCH_ASSOC);
            $data['jenis_pelanggaran'] = $jp['name'] ?? '';
            echo json_encode(['success' => true] + $data);
        } else {
            echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan']);
        }
        break;

    case 'delete':
        $id = (int) ($_POST['id'] ?? 0);
        $stmt = $pdo->prepare("DELETE FROM alasan_pelanggarans WHERE id=?");
        $success = $stmt->execute([$id]);
        echo json_encode(['success' => $success]);
        break;

    case 'jenis_pelanggaran':
        $search = $_GET['search'] ?? '';
        if ($search) {
            $stmt = $pdo->prepare("SELECT id, name FROM jenis_pelanggarans WHERE name LIKE ? ORDER BY name ASC LIMIT 50");
            $stmt->execute(["%$search%"]);
        } else {
            $stmt = $pdo->query("SELECT id, name FROM jenis_pelanggarans ORDER BY name ASC");
        }
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'add_multi':
        $id_jenis_pelanggaran = (int) $_POST['id_jenis_pelanggaran'];
        $details = $_POST['details'] ?? [];

        if ($id_jenis_pelanggaran <= 0 || empty($details)) {
            echo json_encode(['success' => false, 'message' => 'Jenis pelanggaran & minimal 1 detail wajib!']);
            exit;
        }

        $pdo->beginTransaction();
        try {
            $inserted = 0;
            foreach ($details as $detail) {
                if (!empty(trim($detail))) {
                    $stmt = $pdo->prepare("INSERT INTO alasan_pelanggarans (detail, id_jenis_pelanggaran) VALUES (?, ?)");
                    $stmt->execute([trim($detail), $id_jenis_pelanggaran]);
                    $inserted++;
                }
            }
            $pdo->commit();
            echo json_encode(['success' => true, 'inserted' => $inserted]);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
        break;

    case 'update':
        $id = (int) $_POST['id'];
        $id_jenis_pelanggaran = (int) $_POST['id_jenis_pelanggaran'];
        $detail = trim($_POST['detail'] ?? '');

        if ($id <= 0 || $id_jenis_pelanggaran <= 0 || empty($detail)) {
            echo json_encode(['success' => false, 'message' => 'Data tidak lengkap!']);
            exit;
        }

        $stmt = $pdo->prepare("UPDATE alasan_pelanggarans SET id_jenis_pelanggaran=?, detail=? WHERE id=?");
        $success = $stmt->execute([$id_jenis_pelanggaran, $detail, $id]);
        echo json_encode(['success' => $success, 'message' => $success ? 'Berhasil update!' : 'Gagal update!']);
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Invalid action']);
}
?>