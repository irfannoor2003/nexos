<?php
require_once '../includes/helpers.php';
require_once '../includes/db.php';
requireLogin();

$db = getDB();
$id = (int)($_GET['id'] ?? 0);
if (!$id) { header('Location: posts.php'); exit; }

$post = $db->query("SELECT * FROM posts WHERE id = $id")->fetch();
if (!$post) { setFlash('error','Post not found.'); header('Location: posts.php'); exit; }

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf($_POST['csrf'] ?? '');
    $title       = trim($_POST['title'] ?? '');
    $slug        = slugify(trim($_POST['slug'] ?? $title));
    $excerpt     = trim($_POST['excerpt'] ?? '');
    $content     = $_POST['content'] ?? '';
    $category_id = (int)($_POST['category_id'] ?? 0);
    $status      = in_array($_POST['status']??'', ['published','draft']) ? $_POST['status'] : 'draft';

    if (!$title) { $error = 'Title is required.'; }
    else {
        // Check slug uniqueness (exclude self)
        $check = $db->prepare("SELECT id FROM posts WHERE slug=? AND id!=?");
        $check->execute([$slug, $id]);
        if ($check->fetch()) $slug .= '-' . time();

        // Cover image
        $cover = $post['cover_image'];
        if (!empty($_FILES['cover_image']['tmp_name'])) {
            $ext = strtolower(pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg','jpeg','png','webp','gif'])) {
                $fname = 'blog-' . time() . '-' . rand(1000,9999) . '.' . $ext;
                $dest  = __DIR__ . '/../uploads/blog/' . $fname;
                if (move_uploaded_file($_FILES['cover_image']['tmp_name'], $dest)) {
                    $cover = '/uploads/blog/' . $fname;
                }
            }
        }

        $stmt = $db->prepare("UPDATE posts SET title=?,slug=?,excerpt=?,content=?,category_id=?,cover_image=?,status=?,updated_at=NOW() WHERE id=?");
        $stmt->execute([$title, $slug, $excerpt, $content, $category_id ?: null, $cover, $status, $id]);
        setFlash('success','Post updated successfully.');
        header('Location: posts.php'); exit;
    }
}

$categories = $db->query("SELECT * FROM categories ORDER BY name")->fetchAll();

// Get counts for sidebar
$adminCounts = [
    'posts'  => $db->query("SELECT COUNT(*) FROM posts WHERE status='published'")->fetchColumn(),
    'unread' => $db->query("SELECT COUNT(*) FROM messages WHERE read_at IS NULL")->fetchColumn(),
];
$adminPage  = 'posts';
$adminTitle = 'Edit Post';
require 'partials/layout_head.php';
?>

