<?php
$adminTitle = 'All Products';
require_once __DIR__ . '/admin_header.php';

$products = $conn->query("SELECT * FROM products ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
$msg = $_GET['msg'] ?? '';
?>

<?php if ($msg === 'deleted'): ?>
  <div class="alert alert-success">✅ Product deleted successfully.</div>
<?php elseif ($msg === 'added'): ?>
  <div class="alert alert-success">✅ Product added successfully.</div>
<?php elseif ($msg === 'updated'): ?>
  <div class="alert alert-success">✅ Product updated successfully.</div>
<?php endif; ?>

<div class="table-card">
  <div class="table-card-header">
    <h2>All Products (<?= count($products) ?>)</h2>
    <a href="/furniture-store/admin/add_product.php" class="btn btn-primary btn-sm">+ Add New Product</a>
  </div>

  <?php if (empty($products)): ?>
    <div style="padding:60px;text-align:center;color:var(--text-muted);">
      <div style="font-size:3rem;margin-bottom:12px;">🛋️</div>
      <p style="font-weight:600;">No products yet.</p>
      <a href="/furniture-store/admin/add_product.php" class="btn btn-primary" style="margin-top:16px;">Add Your First Product</a>
    </div>
  <?php else: ?>
  <div style="overflow-x:auto;">
    <table class="data-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Image</th>
          <th>Name</th>
          <th>Category</th>
          <th>Price (KES)</th>
          <th>Description</th>
          <th>Added</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $i => $p): ?>
        <tr>
          <td style="color:var(--text-muted);font-size:.8rem;"><?= $p['id'] ?></td>
          <td>
            <?php if ($p['image_url']): ?>
              <img class="td-img" src="<?= htmlspecialchars($p['image_url']) ?>" alt=""
                   onerror="this.src='https://via.placeholder.com/52x40?text=No+Img'">
            <?php else: ?>
              <div style="width:52px;height:40px;background:var(--grey-light);border-radius:8px;display:flex;align-items:center;justify-content:center;">🛋️</div>
            <?php endif; ?>
          </td>
          <td><strong style="color:var(--brown);"><?= htmlspecialchars($p['name']) ?></strong></td>
          <td><span style="background:var(--grey-light);padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:700;"><?= htmlspecialchars($p['category']) ?></span></td>
          <td><strong><?= number_format($p['price']) ?></strong></td>
          <td style="max-width:200px;">
            <span style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;font-size:.82rem;color:var(--text-muted);">
              <?= htmlspecialchars($p['description']) ?>
            </span>
          </td>
          <td style="font-size:.8rem;color:var(--text-muted);white-space:nowrap;"><?= date('d M Y', strtotime($p['created_at'])) ?></td>
          <td>
            <div class="td-actions">
              <a href="/furniture-store/product.php?id=<?= $p['id'] ?>" class="btn btn-outline btn-sm" title="View">👁</a>
              <a href="/furniture-store/admin/edit_product.php?id=<?= $p['id'] ?>" class="btn btn-dark btn-sm">Edit</a>
              <a href="/furniture-store/admin/delete_product.php?id=<?= $p['id'] ?>" class="btn btn-danger btn-sm confirm-delete">Delete</a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/admin_footer.php'; ?>
