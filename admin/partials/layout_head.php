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
<link rel="icon" type="image/x-icon" href="<?= site_img('favicon', '/assets/images/favicon.ico') ?>">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--blue:#1565FF;--blue2:#3B82F6;--bg:#f4f6fb;--bg2:#ffffff;--bg3:#eef1f7;--card:#ffffff;--sidebar:#ffffff;--border:rgba(15,23,42,.09);--text:#0f172a;--sub:rgba(15,23,42,.58);--green:#0e9f6e;--red:#e5484d;--font-h:'Inter',sans-serif;--font-b:'Inter',sans-serif;--spring:cubic-bezier(.34,1.56,.64,1)}
*{margin:0;padding:0;box-sizing:border-box}
body{background:var(--bg);color:var(--text);font-family:var(--font-b);display:flex;min-height:100vh;-webkit-font-smoothing:antialiased;overflow-x:hidden}
a{text-decoration:none;color:inherit}
button{border:none;cursor:pointer;font-family:inherit}
::-webkit-scrollbar{width:6px;height:6px}::-webkit-scrollbar-track{background:transparent}::-webkit-scrollbar-thumb{background:rgba(15,23,42,.18);border-radius:6px}

/* SIDEBAR */
.admin-sidebar{width:250px;background:var(--sidebar);border-right:1px solid var(--border);display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:110;transition:transform .35s var(--spring);overflow:hidden}
.admin-sidebar::before{content:'';position:absolute;top:0;left:0;right:0;height:200px;background:linear-gradient(180deg,rgba(21,101,255,.05),transparent);pointer-events:none;z-index:0}
.sidebar-logo{padding:24px 24px 20px;border-bottom:1px solid var(--border);position:relative;z-index:1}
.sidebar-logo a{display:flex;align-items:center;transition:transform .3s var(--spring)}
.sidebar-logo a:hover{transform:scale(1.04)}
.sidebar-logo img{height:34px;width:auto;object-fit:contain}
.sidebar-logo .badge{display:inline-flex;font-size:9px;font-weight:700;color:var(--blue2);background:rgba(21,101,255,.1);border-radius:100px;padding:3px 10px;letter-spacing:1px;text-transform:uppercase;margin-top:8px}
.sidebar-nav{flex:1;overflow-y:auto;padding:14px 12px;position:relative;z-index:1}
.nav-section{font-size:9px;font-weight:700;color:rgba(15,23,42,.4);letter-spacing:1.5px;text-transform:uppercase;padding:14px 12px 6px;font-family:var(--font-h)}
.nav-item{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;font-size:13px;font-weight:500;color:var(--sub);transition:all .25s var(--spring);margin-bottom:2px;position:relative;overflow:hidden}
.nav-item::before{content:'';position:absolute;left:0;top:0;bottom:0;width:0;background:linear-gradient(90deg,rgba(21,101,255,.14),transparent);border-radius:10px;transition:width .3s var(--spring)}
.nav-item:hover{color:var(--text);background:rgba(15,23,42,.045)}
.nav-item:hover::before{width:100%}
.nav-item.active{background:rgba(21,101,255,.08);color:var(--blue);font-weight:600;border:1px solid rgba(21,101,255,.15)}
.nav-item.active::before{width:100%;background:linear-gradient(90deg,rgba(21,101,255,.16),transparent)}
.nav-item svg{flex-shrink:0;opacity:.7;transition:all .25s}
.nav-item.active svg,.nav-item:hover svg{opacity:1;color:var(--blue2)}
.nav-count{margin-left:auto;background:rgba(21,101,255,.1);color:var(--blue);font-size:10px;font-weight:700;font-family:var(--font-h);padding:2px 7px;border-radius:100px;transition:all .25s}
.nav-item:hover .nav-count{background:rgba(21,101,255,.16)}
.sidebar-bottom{padding:16px 12px;border-top:1px solid var(--border);position:relative;z-index:1}
.admin-name{font-size:13px;font-weight:600;color:var(--text);font-family:var(--font-h)}
.admin-email-small{font-size:11px;color:var(--sub);margin-top:2px}
.logout-btn{display:flex;align-items:center;gap:8px;padding:8px 12px;border-radius:8px;font-size:12px;font-weight:600;color:var(--red);transition:all .25s var(--spring);margin-top:10px;background:rgba(229,72,77,.06);width:100%;font-family:var(--font-h)}
.logout-btn:hover{background:rgba(229,72,77,.12);color:var(--red);transform:translateX(2px)}