<div style="max-width:860px">

  <?php if (!empty($error)): ?>
    <div class="flash flash-error"><?= h($error) ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf" value="<?= csrfToken() ?>">

    <!-- Title & Slug -->
    <div class="form-section">
      <div class="form-section-title">Post Details</div>
      <div class="form-group">
        <label>Post Title *</label>
        <input type="text" name="title" id="post-title" value="<?= h($post['title']) ?>" required placeholder="Enter post title…">
      </div>
      <div class="form-group">
        <label>URL Slug</label>
        <input type="text" name="slug" id="post-slug" value="<?= h($post['slug']) ?>" placeholder="auto-generated-from-title">
        <div class="form-hint">URL: <code>/blog/<?= h($post['slug']) ?></code></div>
      </div>
      <div class="form-group">
        <label>Excerpt <span style="font-weight:400;color:var(--sub)">(Short summary for cards)</span></label>
        <textarea name="excerpt" rows="2" placeholder="A brief description of the post…"><?= h($post['excerpt']) ?></textarea>
      </div>
    </div>

    <!-- Content -->
    <div class="form-section">
      <div class="form-section-title">Content</div>
      <div class="form-group">
        <label>Post Body (HTML supported)</label>
        <div class="editor-toolbar">
          <button type="button" onclick="fmt('bold')"><b>B</b></button>
          <button type="button" onclick="fmt('italic')"><i>I</i></button>
          <button type="button" onclick="wrapTag('h2')">H2</button>
          <button type="button" onclick="wrapTag('h3')">H3</button>
          <button type="button" onclick="wrapTag('p')">P</button>
          <button type="button" onclick="insertList('ul')">UL</button>
          <button type="button" onclick="insertList('ol')">OL</button>
          <button type="button" onclick="wrapTag('blockquote')">Quote</button>
          <button type="button" onclick="insertLink()">Link</button>
          <button type="button" onclick="wrapTag('code')">Code</button>
          <button type="button" onclick="togglePreview()" id="preview-btn">Preview</button>
        </div>
        <textarea name="content" id="post-content-editor"><?= h($post['content']) ?></textarea>
        <div id="post-preview" style="display:none;padding:20px;background:var(--bg3);border:1.5px solid var(--border);border-radius:0 0 8px 8px;min-height:200px;line-height:1.8;color:var(--text);font-size:14px"></div>
      </div>
    </div>

    <!-- Meta -->
    <div class="form-section">
      <div class="form-section-title">Publishing</div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
        <div class="form-group">
          <label>Category</label>
          <select name="category_id">
            <option value="">— No Category —</option>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= $cat['id'] ?>" <?= $post['category_id'] == $cat['id'] ? 'selected' : '' ?>><?= h($cat['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="status">
            <option value="draft" <?= $post['status']==='draft' ? 'selected' : '' ?>>Draft</option>
            <option value="published" <?= $post['status']==='published' ? 'selected' : '' ?>>Published</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label>Cover Image</label>
        <?php if ($post['cover_image']): ?>
          <div style="margin-bottom:10px">
            <img src="<?= h($post['cover_image']) ?>" alt="Current cover" style="height:80px;border-radius:8px;border:1px solid var(--border)">
            <div class="form-hint">Current cover — upload a new one to replace.</div>
          </div>
        <?php endif; ?>
        <input type="file" name="cover_image" accept="image/*" style="padding:8px;font-size:13px">
        <div class="form-hint">JPG, PNG, WebP — max 5MB</div>
      </div>
    </div>

    <div style="display:flex;gap:12px;align-items:center">
      <button type="submit" class="btn-primary">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 7l4 4 6-6" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Update Post
      </button>
      <a href="posts.php" class="btn-outline">Cancel</a>
      <?php if ($post['status'] === 'published'): ?>
        <a href="/blog/<?= h($post['slug']) ?>" target="_blank" class="btn-outline btn-sm" style="margin-left:auto">View Live →</a>
      <?php endif; ?>
    </div>
  </form>
</div>

<script>
// Auto-slug (only change if slug hasn't been manually edited)
const titleEl = document.getElementById('post-title');
const slugEl  = document.getElementById('post-slug');
let slugManual = true; // editing existing post — don't auto-update slug
slugEl.addEventListener('input', () => { slugManual = true; });

function slugify(s) {
  return s.toLowerCase().trim().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
}

// Editor helpers
function fmt(cmd) { document.execCommand(cmd); }
function wrapTag(tag) {
  const ta = document.getElementById('post-content-editor');
  const start = ta.selectionStart, end = ta.selectionEnd;
  const sel = ta.value.slice(start, end) || 'Your text here';
  ta.setRangeText(`<${tag}>${sel}</${tag}>`, start, end, 'select');
  ta.focus();
}
function insertList(type) {
  const ta = document.getElementById('post-content-editor');
  const ins = `<${type}>\n  <li>Item one</li>\n  <li>Item two</li>\n</${type}>`;
  ta.setRangeText(ins, ta.selectionStart, ta.selectionEnd, 'end');
  ta.focus();
}
function insertLink() {
  const url = prompt('Enter URL:', 'https://');
  if (!url) return;
  const ta = document.getElementById('post-content-editor');
  const start = ta.selectionStart, end = ta.selectionEnd;
  const text = ta.value.slice(start, end) || 'Link text';
  ta.setRangeText(`<a href="${url}">${text}</a>`, start, end, 'end');
  ta.focus();
}
function togglePreview() {
  const ta = document.getElementById('post-content-editor');
  const pv = document.getElementById('post-preview');
  const btn = document.getElementById('preview-btn');
  if (pv.style.display === 'none') {
    pv.innerHTML = ta.value;
    pv.style.display = 'block';
    ta.style.display = 'none';
    btn.textContent = 'Edit';
  } else {
    pv.style.display = 'none';
    ta.style.display = 'block';
    btn.textContent = 'Preview';
  }
}
</script>

<?php require 'partials/layout_foot.php'; ?>
