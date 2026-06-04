<?php
$adminTitle = 'All Users';
require_once __DIR__ . '/admin_header.php';

$users = $conn->query("SELECT id, name, email, phone, role, created_at FROM users ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
?>

<div class="table-card">
  <div class="table-card-header">
    <h2>All Users (<?= count($users) ?>)</h2>
  </div>

  <div style="overflow-x:auto;">
    <table class="data-table">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Role</th>
          <th>Joined</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $u): ?>
        <tr>
          <td style="color:var(--text-muted);font-size:.8rem;"><?= $u['id'] ?></td>
          <td>
            <div style="display:flex;align-items:center;gap:10px;">
              <div style="width:34px;height:34px;border-radius:50%;background:var(--grey-light);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.9rem;color:var(--brown);flex-shrink:0;">
                <?= strtoupper(substr($u['name'], 0, 1)) ?>
              </div>
              <strong><?= htmlspecialchars($u['name']) ?></strong>
            </div>
          </td>
          <td style="color:var(--text-muted);"><?= htmlspecialchars($u['email']) ?></td>
          <td style="color:var(--text-muted);"><?= htmlspecialchars($u['phone'] ?? '—') ?></td>
          <td>
            <?php if ($u['role'] === 'admin'): ?>
              <span style="background:var(--brown);color:#fff;padding:3px 12px;border-radius:20px;font-size:.75rem;font-weight:700;">Admin</span>
            <?php else: ?>
              <span style="background:var(--grey-light);color:var(--brown);padding:3px 12px;border-radius:20px;font-size:.75rem;font-weight:700;">Customer</span>
            <?php endif; ?>
          </td>
          <td style="font-size:.8rem;color:var(--text-muted);"><?= date('d M Y', strtotime($u['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/admin_footer.php'; ?>