/* MAIN */
.admin-main{margin-left:250px;flex:1;display:flex;flex-direction:column;min-height:100vh;min-width:0}
.admin-topbar{background:rgba(255,255,255,.9);border-bottom:1px solid var(--border);padding:0 28px;height:68px;display:flex;align-items:center;justify-content:space-between;gap:16px;position:sticky;top:0;z-index:90;backdrop-filter:blur(16px);-webkit-backdrop-filter:blur(16px);box-shadow:0 1px 0 rgba(15,23,42,.02)}
.topbar-left{display:flex;align-items:center;gap:12px;min-width:0}
.topbar-title-wrap{min-width:0}
.topbar-title{font-family:var(--font-h);font-size:16px;font-weight:700;color:var(--text);line-height:1.25;letter-spacing:-.2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.topbar-title-small{font-family:var(--font-h);font-size:11px;font-weight:600;color:var(--blue2);letter-spacing:.3px;text-transform:uppercase;margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.topbar-actions{display:flex;align-items:center;gap:10px}
.tb-divider{width:1px;height:28px;background:var(--border);margin:0 2px}
.menu-btn{display:none;align-items:center;justify-content:center;width:40px;height:40px;border-radius:11px;background:var(--bg3);color:var(--text);flex-shrink:0;transition:all .2s}
.menu-btn:hover{background:rgba(21,101,255,.12);color:var(--blue)}
.tb-btn{display:inline-flex;align-items:center;gap:7px;height:38px;padding:0 16px;border-radius:10px;font-family:var(--font-h);font-size:13px;font-weight:600;transition:all .25s var(--spring);white-space:nowrap}
.tb-btn svg{flex-shrink:0}
.tb-btn-outline{background:var(--card);color:var(--text);border:1.5px solid var(--border)}
.tb-btn-outline:hover{border-color:var(--blue);color:var(--blue)}
.tb-btn-primary{background:var(--blue);color:#fff;border:1.5px solid var(--blue);box-shadow:0 3px 12px rgba(21,101,255,.25)}
.tb-btn-primary:hover{background:var(--blue2);border-color:var(--blue2);transform:translateY(-1px);box-shadow:0 6px 18px rgba(21,101,255,.3)}
.admin-content{padding:28px;flex:1;animation:adminFadeIn .5s ease both;max-width:1320px;width:100%}
@keyframes adminFadeIn{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}

/* CARDS */
.stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:28px}
.stat-card{background:var(--card);border:1px solid var(--border);border-radius:14px;padding:22px;transition:all .3s var(--spring);position:relative;overflow:hidden;box-shadow:0 1px 2px rgba(15,23,42,.03)}
.stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--blue),transparent);opacity:0;transition:opacity .3s}
.stat-card:hover{border-color:rgba(21,101,255,.25);transform:translateY(-2px);box-shadow:0 8px 28px rgba(21,101,255,.08)}
.stat-card:hover::before{opacity:1}
.stat-card-val{font-family:var(--font-h);font-size:30px;font-weight:800;color:var(--text);line-height:1}
.stat-card-label{font-size:12px;color:var(--sub);margin-top:6px}
.stat-card-delta{font-size:12px;color:var(--green);margin-top:10px;font-weight:600}

