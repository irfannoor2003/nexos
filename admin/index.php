<?php
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/db.php';
requireLogin();

$db = getDB();
$adminCounts = [
    'posts'  => $db->query("SELECT COUNT(*) FROM posts WHERE status='published'")->fetchColumn(),
    'drafts' => $db->query("SELECT COUNT(*) FROM posts WHERE status='draft'")->fetchColumn(),
    'unread' => $db->query("SELECT COUNT(*) FROM messages WHERE read_at IS NULL")->fetchColumn(),
    'total_messages' => $db->query("SELECT COUNT(*) FROM messages")->fetchColumn(),
];

$recentPosts = $db->query("SELECT p.*, c.name as cat_name FROM posts p LEFT JOIN categories c ON p.category_id=c.id ORDER BY p.created_at DESC LIMIT 5")->fetchAll();
$recentMsgs  = $db->query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 5")->fetchAll();
$topPosts    = $db->query("SELECT * FROM posts WHERE status='published' ORDER BY views DESC LIMIT 5")->fetchAll();

$adminTitle = 'Dashboard | Nexos Admin';
$adminPage  = 'dashboard';
include __DIR__ . '/partials/layout_head.php';
?>

<style>
.dash-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.quick-links{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:24px}
.quick-link{display:flex;align-items:center;gap:8px;padding:10px 16px;background:var(--bg2);border:1px solid var(--border);border-radius:10px;font-size:13px;font-weight:500;color:var(--sub);transition:all .2s;font-family:var(--font-h)}
.quick-link:hover{border-color:rgba(21,101,255,.3);color:var(--blue2)}
.msg-row{display:flex;gap:12px;padding:14px 0;border-bottom:1px solid var(--border)}
.msg-row:last-child{border-bottom:none}
.msg-av{width:36px;height:36px;background:rgba(21,101,255,.12);border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:var(--font-h);font-size:12px;font-weight:700;color:var(--blue2);flex-shrink:0}
.msg-name{font-size:13px;font-weight:600;color:var(--text);font-family:var(--font-h)}
.msg-preview{font-size:12px;color:var(--sub);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px}
.msg-time{font-size:11px;color:rgba(15,23,42,.38);margin-left:auto;flex-shrink:0}
.unread-dot{width:6px;height:6px;background:var(--blue);border-radius:50%;flex-shrink:0;margin-top:6px}
@media(max-width:900px){.dash-grid{grid-template-columns:1fr}}
</style>

<!-- Quick stats -->
<div class="stat-grid">
  <div class="stat-card">
    <div class="stat-card-val"><?= $adminCounts['posts'] ?></div>
    <div class="stat-card-label">Published Posts</div>
    <div class="stat-card-delta">↑ Live on site</div>
  </div>
  <div class="stat-card">
    <div class="stat-card-val"><?= $adminCounts['drafts'] ?></div>
    <div class="stat-card-label">Draft Posts</div>
    <div class="stat-card-delta" style="color:var(--sub)">Not yet published</div>
  </div>
  <div class="stat-card">
    <div class="stat-card-val"><?= $adminCounts['unread'] ?></div>
    <div class="stat-card-label">Unread Messages</div>
    <?php if($adminCounts['unread']>0): ?><div class="stat-card-delta" style="color:#f59e0b">⚠ Needs attention</div><?php else: ?><div class="stat-card-delta">All caught up!</div><?php endif; ?>
  </div>
  <div class="stat-card">
    <div class="stat-card-val"><?= $adminCounts['total_messages'] ?></div>
    <div class="stat-card-label">Total Inquiries</div>
    <div class="stat-card-delta">All time</div>
  </div>
</div>

