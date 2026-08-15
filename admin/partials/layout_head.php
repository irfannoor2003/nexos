<?php
// admin/partials/layout_head.php
$adminTitle = $adminTitle ?? 'Admin | Nexos';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= h($adminTitle) ?></title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--blue:#1565FF;--blue2:#4D8DFF;--bg:#060810;--bg2:#0c0f1a;--bg3:#111628;--card:#0e1220;--sidebar:#080b14;--border:rgba(255,255,255,.07);--text:#f0f2ff;--sub:rgba(200,210,240,.55);--green:#10b981;--red:#ff5555;--font-h:'Inter',sans-serif;--font-b:'Inter',sans-serif;--spring:cubic-bezier(.34,1.56,.64,1)}
*{margin:0;padding:0;box-sizing:border-box}
body{background:var(--bg);color:var(--text);font-family:var(--font-b);display:flex;min-height:100vh;-webkit-font-smoothing:antialiased}
a{text-decoration:none;color:inherit}
button{border:none;cursor:pointer;font-family:inherit}
::-webkit-scrollbar{width:4px}::-webkit-scrollbar-track{background:var(--bg)}::-webkit-scrollbar-thumb{background:var(--sub);border-radius:4px}

/* SIDEBAR */
.admin-sidebar{width:240px;background:var(--sidebar);border-right:1px solid var(--border);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:100;transition:transform .3s}
.sidebar-logo{padding:28px 24px 24px;border-bottom:1px solid var(--border)}
.sidebar-logo a{display:flex;align-items:center}
.sidebar-logo img{height:36px;width:auto;object-fit:contain}
.sidebar-logo .badge{font-size:9px;font-weight:700;color:var(--sub);letter-spacing:1px;text-transform:uppercase;margin-top:4px;display:block}
.sidebar-nav{flex:1;overflow-y:auto;padding:16px 12px}
.nav-section{font-size:9px;font-weight:700;color:rgba(200,210,240,.25);letter-spacing:1.5px;text-transform:uppercase;padding:12px 12px 6px;font-family:var(--font-h)}
.nav-item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;font-size:13px;font-weight:500;color:var(--sub);transition:all .2s;margin-bottom:2px}
.nav-item:hover{background:rgba(255,255,255,.04);color:var(--text)}
.nav-item.active{background:rgba(255,255,255,.06);color:var(--text);font-weight:600}
.nav-item svg{flex-shrink:0;opacity:.7}
.nav-item.active svg,.nav-item:hover svg{opacity:1}
.nav-count{margin-left:auto;background:rgba(255,255,255,.08);color:var(--sub);font-size:10px;font-weight:700;font-family:var(--font-h);padding:2px 7px;border-radius:100px}
.sidebar-bottom{padding:16px 12px;border-top:1px solid var(--border)}
.admin-name{font-size:13px;font-weight:600;color:var(--text);font-family:var(--font-h)}
.admin-email-small{font-size:11px;color:var(--sub);margin-top:2px}
.logout-btn{display:flex;align-items:center;gap:8px;padding:8px 12px;border-radius:8px;font-size:12px;font-weight:600;color:rgba(255,80,80,.7);transition:all .2s;margin-top:10px;background:none;width:100%;font-family:var(--font-h)}
.logout-btn:hover{background:rgba(255,80,80,.08);color:#ff5555}

/* MAIN */
.admin-main{margin-left:240px;flex:1;display:flex;flex-direction:column;min-height:100vh}
.admin-topbar{background:var(--bg2);border-bottom:1px solid var(--border);padding:0 32px;height:64px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50}
.topbar-title{font-family:var(--font-h);font-size:16px;font-weight:700;color:var(--text)}
.topbar-actions{display:flex;align-items:center;gap:10px}
.admin-content{padding:32px;flex:1}

/* CARDS */
.stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:32px}
.stat-card{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:24px}
.stat-card-val{font-family:var(--font-h);font-size:30px;font-weight:800;color:var(--text);line-height:1}
.stat-card-label{font-size:12px;color:var(--sub);margin-top:6px}
.stat-card-delta{font-size:12px;color:var(--green);margin-top:10px;font-weight:600}

