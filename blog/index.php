<?php
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/db.php';

$slug = basename($_SERVER['REQUEST_URI']);
$slug = preg_replace('/[^a-z0-9\-]/', '', strtolower($slug));

$db   = getDB();
$stmt = $db->prepare("SELECT p.*, c.name as cat_name, c.slug as cat_slug, a.name as author_name FROM posts p LEFT JOIN categories c ON p.category_id=c.id LEFT JOIN admins a ON p.admin_id=a.id WHERE p.slug=? AND p.status='published' LIMIT 1");
$stmt->execute([$slug]);
$post = $stmt->fetch();

if (!$post) {
    http_response_code(404);
    $pageTitle  = '404 Not Found | Nexos';
    $activePage = 'blog';
    include __DIR__ . '/../includes/header.php';
    echo '<section class="sec" style="text-align:center;min-height:60vh;display:flex;align-items:center;justify-content:center"><div><h1 class="sec-h">Post Not <span class="em">Found</span></h1><p class="sec-sub" style="margin:0 auto">The article you\'re looking for doesn\'t exist or has been removed.</p><a href="/blog.php" class="btn-primary" style="margin-top:32px;display:inline-flex">← Back to Blog</a></div></section>';
    include __DIR__ . '/../includes/footer.php';
    exit;
}

// Increment views
$db->prepare("UPDATE posts SET views=views+1 WHERE id=?")->execute([$post['id']]);

// Related posts
$related = $db->prepare("SELECT p.*, c.name as cat_name FROM posts p LEFT JOIN categories c ON p.category_id=c.id WHERE p.status='published' AND p.id!=? AND p.category_id=? ORDER BY RAND() LIMIT 3");
$related->execute([$post['id'], $post['category_id']]);
$related = $related->fetchAll();
if(count($related) < 3) {
    $more = $db->prepare("SELECT p.*, c.name as cat_name FROM posts p LEFT JOIN categories c ON p.category_id=c.id WHERE p.status='published' AND p.id!=? ORDER BY RAND() LIMIT 3");
    $more->execute([$post['id']]);
    $related = $more->fetchAll();
}

