<?php
$conn = new mysqli('localhost', 'root', '', '');
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sqls = [
    "CREATE DATABASE IF NOT EXISTS `week2db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci",
    "USE `week2db`",
    "CREATE TABLE IF NOT EXISTS `users` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `email` VARCHAR(150) NOT NULL UNIQUE,
        `phone` VARCHAR(20),
        `password` VARCHAR(255) NOT NULL,
        `role` ENUM('customer','admin') DEFAULT 'customer',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB",
    "CREATE TABLE IF NOT EXISTS `products` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(200) NOT NULL,
        `description` TEXT,
        `price` DECIMAL(10,2) NOT NULL,
        `image_url` VARCHAR(300),
        `category` ENUM('Sofas','Chairs','Beds','Tables','Wardrobes','Shelves','Other') DEFAULT 'Other',
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB",
    "INSERT IGNORE INTO `users` (`name`,`email`,`password`,`role`) VALUES
        ('Admin User','admin@furnitureshop.com','" . password_hash('Admin@1234', PASSWORD_DEFAULT) . "','admin'),
        ('Jane Doe','jane@example.com','" . password_hash('Jane@1234', PASSWORD_DEFAULT) . "','customer')",
    "INSERT IGNORE INTO `products` (`name`,`description`,`price`,`image_url`,`category`) VALUES
        ('Bouclé Accent Chair','Luxurious cream bouclé fabric tub chair with tapered black legs. Perfect for living rooms and reading nooks.',38500,'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?w=600','Chairs'),
        ('Grey Velvet King Bed','Tufted grey velvet king-size bed frame with wingback headboard and matching footboard.',95000,'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=600','Beds'),
        ('Walnut Open Wardrobe','Two-tone walnut and charcoal wardrobe with open shelving on left and double doors on right.',72000,'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600','Wardrobes'),
        ('Coffee Table with Storage','Modern two-tone coffee table with woodgrain top, central drawer and side cabinet.',18500,'https://images.unsplash.com/photo-1506439773649-6e0eb8cfb237?w=600','Tables'),
        ('Solid Wood Bookshelf','Tall solid sheesham wood bookshelf with staggered shelves. Holds books, plants and décor elegantly.',42000,'https://images.unsplash.com/photo-1484101403633-562f891dc89a?w=600','Shelves'),
        ('3-Seater Linen Sofa','Scandinavian-inspired 3-seater sofa in natural linen fabric with solid oak legs.',88000,'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=600','Sofas'),
        ('Marble Top Dining Table','Round dining table with white marble top and brushed brass base. Seats 4 comfortably.',65000,'https://images.unsplash.com/photo-1617806118233-18e1de247200?w=600','Tables'),
        ('Rattan Lounge Chair','Handwoven rattan lounge chair with removable cushion. Brings natural warmth to any room.',29500,'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=600','Chairs')"
];

$errors = [];
$success = [];

foreach ($sqls as $sql) {
    if (!$conn->query($sql)) {
        $errors[] = $conn->error . ' | SQL: ' . substr($sql, 0, 80);
    } else {
        $success[] = substr($sql, 0, 80) . '...';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Install – Furniture Store</title>
<style>
  body{font-family:sans-serif;max-width:760px;margin:60px auto;padding:0 20px;background:#f7f9f6;}
  h1{color:#42362e;}
  .ok{background:#d4edda;border:1px solid #c3e6cb;padding:10px 16px;border-radius:6px;margin:6px 0;font-size:13px;}
  .err{background:#f8d7da;border:1px solid #f5c6cb;padding:10px 16px;border-radius:6px;margin:6px 0;font-size:13px;}
  .btn{display:inline-block;background:#42362e;color:#fff;padding:14px 28px;border-radius:8px;text-decoration:none;margin-top:20px;font-weight:600;}
  .creds{background:#fff;border:2px solid #a8917f;padding:20px;border-radius:10px;margin-top:20px;}
  .creds h3{margin-top:0;color:#42362e;}
  code{background:#d2ccc4;padding:2px 6px;border-radius:4px;}
</style>
</head>
<body>
<h1>🛋️ Furniture Store — Database Setup</h1>
<?php if (!empty($errors)): ?>
  <h3 style="color:#c00">Errors occurred:</h3>
  <?php foreach ($errors as $e): ?><div class="err">❌ <?= htmlspecialchars($e) ?></div><?php endforeach; ?>
<?php endif; ?>
<?php if (!empty($success)): ?>
  <h3 style="color:#155724">✅ Setup Complete!</h3>
  <?php foreach ($success as $s): ?><div class="ok"><?= htmlspecialchars($s) ?></div><?php endforeach; ?>
<?php endif; ?>

<div class="creds">
  <h3>Default Login Credentials</h3>
  <p><strong>Admin:</strong> <code>admin@furnitureshop.com</code> / <code>Admin@1234</code></p>
  <p><strong>Customer:</strong> <code>jane@example.com</code> / <code>Jane@1234</code></p>
</div>

<a class="btn" href="/furniture-store/login.php">→ Go to Login Page</a>
</body>
</html>
