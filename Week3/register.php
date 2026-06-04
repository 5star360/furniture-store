<?php $pageTitle = 'Register'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register – Pivot Home</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/furniture-store/assets/css/style.css">
</head>
<body>
<div class="auth-page">
  <div class="auth-left">
    <div class="brand">🛋️ Pivot Home</div>
    <h2>Join our community.</h2>
    <p>Create an account to start shopping premium furniture.</p>
  </div>
  <div class="auth-right">
    <div>
      <h2 style="font-size:1.7rem;font-weight:800;color:var(--brown);margin-bottom:6px;">Create Account</h2>
      <p style="color:var(--text-muted);margin-bottom:28px;">
        Already have an account? <a href="/furniture-store/login.php" style="color:var(--rose);">Sign in</a>
      </p>
      <form method="POST">
        <div class="form-group">
          <label>Full Name</label>
          <input type="text" name="name" class="form-control" placeholder="Jane Doe">
        </div>
        <div class="form-group">
          <label>Email Address</label>
          <input type="email" name="email" class="form-control" placeholder="you@example.com">
        </div>
        <div class="form-group">
          <label>Phone (optional)</label>
          <input type="tel" name="phone" class="form-control" placeholder="+254 700 000 000">
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" class="form-control" placeholder="Min. 8 characters">
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Create Account →</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