/* TABLE */
.table-card{background:var(--card);border:1px solid var(--border);border-radius:16px;overflow:hidden}
.table-head{display:flex;justify-content:space-between;align-items:center;padding:20px 24px;border-bottom:1px solid var(--border)}
.table-head-title{font-family:var(--font-h);font-size:14px;font-weight:700;color:var(--text)}
table{width:100%;border-collapse:collapse}
th{font-size:11px;font-weight:700;color:var(--sub);letter-spacing:.8px;text-transform:uppercase;font-family:var(--font-h);padding:12px 24px;text-align:left;border-bottom:1px solid var(--border);background:var(--bg3)}
td{padding:14px 24px;font-size:13.5px;color:var(--sub);border-bottom:1px solid rgba(255,255,255,.03)}
tr:last-child td{border-bottom:none}
tr:hover td{background:rgba(255,255,255,.015)}
.td-title{color:var(--text);font-weight:500;font-family:var(--font-h);font-size:14px}

/* BADGES */
.badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:100px;font-size:10px;font-weight:700;font-family:var(--font-h);letter-spacing:.5px}
.badge-published{background:rgba(16,185,129,.1);color:#10b981;border:1px solid rgba(16,185,129,.2)}
.badge-draft{background:rgba(200,210,240,.06);color:var(--sub);border:1px solid var(--border)}

/* FORMS */
.form-section{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:28px;margin-bottom:20px}
.form-section-title{font-family:var(--font-h);font-size:14px;font-weight:700;color:var(--text);margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--border)}
.form-group{margin-bottom:18px}
.form-group:last-child{margin-bottom:0}
label{display:block;font-size:12px;font-weight:600;color:var(--sub);margin-bottom:8px;font-family:var(--font-h);letter-spacing:.3px}
input[type=text],input[type=email],input[type=password],select,textarea{width:100%;padding:11px 14px;background:var(--bg3);border:1.5px solid var(--border);border-radius:8px;font-family:var(--font-b);font-size:14px;color:var(--text);outline:none;transition:border-color .25s}
input[type=text]:focus,input[type=email]:focus,input[type=password]:focus,select:focus,textarea:focus{border-color:var(--text)}
input::placeholder,textarea::placeholder{color:rgba(200,210,240,.2)}
select option{background:var(--bg3);color:var(--text)}
textarea{resize:vertical;line-height:1.65}
.form-hint{font-size:11.5px;color:var(--sub);margin-top:6px}