$pageTitle  = h($post['title']) . ' | Nexos Blog';
$activePage = 'blog';
include __DIR__ . '/../includes/header.php';
?>
<style>
.post-hero{padding:160px 60px 80px;background:var(--bg);position:relative;overflow:hidden}
.post-hero-bg{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.02) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.02) 1px,transparent 1px);background-size:80px 80px;mask-image:radial-gradient(ellipse 80% 80% at 50% 40%,#000 30%,transparent 100%)}
.post-hero-glow{position:absolute;width:700px;height:700px;background:radial-gradient(circle,rgba(255,255,255,.02) 0%,transparent 70%);top:-250px;right:-150px}
.post-layout{display:grid;grid-template-columns:1fr 320px;gap:60px;align-items:start}
.post-body{max-width:none}
.post-cover{width:100%;border-radius:20px;overflow:hidden;margin-bottom:48px;background:var(--bg3);height:420px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border)}
.post-cover img{width:100%;height:100%;object-fit:cover}
.post-content{font-size:16px;color:rgba(200,195,220,.8);line-height:1.9}
.post-content h2{font-family:var(--font-h);font-size:28px;font-weight:700;color:var(--text);letter-spacing:-.5px;margin:48px 0 16px}
.post-content h3{font-family:var(--font-h);font-size:22px;font-weight:700;color:var(--text);margin:36px 0 12px}
.post-content p{margin-bottom:20px}
.post-content a{color:var(--text);text-decoration:underline}
.post-content ul,.post-content ol{margin:0 0 20px 24px}
.post-content li{margin-bottom:8px;line-height:1.7}
.post-content blockquote{border-left:3px solid var(--border);padding:20px 24px;background:rgba(255,255,255,.02);border-radius:0 14px 14px 0;margin:32px 0;font-style:italic;color:rgba(200,195,220,.7)}
.post-content strong{color:var(--text);font-weight:600}
.post-content code{background:rgba(255,255,255,.04);border:1px solid var(--border);padding:2px 8px;border-radius:6px;font-size:13px;font-family:monospace;color:var(--text)}
.post-content pre{background:var(--bg3);border:1px solid var(--border);border-radius:12px;padding:24px;overflow-x:auto;margin:24px 0}
.post-content pre code{background:none;border:none;padding:0;font-size:13px;color:rgba(200,195,220,.8)}
.post-meta-bar{display:flex;align-items:center;gap:20px;flex-wrap:wrap;padding:24px 0;border-top:1px solid var(--border);border-bottom:1px solid var(--border);margin-bottom:40px}
.post-meta-bar .meta-tag{font-family:var(--font-b);font-size:10px;font-weight:700;color:var(--sub);background:rgba(255,255,255,.03);border:1px solid var(--border);padding:4px 12px;border-radius:100px;letter-spacing:.8px;text-transform:uppercase}
.post-meta-bar .meta-date{font-size:12px;color:var(--sub)}
.post-meta-bar .meta-views{font-size:12px;color:var(--sub)}
.post-meta-bar .meta-author{font-size:12px;color:var(--sub)}
/* Sidebar */
.sidebar{position:sticky;top:100px;display:flex;flex-direction:column;gap:20px}
.sidebar-card{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:24px}
.sidebar-title{font-family:var(--font-h);font-size:12px;font-weight:700;color:var(--text);letter-spacing:.8px;text-transform:uppercase;margin-bottom:18px}
.sidebar-post{display:flex;gap:12px;padding:12px 0;border-bottom:1px solid var(--border);text-decoration:none;transition:opacity .2s}
.sidebar-post:last-child{border-bottom:none;padding-bottom:0}
.sidebar-post:hover{opacity:.75}
.sidebar-post-img{width:56px;height:44px;background:var(--bg3);border-radius:8px;flex-shrink:0;overflow:hidden;display:flex;align-items:center;justify-content:center}
.sidebar-post-img img{width:100%;height:100%;object-fit:cover}
.sidebar-post-title{font-size:12.5px;font-weight:600;color:var(--text);line-height:1.35;font-family:var(--font-b)}
.sidebar-post-date{font-size:11px;color:var(--sub);margin-top:4px}
.share-btns{display:flex;gap:8px;flex-wrap:wrap}
.share-btn{flex:1;min-width:0;display:flex;align-items:center;justify-content:center;gap:6px;padding:9px 12px;border-radius:8px;border:1px solid var(--border);font-size:12px;font-weight:600;font-family:var(--font-h);color:var(--sub);transition:all .25s;cursor:pointer;background:transparent;text-decoration:none}
.share-btn:hover{border-color:var(--text);color:var(--text);background:rgba(255,255,255,.04)}
/* Related */
.related-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:48px}
.rel-card{background:var(--card);border:1px solid var(--border);border-radius:16px;overflow:hidden;transition:border-color .3s,transform .3s var(--spring)}
.rel-card:hover{border-color:var(--border);box-shadow:0 4px 16px rgba(0,0,0,.15)}
.rel-img{height:160px;background:var(--bg3);display:flex;align-items:center;justify-content:center;overflow:hidden}
.rel-img img{width:100%;height:100%;object-fit:cover}
.rel-body{padding:20px}
.rel-cat{font-size:9px;font-weight:700;color:var(--sub);font-family:var(--font-b);letter-spacing:1px;text-transform:uppercase;margin-bottom:6px}
.rel-title{font-size:14px;font-weight:700;color:var(--text);font-family:var(--font-h);line-height:1.3}
@media(max-width:1100px){.post-layout{grid-template-columns:1fr}.sidebar{position:static}.related-grid{grid-template-columns:1fr 1fr}}
@media(max-width:640px){.post-hero{padding:130px 28px 60px}.related-grid{grid-template-columns:1fr}}
</style>

