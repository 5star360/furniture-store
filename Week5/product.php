<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
requireLogin();

$id = (int)($_GET['id'] ?? 0);
if (!$id) { header('Location: /furniture-store/index.php'); exit; }

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$p = $stmt->get_result()->fetch_assoc();
if (!$p) { header('Location: /furniture-store/index.php'); exit; }

$pageTitle = $p['name'];

// Related products
$stmt2 = $conn->prepare("SELECT * FROM products WHERE category = ? AND id != ? LIMIT 3");
$stmt2->bind_param('si', $p['category'], $id);
$stmt2->execute();
$related = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);

include __DIR__ . '/includes/header.php';
?>

<main class="main-content">
  <div class="breadcrumb">
    <a href="/furniture-store/index.php">Shop</a>
    <span>›</span>
    <a href="/furniture-store/index.php?cat=<?= urlencode($p['category']) ?>"><?= htmlspecialchars($p['category']) ?></a>
    <span>›</span>
    <span><?= htmlspecialchars($p['name']) ?></span>
  </div>

  <div class="product-detail">
    <div class="product-detail-img">
      <?php if ($p['image_url']): ?>
        <img src="<?= htmlspecialchars($p['image_url']) ?>"
             alt="<?= htmlspecialchars($p['name']) ?>"
             onerror="this.src='https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=800'">
      <?php else: ?>
        <div style="height:420px;background:var(--grey-light);display:flex;align-items:center;justify-content:center;font-size:5rem;">🛋️</div>
      <?php endif; ?>
    </div>

    <div class="product-detail-info">
      <span class="badge"><?= htmlspecialchars($p['category']) ?></span>
      <h1><?= htmlspecialchars($p['name']) ?></h1>
      <div class="product-detail-price">KES <?= number_format($p['price']) ?></div>
      <p class="product-detail-desc"><?= nl2br(htmlspecialchars($p['description'])) ?></p>

      <div style="display:flex;gap:12px;flex-wrap:wrap;">
        <a href="/furniture-store/index.php" class="btn btn-outline">← Back to Shop</a>
        <?php if ($_SESSION['role'] === 'admin'): ?>
          <a href="/furniture-store/admin/edit_product.php?id=<?= $p['id'] ?>" class="btn btn-dark">Edit Product</a>
        <?php endif; ?>
      </div>

      <div style="margin-top:32px;padding:20px;background:var(--off-white);border-radius:var(--radius);border:1px solid var(--grey-light);">
        <h4 style="color:var(--brown);font-size:.88rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;margin-bottom:10px;">Product Info</h4>
        <div style="font-size:.88rem;color:var(--text-muted);display:flex;flex-direction:column;gap:6px;">
          <div><strong style="color:var(--brown);">Category:</strong> <?= htmlspecialchars($p['category']) ?></div>
          <div><strong style="color:var(--brown);">Added:</strong> <?= date('d M Y', strtotime($p['created_at'])) ?></div>
          <div><strong style="color:var(--brown);">Product ID:</strong> #<?= $p['id'] ?></div>
        </div>
      </div>
    </div>
  </div>

  <?php if (!empty($related)): ?>
  <div style="margin-top:64px;">
    <h2 class="section-title">More <?= htmlspecialchars($p['category']) ?></h2>
    <p class="section-subtitle">You might also like these pieces.</p>
    <div class="products-grid" style="grid-template-columns:repeat(3,1fr);">
      <?php foreach ($related as $r): ?>
        <article class="product-card" data-name="" data-category="" data-desc="">
          <div class="card-img-wrap">
            <?php if ($r['image_url']): ?>
              <img src="<?= htmlspecialchars($r['image_url']) ?>" alt="<?= htmlspecialchars($r['name']) ?>" loading="lazy"
                   onerror="this.src='https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600'">
            <?php else: ?>
              <div style="height:100%;background:var(--grey-light);display:flex;align-items:center;justify-content:center;font-size:2.5rem;">🛋️</div>
            <?php endif; ?>
            <span class="card-category"><?= htmlspecialchars($r['category']) ?></span>
          </div>
          <div class="card-body">
            <h3 class="card-name"><?= htmlspecialchars($r['name']) ?></h3>
            <p class="card-desc"><?= htmlspecialchars($r['description']) ?></p>
          </div>
          <div class="card-footer">
            <div class="card-price">KES <?= number_format($r['price']) ?></div>
            <a href="/furniture-store/product.php?id=<?= $r['id'] ?>" class="btn btn-dark btn-sm">View</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
