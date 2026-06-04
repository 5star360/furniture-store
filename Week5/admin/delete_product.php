<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
requireAdmin();

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    header('Location: /furniture-store/admin/products.php');
    exit;
}

// Get product to potentially delete local image
$stmt = $conn->prepare("SELECT image_url FROM products WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$p = $stmt->get_result()->fetch_assoc();

if ($p) {
    // Delete local uploaded image if it's a local file
    if ($p['image_url'] && strpos($p['image_url'], '/furniture-store/assets/uploads/') === 0) {
        $filePath = __DIR__ . '/../' . str_replace('/furniture-store/', '', $p['image_url']);
        if (file_exists($filePath)) @unlink($filePath);
    }

    $del = $conn->prepare("DELETE FROM products WHERE id = ?");
    $del->bind_param('i', $id);
    $del->execute();
}

header('Location: /furniture-store/admin/products.php?msg=deleted');
exit;
