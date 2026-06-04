<footer class="site-footer">
  <div class="footer-inner">
    <div class="footer-top">
      <div>
        <div class="footer-brand">🛋️ Pivot Home</div>
        <p class="footer-tagline">Crafting beautiful spaces, one piece at a time. Premium furniture for modern living.</p>
      </div>
      <div class="footer-col">
        <h4>Shop</h4>
        <a href="/furniture-store/index.php?cat=Sofas">Sofas</a>
        <a href="/furniture-store/index.php?cat=Chairs">Chairs</a>
        <a href="/furniture-store/index.php?cat=Beds">Beds</a>
        <a href="/furniture-store/index.php?cat=Tables">Tables</a>
        <a href="/furniture-store/index.php?cat=Wardrobes">Wardrobes</a>
        <a href="/furniture-store/index.php?cat=Shelves">Shelves</a>
      </div>
      <div class="footer-col">
        <h4>Account</h4>
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="/furniture-store/index.php">My Account</a>
          <a href="/furniture-store/logout.php">Logout</a>
        <?php else: ?>
          <a href="/furniture-store/login.php">Login</a>
          <a href="/furniture-store/register.php">Register</a>
        <?php endif; ?>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <a href="/furniture-store/admin/dashboard.php">Admin Panel</a>
        <?php endif; ?>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; <?= date('Y') ?> Pivot Home. All rights reserved. &nbsp;|&nbsp; BIT3208 CAT 1 Project</p>
    </div>
  </div>
</footer>
<script src="/furniture-store/assets/js/main.js"></script>
</body>
</html>
