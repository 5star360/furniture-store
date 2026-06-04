<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
redirectIfLoggedIn();

$error = $success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // Server-side validation
    if (strlen($name) < 2) {
        $error = 'Full name must be at least 2 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $error = 'Password must be 8+ characters with at least one uppercase letter and one number.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        // Check email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = 'An account with that email already exists.';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt2  = $conn->prepare("INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, 'customer')");
            $stmt2->bind_param('ssss', $name, $email, $phone, $hashed);
            if ($stmt2->execute()) {
                header('Location: /furniture-store/login.php?registered=1');
                exit;
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Account – Pivot Home</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/furniture-store/assets/css/style.css">
</head>
<body>
<div class="auth-page">
  <div class="auth-left">
    <div class="brand">🛋️ Pivot Home</div>
    <h2>Design your perfect home starts here.</h2>
    <p>Join thousands of customers who've transformed their living spaces with Pivot Home's curated collection.</p>
  </div>
  <div class="auth-right" style="flex:0 0 560px;">
    <div style="width:100%">
      <h2 style="font-size:1.7rem;font-weight:800;color:var(--brown);margin-bottom:6px;">Create Account</h2>
      <p class="subtitle" style="font-family:Garamond,serif;color:var(--text-muted);margin-bottom:28px;">
        Already have an account? <a href="/furniture-store/login.php" style="color:var(--rose);font-weight:600;">Sign in</a>
      </p>

      <?php if ($error): ?>
        <div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form id="registerForm" method="POST" novalidate>
        <div class="form-row">
          <div class="form-group">
            <label for="name">Full Name *</label>
            <input type="text" id="name" name="name" class="form-control"
              placeholder="Jane Doe"
              value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
          </div>
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" class="form-control"
              placeholder="+254 7XX XXX XXX"
              value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
          </div>
        </div>
        <div class="form-group">
          <label for="email">Email Address *</label>
          <input type="email" id="email" name="email" class="form-control"
            placeholder="you@example.com"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="password">Password *</label>
            <input type="password" id="password" name="password" class="form-control"
              placeholder="Min. 8 chars, 1 uppercase, 1 number" required>
            <div class="password-strength"><div class="password-strength-bar" id="strengthBar"></div></div>
          </div>
          <div class="form-group">
            <label for="confirm_password">Confirm Password *</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control"
              placeholder="Repeat your password" required>
          </div>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:8px;">
          Create Account →
        </button>
      </form>
    </div>
  </div>
</div>
<script src="/furniture-store/assets/js/main.js"></script>
</body>
</html>
