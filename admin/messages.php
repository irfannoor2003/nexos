<?php
require_once '../includes/helpers.php';
require_once '../includes/db.php';
requireLogin();

$db = getDB();

// Mark as read
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf($_POST['csrf'] ?? '');
    $action = $_POST['action'] ?? '';
    $id     = (int)($_POST['id'] ?? 0);

    if ($action === 'mark_read' && $id) {
        $db->prepare("UPDATE messages SET read_at=NOW() WHERE id=?")->execute([$id]);
    }
    if ($action === 'mark_unread' && $id) {
        $db->prepare("UPDATE messages SET read_at=NULL WHERE id=?")->execute([$id]);
    }
    if ($action === 'delete' && $id) {
        $db->prepare("DELETE FROM messages WHERE id=?")->execute([$id]);
        setFlash('success', 'Message deleted.');
    }
    if ($action === 'mark_all_read') {
        $db->exec("UPDATE messages SET read_at=NOW() WHERE read_at IS NULL");
        setFlash('success', 'All messages marked as read.');
    }
    header('Location: messages.php' . ($id && $action!=='delete' ? "?view=$id" : '')); exit;
}

// View single message (auto mark read)
$view = null;
if (!empty($_GET['view'])) {
    $mid = (int)$_GET['view'];
    $view = $db->query("SELECT * FROM messages WHERE id=$mid")->fetch();
    if ($view && !$view['read_at']) {
        $db->prepare("UPDATE messages SET read_at=NOW() WHERE id=?")->execute([$mid]);
        $view['read_at'] = date('Y-m-d H:i:s');
    }
}

// Filter
$filter = $_GET['filter'] ?? 'all';
$where  = $filter === 'unread' ? "WHERE read_at IS NULL" : ($filter === 'read' ? "WHERE read_at IS NOT NULL" : "");
$messages = $db->query("SELECT * FROM messages $where ORDER BY created_at DESC")->fetchAll();

$counts = [
    'all'    => $db->query("SELECT COUNT(*) FROM messages")->fetchColumn(),
    'unread' => $db->query("SELECT COUNT(*) FROM messages WHERE read_at IS NULL")->fetchColumn(),
    'read'   => $db->query("SELECT COUNT(*) FROM messages WHERE read_at IS NOT NULL")->fetchColumn(),
];

$adminCounts = [
    'posts'  => $db->query("SELECT COUNT(*) FROM posts WHERE status='published'")->fetchColumn(),
    'unread' => $counts['unread'],
];
$adminPage  = 'messages';
$adminTitle = 'Messages';
require 'partials/layout_head.php';
?>

