<?php
require_once '../includes/helpers.php';
require_once '../includes/db.php';
requireLogin();

$db = getDB();

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf($_POST['csrf'] ?? '');
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $name = trim($_POST['name'] ?? '');
        if ($name) {
            $slug = slugify($name);
            // Ensure unique slug
            $check = $db->prepare("SELECT id FROM categories WHERE slug=?");
            $check->execute([$slug]);
            if ($check->fetch()) $slug .= '-' . time();
            $stmt = $db->prepare("INSERT INTO categories (name, slug) VALUES (?,?)");
            $stmt->execute([$name, $slug]);
            setFlash('success', "Category \"$name\" added.");
        } else {
            setFlash('error', 'Category name is required.');
        }
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        // Nullify category on posts
        $db->prepare("UPDATE posts SET category_id=NULL WHERE category_id=?")->execute([$id]);
        $db->prepare("DELETE FROM categories WHERE id=?")->execute([$id]);
        setFlash('success', 'Category deleted.');
    }

    if ($action === 'edit') {
        $id   = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        if ($name && $id) {
            $slug = slugify($name);
            $check = $db->prepare("SELECT id FROM categories WHERE slug=? AND id!=?");
            $check->execute([$slug, $id]);
            if ($check->fetch()) $slug .= '-' . time();
            $db->prepare("UPDATE categories SET name=?, slug=? WHERE id=?")->execute([$name, $slug, $id]);
            setFlash('success', 'Category updated.');
        }
    }

    header('Location: categories.php'); exit;
}

$categories = $db->query("
    SELECT c.*, COUNT(p.id) as post_count
    FROM categories c
    LEFT JOIN posts p ON p.category_id = c.id
    GROUP BY c.id
    ORDER BY c.name
")->fetchAll();

$adminCounts = [
    'posts'  => $db->query("SELECT COUNT(*) FROM posts WHERE status='published'")->fetchColumn(),
    'unread' => $db->query("SELECT COUNT(*) FROM messages WHERE read_at IS NULL")->fetchColumn(),
];
$adminPage  = 'categories';
$adminTitle = 'Categories';
require 'partials/layout_head.php';
?>

<div class="admin-grid">

  <!-- Categories Table -->
  <div>
    <div class="table-card">
      <div class="table-head">
        <div class="table-head-title">All Categories <span style="font-weight:400;color:var(--sub);font-size:12px">(<?= count($categories) ?>)</span></div>
      </div>
      <?php if (empty($categories)): ?>
        <div style="padding:40px;text-align:center;color:var(--sub);font-size:14px">No categories yet. Add one →</div>
      <?php else: ?>
        <table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Slug</th>
              <th>Posts</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($categories as $cat): ?>
              <tr>
                <td class="td-title"><?= h($cat['name']) ?></td>
                <td><code style="font-size:12px;color:var(--sub)"><?= h($cat['slug']) ?></code></td>
                <td><?= $cat['post_count'] ?></td>
                <td>
                  <div style="display:flex;gap:8px;align-items:center">
                    <!-- Inline edit form -->
                    <button onclick="openEdit(<?= $cat['id'] ?>, '<?= h(addslashes($cat['name'])) ?>')" class="btn-outline btn-sm">Edit</button>
                    <?php if ($cat['post_count'] == 0): ?>
                      <form method="POST" style="display:inline" onsubmit="return confirm('Delete this category?')">
                        <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                        <button type="submit" class="btn-danger btn-sm">Delete</button>
                      </form>
                    <?php else: ?>
                      <span style="font-size:11px;color:var(--sub)" title="Can't delete — has posts">🔒 In use</span>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>

  <!-- Sidebar: Add / Edit -->
  <div>
    <!-- Add New -->
    <div class="form-section">
      <div class="form-section-title">Add New Category</div>
      <form method="POST">
        <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
        <input type="hidden" name="action" value="add">
        <div class="form-group">
          <label>Category Name *</label>
          <input type="text" name="name" placeholder="e.g. SEO Tips" required>
        </div>
        <button type="submit" class="btn-primary" style="width:100%;justify-content:center">Add Category</button>
      </form>
    </div>

    <!-- Edit (shown when edit button clicked) -->
    <div class="form-section" id="edit-form" style="display:none">
      <div class="form-section-title">Edit Category</div>
      <form method="POST">
        <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" id="edit-id">
        <div class="form-group">
          <label>Category Name *</label>
          <input type="text" name="name" id="edit-name" required>
        </div>
        <div style="display:flex;gap:8px">
          <button type="submit" class="btn-primary">Save Changes</button>
          <button type="button" onclick="closeEdit()" class="btn-outline">Cancel</button>
        </div>
      </form>
    </div>

    <div style="background:var(--card);border:1px solid var(--border);border-radius:16px;padding:20px">
      <div style="font-family:var(--font-h);font-size:13px;font-weight:600;color:var(--text);margin-bottom:10px">ℹ️ Note</div>
      <p style="font-size:12.5px;color:var(--sub);line-height:1.7">Categories help organize your blog posts. Deleting a category is only possible when no posts are assigned to it.</p>
    </div>
  </div>
</div>

<script>
function openEdit(id, name) {
  document.getElementById('edit-id').value = id;
  document.getElementById('edit-name').value = name;
  document.getElementById('edit-form').style.display = 'block';
  document.getElementById('edit-name').focus();
}
function closeEdit() {
  document.getElementById('edit-form').style.display = 'none';
}
</script>

<?php require 'partials/layout_foot.php'; ?>