/* TABLE */
.table-card{background:var(--card);border:1px solid var(--border);border-radius:14px;overflow-x:auto;-webkit-overflow-scrolling:touch;transition:box-shadow .3s;box-shadow:0 1px 2px rgba(15,23,42,.03)}
.table-card:hover{box-shadow:0 4px 24px rgba(15,23,42,.05)}
.table-head{display:flex;justify-content:space-between;align-items:center;padding:20px 24px;border-bottom:1px solid var(--border)}
.table-head-title{font-family:var(--font-h);font-size:14px;font-weight:700;color:var(--text)}
table{width:100%;border-collapse:collapse;min-width:520px}
th{font-size:11px;font-weight:700;color:var(--sub);letter-spacing:.8px;text-transform:uppercase;font-family:var(--font-h);padding:12px 24px;text-align:left;border-bottom:1px solid var(--border);background:var(--bg3)}
td{padding:14px 24px;font-size:13.5px;color:var(--sub);border-bottom:1px solid rgba(15,23,42,.04);transition:background .2s;white-space:nowrap}
tr:last-child td{border-bottom:none}
tr{transition:all .2s}
tr:hover td{background:rgba(21,101,255,.03)}
.td-title{color:var(--text);font-weight:500;font-family:var(--font-h);font-size:14px}

/* BADGES */
.badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:100px;font-size:10px;font-weight:700;font-family:var(--font-h);letter-spacing:.5px}
.badge-published{background:rgba(14,159,110,.1);color:var(--green);border:1px solid rgba(14,159,110,.2)}
.badge-draft{background:rgba(15,23,42,.05);color:var(--sub);border:1px solid var(--border)}

/* FORMS */
.form-section{background:var(--card);border:1px solid var(--border);border-radius:14px;padding:28px;margin-bottom:20px;transition:box-shadow .3s;box-shadow:0 1px 2px rgba(15,23,42,.03)}
.form-section:hover{box-shadow:0 4px 24px rgba(15,23,42,.05)}
.form-section-title{font-family:var(--font-h);font-size:14px;font-weight:700;color:var(--text);margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--border)}
.form-group{margin-bottom:18px}
.form-group:last-child{margin-bottom:0}
label{display:block;font-size:12px;font-weight:600;color:var(--sub);margin-bottom:8px;font-family:var(--font-h);letter-spacing:.3px}
input[type=text],input[type=email],input[type=password],select,textarea{width:100%;padding:11px 14px;background:var(--bg3);border:1.5px solid var(--border);border-radius:8px;font-family:var(--font-b);font-size:14px;color:var(--text);outline:none;transition:all .25s var(--spring)}
input[type=text]:focus,input[type=email]:focus,input[type=password]:focus,select:focus,textarea:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(21,101,255,.12);background:var(--card)}
input::placeholder,textarea::placeholder{color:rgba(15,23,42,.32)}
select option{background:var(--card);color:var(--text)}
textarea{resize:vertical;line-height:1.65}
.form-hint{font-size:11.5px;color:var(--sub);margin-top:6px}

