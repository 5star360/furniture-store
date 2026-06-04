<?php
require_once __DIR__ . '/includes/db.php';
$pageTitle = 'Shop All Furniture';
$categories = ['Sofas','Chairs','Beds','Tables','Wardrobes','Shelves','Other'];

$stmt = $conn->prepare("SELECT * FROM products ORDER BY created_at DESC");
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
  <h2 class="section-title">All Furniture
    <span style="font-size:.9rem;font-weight:400;color:var(--text-muted);margin-left:12px;">(<?= count($products) ?> items)</span>
  </h2>
  <p class="section-subtitle">Thoughtfully designed pieces for every corner of your home.</p>

  <!-- Filter Bar with JS search + category buttons -->
  <div class="filter-bar">
    <div class="search-wrap">
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" id="productSearch" class="search-input" placeholder="Search furniture by name or description…">
    </div>
    <div class="category-filters">
      <button class="filter-btn active" data-category="all">All</button>
      <?php foreach ($categories as $cat): ?>
        <button class="filter-btn" data-category="<?= strtolower($cat) ?>"><?= $cat ?></button>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Products Grid with data attributes for JS -->
  <div class="products-grid" id="productsGrid">
    <div id="noProductsMsg" class="no-products" style="display:none;grid-column:1/-1">
      <p style="font-size:1.1rem;font-weight:600;">No products match your search.</p>
      <p>Try a different keyword.</p>
    </div>
    <?php foreach ($products as $p): ?>
      <article class="product-card"
        data-name="<?= htmlspecialchars(strtolower($p['name'])) ?>"
        data-category="<?= htmlspecialchars(strtolower($p['category'])) ?>"
        data-desc="<?= htmlspecialchars(strtolower($p['description'])) ?>">
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
  </div>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>
