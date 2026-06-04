<?php
require_once __DIR__ . '/includes/db.php';
$pageTitle = 'Shop All Furniture';
$categories = ['Sofas','Chairs','Beds','Tables','Wardrobes','Shelves','Other'];

$selectedCat = $_GET['cat'] ?? '';
if ($selectedCat && in_array($selectedCat, $categories)) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE category = ? ORDER BY created_at DESC");
    $stmt->bind_param('s', $selectedCat);
} else {
    $stmt = $conn->prepare("SELECT * FROM products ORDER BY created_at DESC");
}
$stmt->execute();
$products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

include __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <div class="hero-inner">
    <h1>Beautiful Furniture<br>for <em>Every Room</em></h1>
    <p>Discover our hand-curated collection of premium sofas, chairs, beds and more — crafted for modern Kenyan homes.</p>
    <a href="#catalog" class="btn btn-primary">Browse Collection</a>
  </div>
</section>

<main class="main-content" id="catalog">
  <h2 class="section-title">
    <?= $selectedCat ? htmlspecialchars($selectedCat) : 'All Furniture' ?>
    <span style="font-size:.9rem;font-weight:400;color:var(--text-muted);margin-left:12px;">(<?= count($products) ?> items)</span>
  </h2>
  <p class="section-subtitle">Thoughtfully designed pieces for every corner of your home.</p>

  <!-- Category filter via URL (no JS needed) -->
  <div class="filter-bar" style="margin-bottom:32px;">
    <div class="category-filters">
      <a href="/furniture-store/index.php" class="filter-btn <?= !$selectedCat ? 'active' : ''?>">All</a>
      <?php foreach ($categories as $cat): ?>
        <a href="/furniture-store/index.php?cat=<?= urlencode($cat) ?>"
           class="filter-btn <?= $selectedCat===$cat?'active':''?>"><?= $cat ?></a>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Products Grid -->
  <div class="products-grid">
    <?php if (empty($products)): ?>
      <p style="grid-column:1/-1;text-align:center;color:#888;">No products found in this category.</p>
    <?php else: ?>
      <?php foreach ($products as $p): ?>
        <article class="product-card">
          <div class="card-img-wrap">
            <?php if ($p['image_url']): ?>
              <img src="<?= htmlspecialchars($p['image_url']) ?>"
                   alt="<?= htmlspecialchars($p['name']) ?>"
                   loading="lazy"
                   onerror="this.src='https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600'">
            <?php else: ?>
              <div style="height:100%;background:var(--grey-light);display:flex;align-items:center;justify-content:center;font-size:3rem;">🛋️</div>
            <?php endif; ?>
            <span class="card-category"><?= htmlspecialchars($p['category']) ?></span>
          </div>
          <div class="card-body">
            <h3 class="card-name"><?= htmlspecialchars($p['name']) ?></h3>
            <p class="card-desc"><?= htmlspecialchars($p['description']) ?></p>
          </div>
          <div class="card-footer">
            <div class="card-price">KES <?= number_format($p['price']) ?><span>/item</span></div>
          </div>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
