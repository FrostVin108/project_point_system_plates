<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=point_pelanggaran', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage());
}
