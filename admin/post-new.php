<?php
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/db.php';
requireLogin();

$db = getDB();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrf()) { $errors[] = 'Security check failed.'; }
    $title    = trim($_POST['title'] ?? '');
    $slug     = trim($_POST['slug'] ?? '') ?: slugify($title);
    $catId    = (int)($_POST['category_id'] ?? 0) ?: null;
    $excerpt  = trim($_POST['excerpt'] ?? '');
    $content  = $_POST['content'] ?? '';
    $status   = in_array($_POST['status'] ?? '', ['draft','published']) ? $_POST['status'] : 'draft';
    if (!$title)   $errors[] = 'Title is required.';
    if (!$content) $errors[] = 'Content is required.';

    // Handle image upload
    $coverImage = null;
    if (!empty($_FILES['cover_image']['name'])) {
        $ext = strtolower(pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
            $errors[] = 'Invalid image format.';
        } elseif ($_FILES['cover_image']['size'] > 5*1024*1024) {
            $errors[] = 'Image must be under 5MB.';
        } else {
            $coverImage = uniqid('post_') . '.' . $ext;
            move_uploaded_file($_FILES['cover_image']['tmp_name'], __DIR__ . '/../uploads/blog/' . $coverImage);
        }
    }

    // Ensure unique slug
    if (empty($errors)) {
        $slugBase = slugify($slug);
        $slugFinal = $slugBase;
        $i = 1;
        while ($db->prepare("SELECT id FROM posts WHERE slug=?")->execute([$slugFinal]) && $db->prepare("SELECT id FROM posts WHERE slug=?")->execute([$slugFinal]) && $db->query("SELECT COUNT(*) FROM posts WHERE slug='$slugFinal'")->fetchColumn() > 0) {
            $slugFinal = $slugBase . '-' . $i++;
        }
        $stmt = $db->prepare("INSERT INTO posts (admin_id,category_id,title,slug,excerpt,content,cover_image,status) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->execute([$_SESSION['admin_id'], $catId, $title, $slugFinal, $excerpt, $content, $coverImage, $status]);
        setFlash('success', 'Post ' . ($status==='published'?'published':'saved as draft') . ' successfully!');
        header('Location: /admin/posts.php'); exit;
    }
}

$cats = $db->query("SELECT * FROM categories ORDER BY name")->fetchAll();
$adminCounts = [
    'posts'  => $db->query("SELECT COUNT(*) FROM posts WHERE status='published'")->fetchColumn(),
    'unread' => $db->query("SELECT COUNT(*) FROM messages WHERE read_at IS NULL")->fetchColumn(),
];
$adminTitle = 'New Post | Nexos Admin';
$adminPage  = 'post-new';
include __DIR__ . '/partials/layout_head.php';
?>

<style>
.post-layout{display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start}
.post-editor-wrap{display:flex;flex-direction:column;gap:20px}
.sidebar-stack{display:flex;flex-direction:column;gap:16px;position:sticky;top:80px}
.img-preview{width:100%;height:160px;background:var(--bg3);border-radius:8px;border:2px dashed var(--border);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px;overflow:hidden;cursor:pointer;transition:border-color .2s}
.img-preview:hover{border-color:rgba(21,101,255,.4)}
.img-preview img{width:100%;height:100%;object-fit:cover}
@media(max-width:900px){.post-layout{grid-template-columns:1fr}}
</style>

<?php if(!empty($errors)): ?><div class="flash flash-error"><?= implode('<br>', array_map('h', $errors)) ?></div><?php endif; ?>

