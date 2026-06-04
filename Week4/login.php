<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
redirectIfLoggedIn();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        $error = 'Please enter your email and password.';
    } else {
        $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user   = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name']    = $user['name'];
            $_SESSION['role']    = $user['role'];
            if ($user['role'] === 'admin') {
                header('Location: /furniture-store/admin/dashboard.php');
            } else {
                header('Location: /furniture-store/index.php');
            }
            exit;
        } else {
            $error = 'Invalid email or password. Please try again.';
        }
    }
}

$unauthorized = isset($_GET['error']) && $_GET['error'] === 'unauthorized';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login – Pivot Home</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/furniture-store/assets/css/style.css">
</head>
<body>
<div class="auth-page">
  <div class="auth-left">
    <div class="brand">🛋️ Pivot Home</div>
    <h2>Welcome back to your space.</h2>
    <p>Sign in to browse our curated collection of premium furniture crafted for modern living.</p>
  </div>
  <div class="auth-right">
    <div>
      <h2 style="font-size:1.7rem;font-weight:800;color:var(--brown);margin-bottom:6px;">Sign In</h2>
      <p class="subtitle" style="font-family:Garamond,serif;color:var(--text-muted);margin-bottom:28px;">
        Don't have an account? <a href="/furniture-store/register.php" style="color:var(--rose);font-weight:600;">Create one</a>
      </p>

      <?php if ($unauthorized): ?>
        <div class="alert alert-danger">⛔ You don't have permission to access that page.</div>
      <?php endif; ?>
      <?php if ($error): ?>
        <div class="alert alert-danger">⚠️ <?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <?php if (isset($_GET['registered'])): ?>
        <div class="alert alert-success">✅ Account created! Please log in.</div>
      <?php endif; ?>

      <form id="loginForm" method="POST" novalidate>
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" class="form-control"
            placeholder="you@example.com"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" class="form-control"
            placeholder="Your password" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:8px;">
          Sign In →
        </button>
      </form>


    </div>
  </div>
</div>
<script src="/furniture-store/assets/js/main.js"></script>
</body>
</html>
