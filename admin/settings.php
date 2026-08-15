<?php
require_once '../includes/helpers.php';
require_once '../includes/db.php';
requireLogin();

$db = getDB();

// Handle save
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf($_POST['csrf'] ?? '');
    $action = $_POST['action'] ?? 'settings';

    if ($action === 'settings') {
        $fields = ['site_name','site_tagline','site_email','site_phone','site_address',
                   'footer_desc','twitter_url','linkedin_url','instagram_url','facebook_url',
                   'meta_description','google_analytics'];
        foreach ($fields as $key) {
            $val = trim($_POST[$key] ?? '');
            $stmt = $db->prepare("INSERT INTO settings (`key`, `value`) VALUES (?,?) ON DUPLICATE KEY UPDATE `value`=?");
            $stmt->execute([$key, $val, $val]);
        }
        setFlash('success', 'Settings saved successfully.');
    }

    if ($action === 'password') {
        $current = $_POST['current_password'] ?? '';
        $new     = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        $admin   = $db->query("SELECT * FROM admins WHERE id=" . (int)$_SESSION['admin_id'])->fetch();
        if (!password_verify($current, $admin['password'])) {
            setFlash('error', 'Current password is incorrect.');
        } elseif (strlen($new) < 6) {
            setFlash('error', 'New password must be at least 6 characters.');
        } elseif ($new !== $confirm) {
            setFlash('error', 'Passwords do not match.');
        } else {
            $hash = password_hash($new, PASSWORD_DEFAULT);
            $db->prepare("UPDATE admins SET password=? WHERE id=?")->execute([$hash, $_SESSION['admin_id']]);
            setFlash('success', 'Password updated successfully.');
        }
    }

    header('Location: settings.php'); exit;
}

// Load all settings
$rows = $db->query("SELECT `key` as k, `value` as v FROM settings")->fetchAll();
$s = [];
foreach ($rows as $r) $s[$r['k']] = $r['v'];
$get = fn($k, $d='') => $s[$k] ?? $d;

$adminCounts = [
    'posts'  => $db->query("SELECT COUNT(*) FROM posts WHERE status='published'")->fetchColumn(),
    'unread' => $db->query("SELECT COUNT(*) FROM messages WHERE read_at IS NULL")->fetchColumn(),
];
$adminPage  = 'settings';
$adminTitle = 'Settings';
require 'partials/layout_head.php';
?>

<div style="max-width:760px">

  <!-- Site Settings -->
  <div class="form-section">
    <div class="form-section-title">Site Settings</div>
    <form method="POST">
      <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
      <input type="hidden" name="action" value="settings">

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
        <div class="form-group">
          <label>Site Name</label>
          <input type="text" name="site_name" value="<?= h($get('site_name','Nexos Digital')) ?>">
        </div>
        <div class="form-group">
          <label>Tagline</label>
          <input type="text" name="site_tagline" value="<?= h($get('site_tagline','Premium Digital Growth Agency')) ?>">
        </div>
        <div class="form-group">
          <label>Contact Email</label>
          <input type="text" name="site_email" value="<?= h($get('site_email','hello@nexosdigital.com')) ?>">
        </div>
        <div class="form-group">
          <label>Phone Number</label>
          <input type="text" name="site_phone" value="<?= h($get('site_phone')) ?>">
        </div>
      </div>
      <div class="form-group">
        <label>Address</label>
        <input type="text" name="site_address" value="<?= h($get('site_address')) ?>" placeholder="e.g. 123 Business Ave, Lahore, Pakistan">
      </div>
      <div class="form-group">
        <label>Footer Description</label>
        <textarea name="footer_desc" rows="2"><?= h($get('footer_desc','Your premium digital growth partner.')) ?></textarea>
      </div>
      <div class="form-group">
        <label>Meta Description <span style="font-weight:400">(SEO)</span></label>
        <textarea name="meta_description" rows="2" placeholder="Shown in search engine results..."><?= h($get('meta_description')) ?></textarea>
      </div>
      <div class="form-group">
        <label>Google Analytics ID</label>
        <input type="text" name="google_analytics" value="<?= h($get('google_analytics')) ?>" placeholder="G-XXXXXXXXXX">
        <div class="form-hint">Enter your GA4 Measurement ID</div>
      </div>
      <button type="submit" class="btn-primary">Save Settings</button>
    </form>
  </div>

  <!-- Social Links -->
  <div class="form-section">
    <div class="form-section-title">Social Media Links</div>
    <form method="POST">
      <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
      <input type="hidden" name="action" value="settings">
      <!-- Carry over site settings as hidden fields so they don't get blanked -->
      <?php foreach(['site_name','site_tagline','site_email','site_phone','site_address','footer_desc','meta_description','google_analytics'] as $k): ?>
        <input type="hidden" name="<?= $k ?>" value="<?= h($get($k)) ?>">
      <?php endforeach; ?>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
        <div class="form-group">
          <label>Twitter / X URL</label>
          <input type="text" name="twitter_url" value="<?= h($get('twitter_url')) ?>" placeholder="https://twitter.com/nexos">
        </div>
        <div class="form-group">
          <label>LinkedIn URL</label>
          <input type="text" name="linkedin_url" value="<?= h($get('linkedin_url')) ?>" placeholder="https://linkedin.com/company/nexos">
        </div>
        <div class="form-group">
          <label>Instagram URL</label>
          <input type="text" name="instagram_url" value="<?= h($get('instagram_url')) ?>" placeholder="https://instagram.com/nexos">
        </div>
        <div class="form-group">
          <label>Facebook URL</label>
          <input type="text" name="facebook_url" value="<?= h($get('facebook_url')) ?>" placeholder="https://facebook.com/nexos">
        </div>
      </div>
      <button type="submit" class="btn-primary">Save Social Links</button>
    </form>
  </div>

  <!-- Change Password -->
  <div class="form-section">
    <div class="form-section-title">Change Admin Password</div>
    <form method="POST" autocomplete="off">
      <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
      <input type="hidden" name="action" value="password">
      <div class="form-group">
        <label>Current Password</label>
        <input type="password" name="current_password" autocomplete="current-password">
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
        <div class="form-group">
          <label>New Password</label>
          <input type="password" name="new_password" autocomplete="new-password">
        </div>
        <div class="form-group">
          <label>Confirm New Password</label>
          <input type="password" name="confirm_password" autocomplete="new-password">
        </div>
      </div>
      <button type="submit" class="btn-primary">Update Password</button>
    </form>
  </div>

  <!-- Info -->
  <div style="background:var(--card);border:1px solid var(--border);border-radius:16px;padding:20px">
    <div style="font-size:12px;color:var(--sub);line-height:1.75">
      <strong style="color:var(--text);font-family:var(--font-h)">Default Admin Credentials</strong><br>
      Email: <code>admin@nexosdigital.com</code> · Password: <code>admin123</code><br>
      <span style="color:#ff5555">⚠️ Change your password immediately after first login.</span>
    </div>
  </div>

</div>

<?php require 'partials/layout_foot.php'; ?>
