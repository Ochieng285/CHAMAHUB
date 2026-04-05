<?php
require_once 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['payment_id'])) {
    $id = $_POST['payment_id'];
    $status = $_POST['new_status']; // 'verified' or 'flagged'

    try {
        $stmt = $pdo->prepare("UPDATE payments SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);

        header("Location: admin.php?msg=Status updated successfully");
    } catch (PDOException $e) {
        die("Error updating status: " . $e->getMessage());
    }
    exit();
}