/* BUTTONS */
.btn-primary{display:inline-flex;align-items:center;gap:8px;background:var(--blue);color:#fff;padding:10px 20px;border-radius:8px;font-family:var(--font-h);font-size:13px;font-weight:600;transition:opacity .2s,transform .2s var(--spring);border:none}
.btn-primary:hover{opacity:.85;color:#fff}
.btn-outline{display:inline-flex;align-items:center;gap:8px;background:transparent;color:var(--sub);padding:9px 18px;border-radius:8px;border:1.5px solid var(--border);font-family:var(--font-h);font-size:13px;font-weight:500;transition:all .2s}
.btn-outline:hover{border-color:var(--text);color:var(--text)}
.btn-danger{display:inline-flex;align-items:center;gap:6px;background:rgba(255,80,80,.08);color:#ff5555;padding:8px 14px;border-radius:8px;border:1px solid rgba(255,80,80,.2);font-family:var(--font-h);font-size:12px;font-weight:600;transition:all .2s}
.btn-danger:hover{background:rgba(255,80,80,.15)}
.btn-sm{padding:6px 14px;font-size:12px}

/* FLASH */
.flash{padding:12px 18px;border-radius:10px;font-size:13px;font-weight:500;margin-bottom:20px;font-family:var(--font-h)}
.flash-success{background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.25);color:#10b981}
.flash-error{background:rgba(255,80,80,.08);border:1px solid rgba(255,80,80,.2);color:#ff5555}

/* RICH EDITOR */
.editor-toolbar{display:flex;flex-wrap:wrap;gap:4px;padding:10px;background:var(--bg3);border:1.5px solid var(--border);border-bottom:none;border-radius:8px 8px 0 0}
.editor-toolbar button{padding:5px 10px;background:transparent;color:var(--sub);border-radius:5px;font-size:12px;font-weight:600;font-family:var(--font-h);border:1px solid transparent;transition:all .2s}
.editor-toolbar button:hover{background:rgba(255,255,255,.06);color:var(--text);border-color:var(--border)}
#post-content-editor{width:100%;min-height:350px;padding:16px;background:var(--bg3);border:1.5px solid var(--border);border-top:none;border-radius:0 0 8px 8px;font-family:var(--font-b);font-size:14px;color:var(--text);outline:none;resize:vertical;line-height:1.75}

/* RESPONSIVE */
@media(max-width:900px){.admin-sidebar{transform:translateX(-100%)}.admin-sidebar.open{transform:translateX(0)}.admin-main{margin-left:0}.stat-grid{grid-template-columns:1fr 1fr}}
@media(max-width:500px){.stat-grid{grid-template-columns:1fr}}
</style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="admin-sidebar" id="sidebar">
  <div class="sidebar-logo">
    <a href="/admin/index.php"><img src="<?= site_img('logo', '/assets/images/logo.png') ?>" alt="Nexos"></a>
    <span class="badge">Admin Panel</span>
  </div>
  <nav class="sidebar-nav">
    <div class="nav-section">Main</div>
    <a href="/admin/index.php" class="nav-item <?= ($adminPage??'')==='dashboard' ? 'active' : '' ?>">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="1" y="1" width="6" height="6" rx="1.5" stroke="currentColor" stroke-width="1.3"/><rect x="9" y="1" width="6" height="6" rx="1.5" stroke="currentColor" stroke-width="1.3"/><rect x="1" y="9" width="6" height="6" rx="1.5" stroke="currentColor" stroke-width="1.3"/><rect x="9" y="9" width="6" height="6" rx="1.5" stroke="currentColor" stroke-width="1.3"/></svg>
      Dashboard
    </a>

    <div class="nav-section">Blog</div>
    <a href="/admin/posts.php" class="nav-item <?= ($adminPage??'')==='posts' ? 'active' : '' ?>">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2 4h12M2 8h8M2 12h10" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
      All Posts
      <?php if(!empty($adminCounts['posts'])): ?><span class="nav-count"><?= $adminCounts['posts'] ?></span><?php endif; ?>
    </a>
    <a href="/admin/post-new.php" class="nav-item <?= ($adminPage??'')==='post-new' ? 'active' : '' ?>">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 2v12M2 8h12" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
      New Post
    </a>
    <a href="/admin/categories.php" class="nav-item <?= ($adminPage??'')==='categories' ? 'active' : '' ?>">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2 4h12v2H2zM2 9h9v2H2zM2 14h6v2H2z" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
      Categories
    </a>

    <div class="nav-section">CRM</div>
    <a href="/admin/messages.php" class="nav-item <?= ($adminPage??'')==='messages' ? 'active' : '' ?>">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M14 2H2a1 1 0 00-1 1v8a1 1 0 001 1h4l2 2 2-2h4a1 1 0 001-1V3a1 1 0 00-1-1Z" stroke="currentColor" stroke-width="1.3"/></svg>
      Messages
      <?php if(!empty($adminCounts['unread'])): ?><span class="nav-count"><?= $adminCounts['unread'] ?></span><?php endif; ?>
    </a>

    <div class="nav-section">Appearance</div>
    <a href="/admin/images.php" class="nav-item <?= ($adminPage??'')==='images' ? 'active' : '' ?>">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="2" y="2" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.3"/><circle cx="6" cy="6" r="1.5" stroke="currentColor" stroke-width="1.3"/><path d="M2 11l3-3 2 2 3-3 4 4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
      Images
    </a>
    <div class="nav-section">Settings</div>
    <a href="/admin/settings.php" class="nav-item <?= ($adminPage??'')==='settings' ? 'active' : '' ?>">
      <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="2.5" stroke="currentColor" stroke-width="1.3"/><path d="M8 1v2M8 13v2M1 8h2M13 8h2M3.05 3.05l1.42 1.42M11.54 11.54l1.41 1.41M3.05 12.95l1.42-1.42M11.54 4.46l1.41-1.41" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
      Settings
    </a>
  </nav>
  <div class="sidebar-bottom">
    <div class="admin-name"><?= h($_SESSION['admin_name'] ?? 'Admin') ?></div>
    <div class="admin-email-small">Administrator</div>
    <a href="/admin/logout.php" class="logout-btn">
      <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5 2H2a1 1 0 00-1 1v8a1 1 0 001 1h3M9 10l3-3-3-3M13 7H5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
      Sign Out
    </a>
  </div>
</aside>

<!-- MAIN -->
<main class="admin-main">
  <div class="admin-topbar">
    <div class="topbar-title"><?= $adminTitle ?></div>
    <div class="topbar-actions">
      <a href="/" target="_blank" class="btn-outline btn-sm">← View Site</a>
      <a href="/admin/post-new.php" class="btn-primary btn-sm">+ New Post</a>
    </div>
  </div>
  <div class="admin-content">
    <?php $f=getFlash(); if($f): ?><div class="flash flash-<?= $f['type'] ?>"><?= h($f['msg']) ?></div><?php endif; ?>