<style>
.msg-layout{display:grid;grid-template-columns:360px 1fr;gap:0;background:var(--card);border:1px solid var(--border);border-radius:16px;overflow:hidden;min-height:500px}
.msg-list{border-right:1px solid var(--border);overflow-y:auto;max-height:75vh}
.msg-item{display:block;padding:18px 20px;border-bottom:1px solid var(--border);transition:background .2s;cursor:pointer;position:relative}
.msg-item:hover,.msg-item.active{background:rgba(21,101,255,.06)}
.msg-item.unread .msg-item-name::before{content:'';display:inline-block;width:7px;height:7px;background:var(--blue);border-radius:50%;margin-right:7px;vertical-align:middle}
.msg-item-name{font-family:var(--font-h);font-size:13px;font-weight:600;color:var(--text)}
.msg-item-sub{font-size:11.5px;color:var(--sub);margin-top:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.msg-item-time{font-size:10.5px;color:rgba(15,23,42,.38);margin-top:4px}
.msg-detail{padding:32px;flex:1}
.msg-detail-empty{display:flex;align-items:center;justify-content:center;height:100%;color:var(--sub);font-size:14px}
.filter-tabs{display:flex;gap:6px;margin-bottom:20px}
.filter-tab{padding:7px 16px;border-radius:8px;font-family:var(--font-h);font-size:12px;font-weight:600;color:var(--sub);background:var(--card);border:1px solid var(--border);transition:all .2s}
.filter-tab.active,.filter-tab:hover{background:rgba(21,101,255,.12);color:var(--blue2);border-color:rgba(21,101,255,.2)}
@media(max-width:900px){.msg-layout{grid-template-columns:1fr}.msg-list{max-height:40vh;border-right:none;border-bottom:1px solid var(--border)}.msg-detail{padding:20px}}
</style>

<div style="margin-bottom:20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px">
  <div class="filter-tabs">
    <a href="?filter=all"    class="filter-tab <?= $filter==='all'    ? 'active':'' ?>">All (<?= $counts['all'] ?>)</a>
    <a href="?filter=unread" class="filter-tab <?= $filter==='unread' ? 'active':'' ?>">Unread (<?= $counts['unread'] ?>)</a>
    <a href="?filter=read"   class="filter-tab <?= $filter==='read'   ? 'active':'' ?>">Read (<?= $counts['read'] ?>)</a>
  </div>
  <?php if ($counts['unread'] > 0): ?>
    <form method="POST">
      <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
      <input type="hidden" name="action" value="mark_all_read">
      <button class="btn-outline btn-sm">✓ Mark All Read</button>
    </form>
  <?php endif; ?>
</div>

<div class="msg-layout">
  <!-- List -->
  <div class="msg-list">
    <?php if (empty($messages)): ?>
      <div style="padding:40px;text-align:center;color:var(--sub);font-size:13px">No messages.</div>
    <?php else: ?>
      <?php foreach ($messages as $m): ?>
        <a href="?view=<?= $m['id'] ?>&filter=<?= $filter ?>"
           class="msg-item <?= !$m['read_at'] ? 'unread' : '' ?> <?= (isset($view) && $view['id']==$m['id']) ? 'active' : '' ?>">
          <div class="msg-item-name"><?= h($m['name']) ?></div>
          <div class="msg-item-sub"><?= h($m['subject'] ?: substr($m['message'], 0, 60)) ?></div>
          <div class="msg-item-time"><?= timeAgo($m['created_at']) ?></div>
        </a>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <!-- Detail -->
  <div class="msg-detail">
    <?php if ($view): ?>
      <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px;gap:12px;flex-wrap:wrap">
        <div>
          <div style="font-family:var(--font-h);font-size:18px;font-weight:700;color:var(--text);margin-bottom:4px"><?= h($view['name']) ?></div>
          <div style="font-size:13px;color:var(--sub)"><?= h($view['email']) ?><?= $view['phone'] ? ' · ' . h($view['phone']) : '' ?></div>
          <div style="font-size:11px;color:rgba(15,23,42,.42);margin-top:4px"><?= date('D, M j Y · g:i A', strtotime($view['created_at'])) ?></div>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
          <a href="mailto:<?= h($view['email']) ?>" class="btn-primary btn-sm">Reply via Email</a>
          <?php if ($view['read_at']): ?>
            <form method="POST" style="display:inline">
              <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
              <input type="hidden" name="action" value="mark_unread">
              <input type="hidden" name="id" value="<?= $view['id'] ?>">
              <button class="btn-outline btn-sm">Mark Unread</button>
            </form>
          <?php endif; ?>
          <form method="POST" style="display:inline" onsubmit="return confirm('Delete this message?')">
            <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= $view['id'] ?>">
            <button class="btn-danger btn-sm">Delete</button>
          </form>
        </div>
      </div>

      <?php if ($view['subject']): ?>
        <div style="background:rgba(21,101,255,.06);border:1px solid rgba(21,101,255,.12);border-radius:8px;padding:10px 14px;margin-bottom:20px">
          <span style="font-size:11px;font-weight:700;color:var(--blue);font-family:var(--font-h);letter-spacing:.5px">SUBJECT</span>
          <div style="font-size:14px;color:var(--text);margin-top:4px;font-family:var(--font-h);font-weight:600"><?= h($view['subject']) ?></div>
        </div>
      <?php endif; ?>

      <div style="background:var(--bg3);border:1px solid var(--border);border-radius:12px;padding:22px">
        <div style="font-size:14px;color:rgba(15,23,42,.85);line-height:1.85;white-space:pre-wrap"><?= h($view['message']) ?></div>
      </div>

    <?php else: ?>
      <div class="msg-detail-empty">
        <div style="text-align:center">
          <div style="font-size:32px;margin-bottom:12px">✉️</div>
          <div>Select a message to read it</div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php require 'partials/layout_foot.php'; ?>