<form method="POST" enctype="multipart/form-data">
  <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
  <div class="post-layout">

    <!-- Editor -->
    <div class="post-editor-wrap">
      <div class="form-section">
        <div class="form-group">
          <label>Post Title *</label>
          <input type="text" name="title" id="post-title" placeholder="Enter an engaging post title…" value="<?= h($_POST['title'] ?? '') ?>" required style="font-size:18px;font-weight:700;font-family:var(--font-h)">
        </div>
        <div class="form-group">
          <label>Slug (URL)</label>
          <input type="text" name="slug" id="post-slug" placeholder="auto-generated-from-title" value="<?= h($_POST['slug'] ?? '') ?>">
          <div class="form-hint">Leave empty to auto-generate from title</div>
        </div>
        <div class="form-group">
          <label>Excerpt / Meta Description</label>
          <textarea name="excerpt" rows="3" placeholder="A brief 1-2 sentence summary of the post for the blog listing and SEO…"><?= h($_POST['excerpt'] ?? '') ?></textarea>
        </div>
      </div>

      <div class="form-section">
        <div class="form-section-title">Content *</div>
        <div class="editor-toolbar">
          <button type="button" onclick="fmt('bold')" title="Bold"><strong>B</strong></button>
          <button type="button" onclick="fmt('italic')" title="Italic"><em>I</em></button>
          <button type="button" onclick="wrapSel('<h2>','</h2>')" title="Heading 2">H2</button>
          <button type="button" onclick="wrapSel('<h3>','</h3>')" title="Heading 3">H3</button>
          <button type="button" onclick="wrapSel('<p>','</p>')" title="Paragraph">P</button>
          <button type="button" onclick="insertList('ul')" title="Bullet list">• List</button>
          <button type="button" onclick="insertList('ol')" title="Numbered list">1. List</button>
          <button type="button" onclick="wrapSel('<blockquote>','</blockquote>')" title="Blockquote">❝</button>
          <button type="button" onclick="wrapSel('<strong>','</strong>')" title="Strong">Bold</button>
          <button type="button" onclick="insertLink()" title="Link">Link</button>
          <button type="button" onclick="wrapSel('<code>','</code>')" title="Code">{'`'}</button>
          <button type="button" onclick="wrapSel('<pre><code>','</code></pre>')" title="Code block">Code Block</button>
          <button type="button" onclick="previewHTML()" title="Preview" style="margin-left:auto;color:var(--blue2)">👁 Preview</button>
        </div>
        <textarea id="post-content-editor" name="content" placeholder="Write your post content in HTML. Use the toolbar above to insert formatting tags…"><?= h($_POST['content'] ?? '') ?></textarea>
        <div class="form-hint">Write in HTML or use the toolbar. Preview will show rendered output.</div>
      </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar-stack">
      <div class="form-section">
        <div class="form-section-title">Publish</div>
        <div class="form-group">
          <label>Status</label>
          <select name="status">
            <option value="draft" <?= ($_POST['status']??'draft')==='draft' ? 'selected' : '' ?>>Draft</option>
            <option value="published" <?= ($_POST['status']??'')==='published' ? 'selected' : '' ?>>Published</option>
          </select>
        </div>
        <div style="display:flex;gap:8px;margin-top:4px">
          <button type="submit" name="status" value="draft" class="btn-outline" style="flex:1;justify-content:center">Save Draft</button>
          <button type="submit" name="status" value="published" class="btn-primary" style="flex:1;justify-content:center">Publish</button>
        </div>
      </div>

      <div class="form-section">
        <div class="form-section-title">Category</div>
        <div class="form-group" style="margin-bottom:0">
          <select name="category_id">
            <option value="">No category</option>
            <?php foreach($cats as $c): ?>
            <option value="<?= $c['id'] ?>" <?= ($_POST['category_id']??'')==$c['id'] ? 'selected' : '' ?>><?= h($c['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="form-section">
        <div class="form-section-title">Cover Image</div>
        <div class="form-group" style="margin-bottom:0">
          <div class="img-preview" id="img-preview" onclick="document.getElementById('cover-input').click()">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none"><rect x="2" y="5" width="28" height="22" rx="4" stroke="rgba(200,210,240,.3)" stroke-width="1.5"/><circle cx="10" cy="12" r="2.5" stroke="rgba(200,210,240,.3)" stroke-width="1.5"/><path d="M2 23l8-8 5 5 4-4 9 9" stroke="rgba(200,210,240,.3)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span style="font-size:12px;color:var(--sub)">Click to upload</span>
          </div>
          <input type="file" id="cover-input" name="cover_image" accept="image/*" style="display:none" onchange="previewImg(this)">
          <div class="form-hint">JPG, PNG, WebP – max 5MB</div>
        </div>
      </div>
    </div>
  </div>
</form>

<!-- HTML Preview Modal -->
<div id="preview-modal" style="display:none;position:fixed;inset:0;z-index:1000;background:rgba(0,0,0,.8);backdrop-filter:blur(10px);padding:40px;overflow-y:auto">
  <div style="background:var(--bg2);border:1px solid var(--border);border-radius:16px;max-width:760px;margin:0 auto;padding:40px">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;border-bottom:1px solid var(--border);padding-bottom:16px">
      <div style="font-family:var(--font-h);font-weight:700;color:var(--text)">Content Preview</div>
      <button onclick="document.getElementById('preview-modal').style.display='none'" style="color:var(--sub);font-size:24px;background:none;border:none;cursor:pointer;padding:4px">×</button>
    </div>
    <div id="preview-content" style="font-size:15px;color:rgba(200,210,240,.8);line-height:1.9;word-break:break-word"></div>
  </div>
</div>

<script>
// Auto-slug from title
document.getElementById('post-title').addEventListener('input', function() {
  const slugEl = document.getElementById('post-slug');
  if (!slugEl.dataset.manual) {
    slugEl.value = this.value.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/[\s-]+/g,'-').replace(/^-|-$/g,'');
  }
});
document.getElementById('post-slug').addEventListener('input', function() {
  this.dataset.manual = '1';
});

// Toolbar helpers
function fmt(cmd){ document.getElementById('post-content-editor').focus(); document.execCommand(cmd); }
function wrapSel(open, close) {
  const ta = document.getElementById('post-content-editor');
  const start = ta.selectionStart, end = ta.selectionEnd;
  const sel = ta.value.substring(start, end);
  ta.value = ta.value.substring(0,start) + open + sel + close + ta.value.substring(end);
  ta.focus();
  ta.selectionStart = start + open.length;
  ta.selectionEnd = start + open.length + sel.length;
}
function insertList(type) {
  const ta = document.getElementById('post-content-editor');
  const pos = ta.selectionStart;
  const ins = `<${type}>\n  <li>Item 1</li>\n  <li>Item 2</li>\n</${type}>`;
  ta.value = ta.value.substring(0,pos) + ins + ta.value.substring(pos);
  ta.focus();
}
function insertLink() {
  const url = prompt('Enter URL:', 'https://');
  if (!url) return;
  wrapSel('<a href="' + url + '">', '</a>');
}
function previewHTML() {
  document.getElementById('preview-content').innerHTML = document.getElementById('post-content-editor').value;
  document.getElementById('preview-modal').style.display = 'block';
}
// Image preview
function previewImg(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => {
      const p = document.getElementById('img-preview');
      p.innerHTML = '<img src="' + e.target.result + '">';
    };
    reader.readAsDataURL(input.files[0]);
  }
}
document.addEventListener('keydown', e => { if (e.key==='Escape') document.getElementById('preview-modal').style.display='none'; });
</script>

<?php include __DIR__ . '/partials/layout_foot.php'; ?>