<!-- POST HERO -->
<section class="post-hero">
  <div class="post-hero-bg"></div>
  <div class="post-hero-glow"></div>
  <div style="position:relative;z-index:2;max-width:800px">
    <div class="page-breadcrumb" style="margin-bottom:24px">
      <a href="/">Home</a><span>/</span>
      <a href="/blog.php">Blog</a><span>/</span>
      <?php if($post['cat_name']): ?>
      <a href="/blog.php?category=<?= h($post['cat_slug']) ?>"><?= h($post['cat_name']) ?></a><span>/</span>
      <?php endif; ?>
      <span style="color:var(--text)"><?= mb_strimwidth(h($post['title']), 0, 40, '…') ?></span>
    </div>
    <?php if($post['cat_name']): ?>
    <div class="sec-label" style="margin-bottom:20px;opacity:0;animation:fadeUp .6s .1s var(--ease) forwards"><?= h($post['cat_name']) ?></div>
    <?php endif; ?>
    <h1 style="font-family:var(--font-h);font-weight:800;font-size:clamp(30px,4.5vw,56px);line-height:1.1;letter-spacing:-2px;color:var(--text);opacity:0;animation:fadeUp .9s .2s var(--ease) forwards"><?= h($post['title']) ?></h1>
    <?php if($post['excerpt']): ?>
    <p style="font-size:16px;color:var(--sub);line-height:1.8;max-width:640px;margin-top:20px;opacity:0;animation:fadeUp .9s .35s var(--ease) forwards"><?= h($post['excerpt']) ?></p>
    <?php endif; ?>
  </div>
</section>

