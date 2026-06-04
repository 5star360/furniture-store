<?php
$adminTitle = 'Add New Product';
require_once __DIR__ . '/admin_header.php';

$categories = ['Sofas','Chairs','Beds','Tables','Wardrobes','Shelves','Other'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $desc     = trim($_POST['description'] ?? '');
    $price    = $_POST['price'] ?? '';
    $cat      = $_POST['category'] ?? '';
    $imageUrl = trim($_POST['image_url'] ?? '');

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

    // Validate
    if (strlen($name) < 3) $error = 'Product name must be at least 3 characters.';
    elseif (!is_numeric($price) || $price <= 0) $error = 'Enter a valid price.';
    elseif (!in_array($cat, $categories)) $error = 'Please select a valid category.';
    elseif (strlen($desc) < 10) $error = 'Description must be at least 10 characters.';
    else {
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image_url, category) VALUES (?,?,?,?,?)");
        $stmt->bind_param('ssdss', $name, $desc, $price, $imageUrl, $cat);
        if ($stmt->execute()) {
            header('Location: /furniture-store/admin/products.php?msg=added');
            exit;
        } else {
            $error = 'Failed to save product. Please try again.';
        }
    }
}
?>

<?php if ($error): ?><div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div><?php endif; ?>

<div style="display:grid;grid-template-columns:1fr 380px;gap:28px;align-items:start;">

  <div class="table-card" style="padding:32px;">
    <h2 style="font-size:1.1rem;font-weight:700;color:var(--brown);margin-bottom:24px;">Product Details</h2>

    <form id="productForm" method="POST" enctype="multipart/form-data" novalidate>
      <div class="form-row">
        <div class="form-group">
          <label for="name">Product Name *</label>
          <input type="text" id="name" name="name" class="form-control"
            placeholder="e.g. Bouclé Accent Chair"
            value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label for="category">Category *</label>
          <select id="category" name="category" class="form-control" required>
            <option value="">Select category…</option>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= $cat ?>" <?= ($_POST['category'] ?? '') === $cat ? 'selected' : '' ?>><?= $cat ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="price">Price (KES) *</label>
        <input type="number" id="price" name="price" class="form-control"
          placeholder="e.g. 38500" min="1" step="0.01"
          value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" required>
      </div>

      <div class="form-group">
        <label for="description">Description *</label>
        <textarea id="description" name="description" class="form-control" rows="4"
          placeholder="Describe the product in detail — materials, dimensions, style…" required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
      </div>

      <div class="form-group">
        <label for="image_url">Image URL</label>
        <input type="url" id="image_url" name="image_url" class="form-control"
          placeholder="https://example.com/image.jpg"
          value="<?= htmlspecialchars($_POST['image_url'] ?? '') ?>">
        <span style="font-size:.78rem;color:var(--text-muted);margin-top:4px;display:block;">Or upload an image below</span>
      </div>

      <div class="form-group">
        <label for="image_file">Upload Image</label>
        <input type="file" id="image_file" name="image_file" class="form-control"
          accept="image/*" style="padding:10px 14px;height:auto;">
      </div>

      <div style="display:flex;gap:12px;margin-top:8px;">
        <button type="submit" class="btn btn-primary">Save Product</button>
        <a href="/furniture-store/admin/products.php" class="btn btn-outline">Cancel</a>
      </div>
    </form>
  </div>

  <!-- Preview -->
  <div>
    <div class="table-card" style="overflow:hidden;">
      <div class="table-card-header"><h2>Preview</h2></div>
      <div style="padding:20px;">
        <div style="border-radius:10px;overflow:hidden;height:200px;background:var(--grey-light);margin-bottom:16px;" id="previewImg">
          <div style="height:100%;display:flex;align-items:center;justify-content:center;font-size:3rem;color:var(--beige);">🛋️</div>
        </div>
        <div style="font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--text-muted);margin-bottom:4px;" id="previewCat">Category</div>
        <div style="font-size:1rem;font-weight:700;color:var(--brown);margin-bottom:8px;" id="previewName">Product Name</div>
        <div style="font-size:1.3rem;font-weight:800;color:var(--rose);" id="previewPrice">KES —</div>
      </div>
    </div>

    <script>
    document.getElementById('name').addEventListener('input', function(){
      document.getElementById('previewName').textContent = this.value || 'Product Name';
    });
    document.getElementById('category').addEventListener('change', function(){
      document.getElementById('previewCat').textContent = this.value || 'Category';
    });
    document.getElementById('price').addEventListener('input', function(){
      const n = parseFloat(this.value);
      document.getElementById('previewPrice').textContent = n ? 'KES ' + n.toLocaleString() : 'KES —';
    });
    document.getElementById('image_url').addEventListener('input', function(){
      if (this.value) {
        document.getElementById('previewImg').innerHTML = '<img src="'+this.value+'" style="width:100%;height:200px;object-fit:cover;" onerror="this.parentElement.innerHTML=\'<div style=\'height:200px;display:flex;align-items:center;justify-content:center;font-size:3rem;\'>🛋️</div>\'">';
      }
    });
    document.getElementById('image_file').addEventListener('change', function(){
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = e => {
          document.getElementById('previewImg').innerHTML = '<img src="'+e.target.result+'" style="width:100%;height:200px;object-fit:cover;">';
        };
        reader.readAsDataURL(file);
      }
    });
    </script>
  </div>
</div>

<?php require_once __DIR__ . '/admin_footer.php'; ?>