/* BUTTONS */
.btn-primary{display:inline-flex;align-items:center;gap:8px;background:var(--blue);color:#fff;padding:10px 20px;border-radius:8px;font-family:var(--font-h);font-size:13px;font-weight:600;transition:all .25s var(--spring);border:none;box-shadow:0 2px 12px rgba(21,101,255,.22)}
.btn-primary:hover{opacity:.9;color:#fff;transform:translateY(-1px);box-shadow:0 6px 24px rgba(21,101,255,.3)}
.btn-outline{display:inline-flex;align-items:center;gap:8px;background:var(--card);color:var(--text);padding:9px 18px;border-radius:8px;border:1.5px solid var(--border);font-family:var(--font-h);font-size:13px;font-weight:500;transition:all .25s var(--spring)}
.btn-outline:hover{border-color:var(--blue);color:var(--blue);transform:translateY(-1px)}
.btn-danger{display:inline-flex;align-items:center;gap:6px;background:rgba(229,72,77,.08);color:var(--red);padding:8px 14px;border-radius:8px;border:1px solid rgba(229,72,77,.2);font-family:var(--font-h);font-size:12px;font-weight:600;transition:all .25s var(--spring)}
.btn-danger:hover{background:rgba(229,72,77,.14);transform:translateY(-1px)}
.btn-sm{padding:6px 14px;font-size:12px}

/* FLASH */
.flash{padding:12px 18px;border-radius:10px;font-size:13px;font-weight:500;margin-bottom:20px;font-family:var(--font-h)}
.flash-success{background:rgba(14,159,110,.1);border:1px solid rgba(14,159,110,.25);color:var(--green)}
.flash-error{background:rgba(229,72,77,.08);border:1px solid rgba(229,72,77,.2);color:var(--red)}

/* RICH EDITOR */
.editor-toolbar{display:flex;flex-wrap:wrap;gap:4px;padding:10px;background:var(--bg3);border:1.5px solid var(--border);border-bottom:none;border-radius:8px 8px 0 0}
.editor-toolbar button{padding:5px 10px;background:transparent;color:var(--sub);border-radius:5px;font-size:12px;font-weight:600;font-family:var(--font-h);border:1px solid transparent;transition:all .2s}
.editor-toolbar button:hover{background:rgba(15,23,42,.06);color:var(--text);border-color:var(--border)}
#post-content-editor{width:100%;min-height:350px;padding:16px;background:var(--card);border:1.5px solid var(--border);border-top:none;border-radius:0 0 8px 8px;font-family:var(--font-b);font-size:14px;color:var(--text);outline:none;resize:vertical;line-height:1.75}

/* UTILITIES */
.admin-grid{display:grid;grid-template-columns:1fr 340px;gap:24px;max-width:1120px;align-items:start}
.two-col{display:grid;grid-template-columns:1fr 1fr;gap:16px}

/* OVERLAY */
.sidebar-overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,.45);backdrop-filter:blur(2px);z-index:100;opacity:0;transition:opacity .3s}

/* RESPONSIVE */
@media(max-width:900px){
  .admin-sidebar{transform:translateX(-100%);box-shadow:none}
  .admin-sidebar.open{transform:translateX(0);box-shadow:12px 0 40px rgba(15,23,42,.15)}
  .admin-main{margin-left:0}
  .menu-btn{display:inline-flex}
  .sidebar-overlay.show{display:block;opacity:1}
  .stat-grid{grid-template-columns:1fr 1fr}
  .admin-grid{grid-template-columns:1fr}
  .two-col{grid-template-columns:1fr}
  .admin-content{padding:20px}
  .admin-topbar{padding:0 16px}
  .tb-label{display:none}
  .tb-btn{padding:0 12px;width:40px;justify-content:center}
  .tb-divider{display:none}
}
@media(max-width:500px){
  .stat-grid{grid-template-columns:1fr}
  .topbar-title{font-size:14px}
  .admin-topbar{height:60px}
  .menu-btn{width:38px;height:38px}
  .admin-content{padding:16px}
  .table-head{padding:16px}
}
</style>
</head>
<body>

<!-- OVERLAY -->
<div class="sidebar-overlay" id="sidebar-overlay"></div>

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
    <div class="topbar-left">
      <button class="menu-btn" id="menu-btn" aria-label="Toggle Menu">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M3 5h12M3 9h12M3 13h12" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
      </button>
      <div class="topbar-title-wrap">
        <div class="topbar-title"><?= $adminTitle ?></div>
        <?php if(!empty($adminSubTitle)): ?><div class="topbar-title-small"><?= $adminSubTitle ?></div><?php endif; ?>
      </div>
    </div>
    <div class="topbar-actions">
      <a href="/" target="_blank" class="tb-btn tb-btn-outline">
        <svg width="15" height="15" viewBox="0 0 16 16" fill="none"><path d="M8 13L3 8l5-5M4.5 8h8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <span class="tb-label">View Site</span>
      </a>
      <span class="tb-divider"></span>
      <a href="/admin/post-new.php" class="tb-btn tb-btn-primary">
        <svg width="15" height="15" viewBox="0 0 16 16" fill="none"><path d="M8 2.5v11M2.5 8h11" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
        <span class="tb-label">New Post</span>
      </a>
    </div>
  </div>
  <div class="admin-content">
    <?php $f=getFlash(); if($f): ?><div class="flash flash-<?= $f['type'] ?>"><?= h($f['msg']) ?></div><?php endif; ?>