<!-- POST CONTENT -->
<section class="sec" style="background:var(--bg);padding-top:60px">
  <div class="post-layout">

    <!-- Main -->
    <article class="post-body">
      <div class="post-meta-bar">
        <?php if($post['cat_name']): ?><span class="meta-tag"><?= h($post['cat_name']) ?></span><?php endif; ?>
        <span class="meta-date"><?= date('F j, Y', strtotime($post['created_at'])) ?></span>
        <span class="meta-views"><?= number_format($post['views']) ?> views</span>
        <?php if($post['author_name']): ?><span class="meta-author">By <?= h($post['author_name']) ?></span><?php endif; ?>
      </div>

      <?php if($post['cover_image']): ?>
      <div class="post-cover"><img src="/uploads/blog/<?= h($post['cover_image']) ?>" alt="<?= h($post['title']) ?>"></div>
      <?php endif; ?>

      <div class="post-content">
        <?= $post['content'] // HTML content — admin is trusted ?>
      </div>

      <div style="margin-top:60px;padding:32px;background:var(--bg2);border:1px solid var(--border);border-radius:20px;text-align:center">
        <div style="font-family:var(--font-h);font-size:18px;font-weight:700;color:var(--text);margin-bottom:10px">Ready to Grow Your Business?</div>
        <p style="font-size:14px;color:var(--sub);margin-bottom:24px">Let's have an honest conversation about scaling your digital presence.</p>
        <a href="/contact.php" class="btn-primary">Get a Free Consultation →</a>
      </div>
    </article>

    <!-- Sidebar -->
    <aside class="sidebar">
      <!-- Share -->
      <div class="sidebar-card">
        <div class="sidebar-title">Share This Post</div>
        <div class="share-btns">
          <a href="https://twitter.com/intent/tweet?url=<?= urlencode('https://nexosdigital.com/blog/'.$post['slug']) ?>&text=<?= urlencode($post['title']) ?>" target="_blank" rel="noopener" class="share-btn">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M13 2s-1 .5-1.7.7A2.5 2.5 0 007.5 5C5 5 3 4 1.5 2c0 0-.5 2 1 3-.4 0-1-.2-1-.2 0 1.5 1 2.5 2.5 3-.5.1-1 0-1 0 .4 1.2 1.5 2 3 2C5 11 1 12 1 12c1.3.8 3 1.3 5 1.3 5.5 0 8.5-4.5 8.5-8.5V4.3c.6-.4 1-1 1.3-1.7L13 2Z" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
            X
          </a>
          <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode('https://nexosdigital.com/blog/'.$post['slug']) ?>" target="_blank" rel="noopener" class="share-btn">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="1" width="12" height="12" rx="2" stroke="currentColor" stroke-width="1.3"/><path d="M4 6v4M4 4.5v.01M6 10V8a2 2 0 014 0v2M6 6v4" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
            LinkedIn
          </a>
          <button onclick="navigator.clipboard&&navigator.clipboard.writeText(window.location.href).then(()=>{this.textContent='Copied!';setTimeout(()=>this.textContent='Copy Link',2000)})" class="share-btn">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M5.5 8.5a3.5 3.5 0 005 0l2-2a3.5 3.5 0 00-5-5L6.5 2.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/><path d="M8.5 5.5a3.5 3.5 0 00-5 0l-2 2a3.5 3.5 0 005 5L7.5 11.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg>
            Copy
          </button>
        </div>
      </div>

      <!-- Related in sidebar -->
      <?php if(!empty($related)): ?>
      <div class="sidebar-card">
        <div class="sidebar-title">More Articles</div>
        <?php foreach($related as $r): ?>
        <a href="/blog/<?= h($r['slug']) ?>" class="sidebar-post">
          <div class="sidebar-post-img">
            <?php if($r['cover_image']): ?>
              <img src="/uploads/blog/<?= h($r['cover_image']) ?>" alt="<?= h($r['title']) ?>">
            <?php else: ?>
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><rect x="2" y="4" width="20" height="14" rx="3" stroke="rgba(255,255,255,.15)" stroke-width="1.5"/></svg>
            <?php endif; ?>
          </div>
          <div>
            <div class="sidebar-post-title"><?= h(mb_strimwidth($r['title'], 0, 55, '…')) ?></div>
            <div class="sidebar-post-date"><?= date('M j, Y', strtotime($r['created_at'])) ?></div>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <!-- CTA -->
      <div class="sidebar-card" style="background:rgba(255,255,255,.02);border-color:var(--border)">
        <div style="font-family:var(--font-h);font-size:15px;font-weight:700;color:var(--text);margin-bottom:10px">Ready to Grow?</div>
        <p style="font-size:13px;color:var(--sub);line-height:1.6;margin-bottom:18px">Let's talk about what's possible for your business.</p>
        <a href="/contact.php" class="btn-primary" style="padding:10px 20px;font-size:13px;width:100%;justify-content:center">Get Started →</a>
      </div>
    </aside>
  </div>

  <!-- Related Posts -->
  <?php if(!empty($related)): ?>
  <div style="margin-top:100px;border-top:1px solid var(--border);padding-top:80px">
    <div class="sec-label reveal">Keep Reading</div>
    <h2 class="sec-h reveal">More <span class="em">Articles</span></h2>
    <div class="related-grid">
      <?php foreach($related as $r): ?>
      <a href="/blog/<?= h($r['slug']) ?>" class="rel-card reveal">
        <div class="rel-img">
          <?php if($r['cover_image']): ?>
            <img src="/uploads/blog/<?= h($r['cover_image']) ?>" alt="<?= h($r['title']) ?>">
          <?php else: ?>
            <svg width="36" height="36" viewBox="0 0 36 36" fill="none"><rect x="3" y="6" width="30" height="21" rx="3" stroke="rgba(255,255,255,.15)" stroke-width="1.5"/></svg>
          <?php endif; ?>
        </div>
        <div class="rel-body">
          <?php if($r['cat_name']): ?><div class="rel-cat"><?= h($r['cat_name']) ?></div><?php endif; ?>
          <div class="rel-title"><?= h($r['title']) ?></div>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
