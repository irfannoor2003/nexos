<?php
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/db.php';
requireLogin();

$db = getDB();

// Handle delete
if ($_GET['action'] ?? '' === 'delete' && isset($_GET['id'])) {
    if (verifyCsrf()) {
        $db->prepare("DELETE FROM posts WHERE id=?")->execute([(int)$_GET['id']]);
        setFlash('success', 'Post deleted.');
    }
    header('Location: /admin/posts.php'); exit;
}

// Counts for sidebar
$adminCounts = [
    'posts'  => $db->query("SELECT COUNT(*) FROM posts WHERE status='published'")->fetchColumn(),
    'unread' => $db->query("SELECT COUNT(*) FROM messages WHERE read_at IS NULL")->fetchColumn(),
];

$filter   = $_GET['status'] ?? '';
$search   = trim($_GET['q'] ?? '');
$page     = max(1, (int)($_GET['page'] ?? 1));
$perPage  = 15;

$where = '1=1';
$params = [];
if ($filter === 'published') { $where .= " AND p.status='published'"; }
if ($filter === 'draft')     { $where .= " AND p.status='draft'"; }
if ($search) { $where .= " AND p.title LIKE ?"; $params[] = "%$search%"; }

$total = $db->prepare("SELECT COUNT(*) FROM posts p WHERE $where");
$total->execute($params);
$total = (int)$total->fetchColumn();
$pager = paginate($total, $perPage, $page);

$stmt = $db->prepare("SELECT p.*, c.name as cat_name FROM posts p LEFT JOIN categories c ON p.category_id=c.id WHERE $where ORDER BY p.created_at DESC LIMIT ? OFFSET ?");
$stmt->execute(array_merge($params, [$perPage, $pager['offset']]));
$posts = $stmt->fetchAll();

$adminTitle = 'All Posts | Nexos Admin';
$adminPage  = 'posts';
include __DIR__ . '/partials/layout_head.php';
?>

<!-- Filters bar -->
<div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;margin-bottom:20px">
  <div style="display:flex;gap:6px;flex-wrap:wrap">
    <?php foreach([''=> 'All', 'published' => 'Published', 'draft' => 'Drafts'] as $val => $label): ?>
    <a href="/admin/posts.php?status=<?= $val ?><?= $search ? '&q='.urlencode($search) : '' ?>" style="padding:7px 14px;border-radius:8px;font-size:12px;font-weight:600;font-family:var(--font-h);border:1.5px solid <?= $filter===$val ? 'var(--blue)' : 'var(--border)' ?>;color:<?= $filter===$val ? 'var(--blue2)' : 'var(--sub)' ?>;background:<?= $filter===$val ? 'rgba(21,101,255,.1)' : 'transparent' ?>"><?= $label ?></a>
    <?php endforeach; ?>
  </div>
  <form method="GET" style="display:flex;gap:8px;align-items:center">
    <input type="hidden" name="status" value="<?= h($filter) ?>">
    <input type="text" name="q" placeholder="Search posts…" value="<?= h($search) ?>" style="width:220px;padding:8px 12px;font-size:13px">
    <button type="submit" class="btn-outline btn-sm">Search</button>
  </form>
</div>

<div class="table-card">
  <div class="table-head">
    <div class="table-head-title">Posts <span style="color:var(--sub);font-size:12px;font-weight:400">(<?= $total ?>)</span></div>
    <a href="/admin/post-new.php" class="btn-primary btn-sm">+ New Post</a>
  </div>
  <table>
    <thead><tr><th>Title</th><th>Category</th><th>Status</th><th>Views</th><th>Date</th><th>Actions</th></tr></thead>
    <tbody>
    <?php foreach($posts as $p): ?>
    <tr>
      <td class="td-title"><?= h(mb_strimwidth($p['title'],0,55,'…')) ?></td>
      <td><?= $p['cat_name'] ? h($p['cat_name']) : '<span style="color:rgba(200,210,240,.2)">—</span>' ?></td>
      <td><span class="badge badge-<?= $p['status'] ?>"><?= $p['status'] ?></span></td>
      <td><?= number_format($p['views']) ?></td>
      <td><?= date('M j, Y', strtotime($p['created_at'])) ?></td>
      <td style="display:flex;gap:6px;align-items:center">
        <a href="/admin/post-edit.php?id=<?= $p['id'] ?>" class="btn-outline btn-sm">Edit</a>
        <?php if($p['status']==='published'): ?>
        <a href="/blog/<?= h($p['slug']) ?>" target="_blank" class="btn-outline btn-sm">View</a>
        <?php endif; ?>
        <a href="/admin/posts.php?action=delete&id=<?= $p['id'] ?>&csrf=<?= csrfToken() ?>" class="btn-danger btn-sm" onclick="return confirm('Delete this post? This cannot be undone.')">Delete</a>
      </td>
    </tr>
    <?php endforeach; ?>
    <?php if(empty($posts)): ?><tr><td colspan="6" style="text-align:center;padding:40px;color:var(--sub)">No posts found. <a href="/admin/post-new.php" style="color:var(--blue2)">Create one →</a></td></tr><?php endif; ?>
    </tbody>
  </table>

  <?php if($pager['pages']>1): ?>
  <div style="display:flex;justify-content:center;gap:6px;padding:20px">
    <?php if($page>1): ?><a href="?page=<?=$page-1?>&status=<?=h($filter)?>&q=<?=h($search)?>" style="padding:7px 14px;border-radius:8px;border:1px solid var(--border);color:var(--sub);font-size:13px">←</a><?php endif; ?>
    <?php for($i=1;$i<=$pager['pages'];$i++): ?><a href="?page=<?=$i?>&status=<?=h($filter)?>&q=<?=h($search)?>" style="padding:7px 14px;border-radius:8px;border:1px solid <?=$i===$page?'var(--blue)':'var(--border)'?>;color:<?=$i===$page?'var(--blue2)':'var(--sub)'?>;background:<?=$i===$page?'rgba(21,101,255,.1)':'transparent'?>;font-size:13px;font-family:var(--font-h);font-weight:<?=$i===$page?'700':'400'?>"><?=$i?></a><?php endfor; ?>
    <?php if($page<$pager['pages']): ?><a href="?page=<?=$page+1?>&status=<?=h($filter)?>&q=<?=h($search)?>" style="padding:7px 14px;border-radius:8px;border:1px solid var(--border);color:var(--sub);font-size:13px">→</a><?php endif; ?>
  </div>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/partials/layout_foot.php'; ?>
