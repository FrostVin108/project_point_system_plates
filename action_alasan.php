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

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Invalid action']);
}
?>