<!-- Quick Links -->
<div class="quick-links">
  <a href="/admin/post-new.php" class="quick-link"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M7 1v12M1 7h12" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>New Post</a>
  <a href="/admin/categories.php" class="quick-link"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M1 3h12M1 7h9M1 11h7" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>Categories</a>
  <a href="/admin/messages.php" class="quick-link"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M12 2H2a1 1 0 00-1 1v7a1 1 0 001 1h3l2 2 2-2h3a1 1 0 001-1V3a1 1 0 00-1-1Z" stroke="currentColor" stroke-width="1.3"/></svg>Messages<?php if($adminCounts['unread']>0): ?> (<?= $adminCounts['unread'] ?> new)<?php endif; ?></a>
  <a href="/" target="_blank" class="quick-link"><svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M7 1a6 6 0 100 12A6 6 0 007 1ZM1 7h12M7 1c-2 2-2 8 0 12M7 1c2 2 2 8 0 12" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>View Site</a>
</div>

<!-- Grid -->
<div class="dash-grid">
  <!-- Recent Posts -->
  <div class="table-card">
    <div class="table-head">
      <div class="table-head-title">Recent Posts</div>
      <a href="/admin/posts.php" class="btn-outline btn-sm">View All</a>
    </div>
    <?php foreach($recentPosts as $p): ?>
    <div style="display:flex;align-items:center;gap:12px;padding:12px 20px;border-bottom:1px solid rgba(15,23,42,.05)">
      <div style="flex:1;min-width:0">
        <div style="font-size:13px;font-weight:600;color:var(--text);font-family:var(--font-h);white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= h($p['title']) ?></div>
        <div style="font-size:11px;color:var(--sub);margin-top:2px"><?= date('M j, Y', strtotime($p['created_at'])) ?> · <?= $p['views'] ?> views</div>
      </div>
      <span class="badge badge-<?= $p['status'] ?>"><?= $p['status'] ?></span>
      <a href="/admin/post-edit.php?id=<?= $p['id'] ?>" class="btn-outline btn-sm" style="flex-shrink:0">Edit</a>
    </div>
    <?php endforeach; ?>
    <?php if(empty($recentPosts)): ?><div style="padding:24px;text-align:center;color:var(--sub);font-size:13px">No posts yet. <a href="/admin/post-new.php" style="color:var(--blue2)">Create your first post →</a></div><?php endif; ?>
  </div>

  <!-- Recent Messages -->
  <div class="table-card">
    <div class="table-head">
      <div class="table-head-title">Recent Messages</div>
      <a href="/admin/messages.php" class="btn-outline btn-sm">View All</a>
    </div>
    <div style="padding:0 20px">
    <?php foreach($recentMsgs as $msg): ?>
    <div class="msg-row">
      <?php if(!$msg['read_at']): ?><div class="unread-dot"></div><?php endif; ?>
      <div class="msg-av"><?= strtoupper(substr($msg['name'],0,1)) ?></div>
      <div style="flex:1;min-width:0">
        <div class="msg-name"><?= h($msg['name']) ?></div>
        <div class="msg-preview"><?= h($msg['message']) ?></div>
      </div>
      <div class="msg-time"><?= timeAgo($msg['created_at']) ?></div>
    </div>
    <?php endforeach; ?>
    <?php if(empty($recentMsgs)): ?><div style="padding:24px 0;text-align:center;color:var(--sub);font-size:13px">No messages yet.</div><?php endif; ?>
    </div>
  </div>
</div>

<!-- Top Posts -->
<?php if(!empty($topPosts)): ?>
<div class="table-card" style="margin-top:20px">
  <div class="table-head">
    <div class="table-head-title">Most Viewed Posts</div>
  </div>
  <table>
    <thead><tr><th>Title</th><th>Status</th><th>Views</th><th>Published</th><th>Action</th></tr></thead>
    <tbody>
    <?php foreach($topPosts as $p): ?>
    <tr>
      <td class="td-title"><?= h(mb_strimwidth($p['title'],0,50,'…')) ?></td>
      <td><span class="badge badge-<?= $p['status'] ?>"><?= $p['status'] ?></span></td>
      <td><?= number_format($p['views']) ?></td>
      <td><?= date('M j, Y', strtotime($p['created_at'])) ?></td>
      <td><a href="/admin/post-edit.php?id=<?= $p['id'] ?>" class="btn-outline btn-sm">Edit</a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php endif; ?>

<?php include __DIR__ . '/partials/layout_foot.php'; ?>
