<?php
$adminTitle = 'Edit Product';
require_once __DIR__ . '/admin_header.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) { header('Location: /furniture-store/admin/products.php'); exit; }

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$p = $stmt->get_result()->fetch_assoc();
if (!$p) { header('Location: /furniture-store/admin/products.php'); exit; }

$categories = ['Sofas','Chairs','Beds','Tables','Wardrobes','Shelves','Other'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $desc     = trim($_POST['description'] ?? '');
    $price    = $_POST['price'] ?? '';
    $cat      = $_POST['category'] ?? '';
    $imageUrl = trim($_POST['image_url'] ?? $p['image_url']);

    // Handle file upload
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','webp','gif'];
        if (in_array($ext, $allowed)) {
            $filename = 'product_' . time() . '_' . rand(1000,9999) . '.' . $ext;
            $dest = __DIR__ . '/../assets/uploads/' . $filename;
            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $dest)) {
                $imageUrl = '/furniture-store/assets/uploads/' . $filename;
            }
        }
    }

    if (strlen($name) < 3) $error = 'Product name must be at least 3 characters.';
    elseif (!is_numeric($price) || $price <= 0) $error = 'Enter a valid price.';
    elseif (!in_array($cat, $categories)) $error = 'Please select a valid category.';
    elseif (strlen($desc) < 10) $error = 'Description must be at least 10 characters.';
    else {
        $stmt2 = $conn->prepare("UPDATE products SET name=?, description=?, price=?, image_url=?, category=? WHERE id=?");
        $stmt2->bind_param('ssdssi', $name, $desc, $price, $imageUrl, $cat, $id);
        if ($stmt2->execute()) {
            header('Location: /furniture-store/admin/products.php?msg=updated');
            exit;
        } else {
            $error = 'Failed to update product.';
        }
    }
    // Keep form values
    $p['name'] = $name; $p['description'] = $desc;
    $p['price'] = $price; $p['category'] = $cat;
    $p['image_url'] = $imageUrl;
}
?>

<?php if ($error): ?><div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div><?php endif; ?>

<div style="display:grid;grid-template-columns:1fr 380px;gap:28px;align-items:start;">

  <div class="table-card" style="padding:32px;">
    <h2 style="font-size:1.1rem;font-weight:700;color:var(--brown);margin-bottom:24px;">
      Editing: <em style="font-weight:400;"><?= htmlspecialchars($p['name']) ?></em>
    </h2>

    <form id="productForm" method="POST" enctype="multipart/form-data" novalidate>
      <div class="form-row">
        <div class="form-group">
          <label>Product Name *</label>
          <input type="text" name="name" class="form-control"
            value="<?= htmlspecialchars($p['name']) ?>" required>
        </div>
        <div class="form-group">
          <label>Category *</label>
          <select name="category" class="form-control" required>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= $cat ?>" <?= $p['category'] === $cat ? 'selected' : '' ?>><?= $cat ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label>Price (KES) *</label>
        <input type="number" name="price" class="form-control"
          value="<?= htmlspecialchars($p['price']) ?>" min="1" step="0.01" required>
      </div>

      <div class="form-group">
        <label>Description *</label>
        <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($p['description']) ?></textarea>
      </div>

      <div class="form-group">
        <label>Image URL</label>
        <input type="url" name="image_url" id="edit_image_url" class="form-control"
          value="<?= htmlspecialchars($p['image_url'] ?? '') ?>">
      </div>

      <div class="form-group">
        <label>Replace Image</label>
        <input type="file" name="image_file" class="form-control" accept="image/*" style="padding:10px 14px;height:auto;">
      </div>

      <div style="display:flex;gap:12px;margin-top:8px;">
        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="/furniture-store/admin/products.php" class="btn btn-outline">Cancel</a>
        <a href="/furniture-store/admin/delete_product.php?id=<?= $id ?>" class="btn btn-danger confirm-delete" style="margin-left:auto;">Delete Product</a>
      </div>
    </form>
  </div>

  <div class="table-card" style="overflow:hidden;">
    <div class="table-card-header"><h2>Current Image</h2></div>
    <div style="padding:20px;">
      <?php if ($p['image_url']): ?>
        <img src="<?= htmlspecialchars($p['image_url']) ?>" id="currentImg"
          style="width:100%;border-radius:10px;height:200px;object-fit:cover;"
          onerror="this.style.display='none'">
      <?php else: ?>
        <div style="height:200px;background:var(--grey-light);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:3rem;">🛋️</div>
      <?php endif; ?>
    </div>
  </div>

</div>

<?php require_once __DIR__ . '/admin_footer.php'; ?>
