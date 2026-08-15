<?php
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/db.php';
requireLogin();
$adminTitle  = 'Image Manager | Admin';
$adminPage   = 'images';

$uploadDir = __DIR__ . '/../uploads/site/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$flash = '';
$errors = [];

// ── Handle upload / revert ──
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imgKey = $_POST['key'] ?? '';
    $action = $_POST['action'] ?? '';

    if (!verifyCsrf()) {
        $errors[] = 'Invalid security token.';
    } elseif (!$imgKey) {
        $errors[] = 'Missing image key.';
    } else {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM page_images WHERE image_key = ?");
        $stmt->execute([$imgKey]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            $errors[] = 'Image not found.';
        } elseif ($action === 'revert') {
            $stmt = $db->prepare("UPDATE page_images SET custom_path = NULL WHERE image_key = ?");
            $stmt->execute([$imgKey]);
            $flash = 'Image reverted to default.';
        } elseif ($action === 'upload' && !empty($_FILES['image']['name'])) {
            $file = $_FILES['image'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];

            if (!in_array($ext, $allowed)) {
                $errors[] = 'Invalid format. Allowed: jpg, jpeg, png, gif, webp, svg.';
            } elseif ($file['size'] > 5 * 1024 * 1024) {
                $errors[] = 'File must be under 5MB.';
            } elseif ($file['error'] !== UPLOAD_ERR_OK) {
                $errors[] = 'Upload failed (error code: ' . $file['error'] . ').';
            } else {
                $fname = $imgKey . '-' . time() . '.' . $ext;
                $dest = $uploadDir . $fname;
                if (move_uploaded_file($file['tmp_name'], $dest)) {
                    $path = '/uploads/site/' . $fname;
                    $stmt = $db->prepare("UPDATE page_images SET custom_path = ? WHERE image_key = ?");
                    $stmt->execute([$path, $imgKey]);
                    $flash = 'Image uploaded successfully.';
                } else {
                    $errors[] = 'Failed to move uploaded file.';
                }
            }
        }
    }

    if (!empty($errors)) {
        setFlash('error', implode('<br>', $errors));
    } else {
        setFlash('success', $flash);
    }
    header('Location: /admin/images.php');
    exit;
}

// ── Fetch all images ──
$db = getDB();
$allImages = $db->query("SELECT * FROM page_images ORDER BY page_section, id")->fetchAll(PDO::FETCH_ASSOC);
$grouped = [];
foreach ($allImages as $img) {
    $grouped[$img['page_section']][] = $img;
}

include __DIR__ . '/partials/layout_head.php';
?>

<style>
.img-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:20px}
.img-card{background:var(--card);border:1px solid var(--border);border-radius:16px;overflow:hidden;transition:border-color .2s}
.img-card:hover{border-color:rgba(255,255,255,.12)}
.img-preview{width:100%;height:180px;overflow:hidden;background:var(--bg3);display:flex;align-items:center;justify-content:center}
.img-preview img{width:100%;height:100%;object-fit:cover}
.img-preview .no-img{font-size:12px;color:var(--sub);opacity:.4}
.img-body{padding:16px 18px 18px}
.img-label{font-family:var(--font-h);font-size:13px;font-weight:600;color:var(--text);margin-bottom:2px}
.img-key{font-size:10.5px;color:var(--sub);opacity:.5;font-family:monospace;margin-bottom:10px}
.img-actions{display:flex;gap:8px;flex-wrap:wrap}
.img-actions .btn-sm{font-size:11px;padding:5px 12px}
.img-current-path{font-size:10px;color:var(--sub);opacity:.4;margin-top:8px;word-break:break-all;font-family:monospace}
.section-title{font-family:var(--font-h);font-size:18px;font-weight:700;color:var(--text);margin:32px 0 16px;padding-bottom:10px;border-bottom:1px solid var(--border)}
.section-title:first-of-type{margin-top:0}
</style>

<div style="margin-bottom:24px">
  <p style="font-size:14px;color:var(--sub);line-height:1.7">Upload new images for any section on the site. Each image slot has a default that will be used unless you upload a custom replacement.</p>
</div>

<div class="img-grid">
<?php foreach ($grouped as $section => $images): ?>
  <div style="grid-column:1/-1">
    <div class="section-title"><?= h($section) ?></div>
  </div>
  <?php foreach ($images as $img):
    $currentPath = $img['custom_path'] ?: $img['default_path'];
    $hasCustom = $img['custom_path'] !== null;
  ?>
  <div class="img-card">
    <div class="img-preview">
      <?php if ($currentPath): ?>
        <img src="<?= h($currentPath) ?>" alt="<?= h($img['label']) ?>" loading="lazy">
      <?php else: ?>
        <span class="no-img">No image</span>
      <?php endif; ?>
    </div>
    <div class="img-body">
      <div class="img-label"><?= h($img['label']) ?></div>
      <div class="img-key"><?= h($img['image_key']) ?></div>
      <div class="img-actions">
        <form method="post" enctype="multipart/form-data" style="display:flex;gap:6px;flex-wrap:wrap;align-items:center">
          <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
          <input type="hidden" name="key" value="<?= h($img['image_key']) ?>">
          <input type="hidden" name="action" value="upload">
          <label class="btn-outline btn-sm" style="cursor:pointer;margin:0">
            Choose File
            <input type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp,image/svg+xml" style="display:none" onchange="this.closest('form').querySelector('.file-name').textContent=this.files[0]?.name||'No file'">
          </label>
          <span class="file-name" style="font-size:10px;color:var(--sub);max-width:100px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"></span>
          <button type="submit" class="btn-primary btn-sm">Upload</button>
        </form>
        <?php if ($hasCustom): ?>
        <form method="post" style="display:inline" onsubmit="return confirm('Revert to default image?')">
          <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
          <input type="hidden" name="key" value="<?= h($img['image_key']) ?>">
          <input type="hidden" name="action" value="revert">
          <button type="submit" class="btn-danger btn-sm">Revert</button>
        </form>
        <?php endif; ?>
      </div>
      <div class="img-current-path"><?= h($currentPath) ?></div>
    </div>
  </div>
  <?php endforeach; ?>
<?php endforeach; ?>
</div>

<script>
// Auto-submit flash clean
<?php if ($flash): ?>
document.addEventListener('DOMContentLoaded',function(){
  var f=document.querySelector('.flash');
  if(f)setTimeout(function(){f.style.opacity='0';f.style.transition='opacity .5s'},3000);
});
<?php endif; ?>
</script>

<?php include __DIR__ . '/partials/layout_foot.php'; ?>
