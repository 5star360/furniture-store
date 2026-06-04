<?php
$pageTitle = 'Login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login – Pivot Home</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/furniture-store/assets/css/style.css">
</head>
<body>
<div class="auth-page">
  <div class="auth-left">
    <div class="brand">🛋️ Pivot Home</div>
    <h2>Welcome back to your space.</h2>
    <p>Sign in to browse our curated collection of premium furniture.</p>
  </div>
  <div class="auth-right">
    <div>
      <h2 style="font-size:1.7rem;font-weight:800;color:var(--brown);margin-bottom:6px;">Sign In</h2>
      <p style="color:var(--text-muted);margin-bottom:28px;">
        Don't have an account? <a href="/furniture-store/register.php" style="color:var(--rose);">Create one</a>
      </p>
      <form method="POST">
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" class="form-control" placeholder="you@example.com">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="Your password">
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Sign In →</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
