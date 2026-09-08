<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';

$pageTitle  = 'Blog | Nexos Digital Growth Agency';
$activePage = 'blog';

$db = getDB();

// Category filter
$catSlug = trim($_GET['category'] ?? '');
$page    = max(1, (int)($_GET['page'] ?? 1));
$perPage = 9;

// Get categories
$cats = $db->query("SELECT c.*, COUNT(p.id) as post_count FROM categories c LEFT JOIN posts p ON p.category_id=c.id AND p.status='published' GROUP BY c.id ORDER BY post_count DESC")->fetchAll();

// Build query
$where = "p.status='published'";
$params = [];
$activeCat = null;
if ($catSlug) {
    $catRow = $db->prepare("SELECT * FROM categories WHERE slug=?");
    $catRow->execute([$catSlug]);
    $activeCat = $catRow->fetch();
    if ($activeCat) {
        $where .= " AND p.category_id=?";
        $params[] = $activeCat['id'];
    }
}

$total = $db->prepare("SELECT COUNT(*) FROM posts p WHERE $where");
$total->execute($params);
$total = (int)$total->fetchColumn();
$pager = paginate($total, $perPage, $page);

$stmt = $db->prepare("SELECT p.*, c.name as cat_name, c.slug as cat_slug FROM posts p LEFT JOIN categories c ON p.category_id=c.id WHERE $where ORDER BY p.created_at DESC LIMIT ? OFFSET ?");
$stmt->execute(array_merge($params, [$perPage, $pager['offset']]));
$posts = $stmt->fetchAll();

// Featured (first post on page 1 with no filter)
$featured = null;
if ($page === 1 && !$catSlug) {
    $featStmt = $db->query("SELECT p.*, c.name as cat_name, c.slug as cat_slug FROM posts p LEFT JOIN categories c ON p.category_id=c.id WHERE p.status='published' ORDER BY p.created_at DESC LIMIT 1");
    $featured = $featStmt->fetch();
    // Remove featured from grid
    $posts = array_filter($posts, fn($p) => $p['id'] !== $featured['id']);
}

include __DIR__ . '/includes/header.php';
?>
<style>
/* ── Blog Hero ── */
.blog-hero-inner{max-width:700px}

/* ── Category Filter ── */
.cat-filter{display:flex;gap:10px;flex-wrap:wrap;margin:48px 0 56px;justify-content:center}
.cat-btn{
  font-family:var(--font-h);
  font-size:11px;
  font-weight:600;
  padding:9px 20px;
  border-radius:100px;
  border:1.5px solid var(--border);
  color:var(--sub);
  transition:all .35s var(--premium);
  letter-spacing:.6px;
  cursor:pointer;
  text-decoration:none;
  background:transparent;
  position:relative;
  overflow:hidden;
}
.cat-btn:hover,
.cat-btn.active{
  border-color:var(--text);
  color:var(--text);
  background:rgba(255,255,255,.04);
}

/* ── Featured Post ── */
.featured-post{
  background:var(--card);
  border:1px solid var(--border);
  border-radius:var(--r-xl);
  overflow:hidden;
  display:grid;
  grid-template-columns:1fr 1fr;
  margin-bottom:72px;
  transition:all .5s var(--premium);
  text-decoration:none;
  position:relative;
}
.featured-post:hover{
  border-color:var(--border);
}
.featured-img{
  background:var(--bg3);
  min-height:400px;
  display:flex;
  align-items:center;
  justify-content:center;
  overflow:hidden;
  position:relative;
}
.featured-img::after{
  content:'';
  position:absolute;
  inset:0;
  background:linear-gradient(135deg,rgba(0,0,0,.15),transparent 60%);
  pointer-events:none;
}
.featured-img img{width:100%;height:100%;object-fit:cover;transition:transform .6s var(--premium)}
.featured-post:hover .featured-img img{transform:scale(1.03)}
.featured-body{
  padding:52px 48px;
  display:flex;
  flex-direction:column;
  justify-content:center;
  position:relative;
  z-index:2;
}
.featured-label{
  font-family:var(--font-h);
  font-size:10px;
  font-weight:700;
  color:var(--sub);
  letter-spacing:1.4px;
  text-transform:uppercase;
  margin-bottom:20px;
  display:flex;
  align-items:center;
  gap:10px;
}
.featured-label span.dot{
  width:8px;
  height:8px;
  background:var(--sub);
  border-radius:50%;
  display:inline-block;
}
.featured-title{
  font-family:var(--font-h);
  font-size:clamp(24px,2.6vw,34px);
  font-weight:800;
  color:var(--text);
  line-height:1.2;
  letter-spacing:-.8px;
  margin-bottom:18px;
}
.featured-excerpt{
  font-family:var(--font-b);
  font-size:15px;
  color:var(--sub);
  line-height:1.85;
  margin-bottom:32px;
}
.featured-read{
  font-family:var(--font-h);
  font-size:13px;
  font-weight:600;
  display:inline-flex;
  align-items:center;
  gap:10px;
  padding:12px 28px;
  border-radius:100px;
  background:var(--blue);
  color:#fff;
  letter-spacing:.3px;
  transition:all .35s var(--premium);
  text-decoration:none;
  width:fit-content;
  box-shadow:0 4px 20px rgba(21,101,255,.3);
}
.featured-read:hover{
  transform:translateX(4px);
  box-shadow:0 8px 32px rgba(21,101,255,.3);
}

/* ── Blog Grid ── */
.blog-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px}

/* ── Blog Card ── */
.blog-card{
  background:var(--card);
  border:1px solid var(--border);
  border-radius:var(--r-xl);
  overflow:hidden;
  transition:all .5s var(--premium);
  display:flex;
  flex-direction:column;
  text-decoration:none;
  position:relative;
}
.blog-card:hover{
  border-color:var(--border);
}
.blog-card-img{
  height:210px;
  background:var(--bg3);
  display:flex;
  align-items:center;
  justify-content:center;
  overflow:hidden;
  flex-shrink:0;
  position:relative;
}
.blog-card-img::after{
  content:'';
  position:absolute;
  inset:0;
  background:linear-gradient(180deg,transparent 60%,rgba(5,5,8,.6));
  pointer-events:none;
}
.blog-card-img img{width:100%;height:100%;object-fit:cover;transition:transform .5s var(--premium)}
.blog-card:hover .blog-card-img img{transform:scale(1.05)}
.blog-card-body{
  padding:28px 30px 30px;
  flex:1;
  display:flex;
  flex-direction:column;
  position:relative;
  z-index:2;
}
.blog-cat-tag{
  font-family:var(--font-h);
  font-size:9px;
  font-weight:700;
  color:var(--sub);
  letter-spacing:1.4px;
  text-transform:uppercase;
  margin-bottom:12px;
  display:flex;
  align-items:center;
  gap:6px;
}
.blog-cat-tag::before{
  content:'';
  width:4px;
  height:4px;
  background:var(--sub);
  border-radius:50%;
  display:inline-block;
}
.blog-title{
  font-family:var(--font-h);
  font-size:17px;
  font-weight:700;
  color:var(--text);
  line-height:1.38;
  margin-bottom:12px;
  transition:color .3s;
}
.blog-card:hover .blog-title{color:var(--text)}
.blog-excerpt{
  font-family:var(--font-b);
  font-size:13px;
  color:var(--sub);
  line-height:1.75;
  margin-bottom:20px;
  flex:1;
}
.blog-meta{
  font-family:var(--font-b);
  font-size:11px;
  color:var(--sub);
  display:flex;
  align-items:center;
  gap:8px;
  margin-top:auto;
  padding-top:16px;
  border-top:1px solid var(--border);
}

/* ── Pagination ── */
.pagination{display:flex;justify-content:center;gap:10px;margin-top:72px}
.page-btn{
  width:42px;
  height:42px;
  border-radius:50%;
  border:1.5px solid var(--border);
  display:flex;
  align-items:center;
  justify-content:center;
  font-family:var(--font-h);
  font-size:13px;
  font-weight:600;
  color:var(--sub);
  transition:all .35s var(--premium);
  text-decoration:none;
  background:transparent;
  position:relative;
}
.page-btn:hover,
.page-btn.active{
  border-color:var(--text);
  color:var(--text);
  background:rgba(255,255,255,.04);
}

/* ── Empty State ── */
.empty-state{text-align:center;padding:96px 24px;color:var(--sub)}
.empty-state svg{margin:0 auto 24px;opacity:.25}

/* ── Responsive ── */
@media(max-width:1024px){
  .featured-post{grid-template-columns:1fr}
  .blog-grid{grid-template-columns:1fr 1fr}
  .featured-body{padding:40px 36px}
}
@media(max-width:640px){
  .blog-grid{grid-template-columns:1fr}
  .featured-body{padding:32px 28px}
}
</style>

<!-- PAGE HERO -->
<section class="page-hero">
  <div class="page-hero-bg"></div>
  <div class="page-hero-glow"></div>
  <div class="page-hero-content">
    <div class="page-breadcrumb"><a href="/">Home</a><span>/</span><span style="color:var(--text)">Blog</span></div>
    <div class="sec-label" style="margin-bottom:22px;opacity:0;animation:fadeUp .7s .1s var(--ease) forwards">Insights &amp; Strategies</div>
    <h1 class="sec-h" style="font-size:clamp(42px,5.5vw,72px);letter-spacing:-3px;opacity:0;animation:fadeUp .9s .2s var(--ease) forwards">
      The <span class="em">Nexos</span> Blog
    </h1>
    <p class="sec-sub" style="opacity:0;animation:fadeUp .9s .38s var(--ease) forwards;margin-top:20px">Expert insights on SEO, digital advertising, web design, and growth strategy — written by practitioners, not copywriters.</p>
  </div>
</section>

<!-- BLOG CONTENT -->
<section class="sec" style="background:var(--bg)">

  <!-- Category Filter -->
  <div class="cat-filter">
    <a href="/blog.php" class="cat-btn <?= !$catSlug ? 'active' : '' ?>">All Posts</a>
    <?php foreach($cats as $cat): if(!$cat['post_count']) continue; ?>
    <a href="/blog.php?category=<?= h($cat['slug']) ?>" class="cat-btn <?= $catSlug===$cat['slug'] ? 'active' : '' ?>"><?= h($cat['name']) ?> <span style="opacity:.5">(<?= $cat['post_count'] ?>)</span></a>
    <?php endforeach; ?>
  </div>

  <!-- Featured Post -->
  <?php if($featured): ?>
  <a href="/blog/<?= h($featured['slug']) ?>" class="featured-post reveal">
    <div class="featured-img">
      <?php if($featured['cover_image']): ?>
        <img src="/uploads/blog/<?= h($featured['cover_image']) ?>" alt="<?= h($featured['title']) ?>">
      <?php else: ?>
        <svg width="60" height="60" viewBox="0 0 60 60" fill="none"><rect x="5" y="10" width="50" height="35" rx="5" stroke="rgba(255,255,255,.15)" stroke-width="2"/><path d="M15 35l10-12.5 8 9 6-6 11 9.5" stroke="rgba(255,255,255,.15)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      <?php endif; ?>
    </div>
    <div class="featured-body">
      <div class="featured-label">
        <span class="dot"></span>
        Featured Post <?php if($featured['cat_name']): ?>· <?= h($featured['cat_name']) ?><?php endif; ?>
      </div>
      <div class="featured-title"><?= h($featured['title']) ?></div>
      <div class="featured-excerpt"><?= h($featured['excerpt'] ?: excerpt($featured['content'])) ?></div>
      <div style="display:flex;align-items:center;gap:20px">
        <span style="font-family:var(--font-b);font-size:12px;color:var(--sub)"><?= date('F j, Y', strtotime($featured['created_at'])) ?></span>
        <span class="featured-read">Read Article →</span>
      </div>
    </div>
  </a>
  <?php endif; ?>

  <!-- Posts Grid -->
  <?php if(!empty($posts)): ?>
  <div class="blog-grid">
    <?php foreach($posts as $post): ?>
    <a href="/blog/<?= h($post['slug']) ?>" class="blog-card reveal">
      <div class="blog-card-img">
        <?php if($post['cover_image']): ?>
          <img src="/uploads/blog/<?= h($post['cover_image']) ?>" alt="<?= h($post['title']) ?>">
        <?php else: ?>
          <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect x="4" y="8" width="40" height="28" rx="4" stroke="rgba(255,255,255,.15)" stroke-width="2"/><path d="M12 28l8-10 6 7 5-5 7 8" stroke="rgba(255,255,255,.15)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <?php endif; ?>
      </div>
      <div class="blog-card-body">
        <?php if($post['cat_name']): ?><div class="blog-cat-tag"><?= h($post['cat_name']) ?></div><?php endif; ?>
        <div class="blog-title"><?= h($post['title']) ?></div>
        <div class="blog-excerpt"><?= h($post['excerpt'] ?: excerpt($post['content'])) ?></div>
        <div class="blog-meta">
          <span><?= date('M j, Y', strtotime($post['created_at'])) ?></span>
          <span>·</span>
          <span><?= $post['views'] ?> views</span>
        </div>
      </div>
    </a>
    <?php endforeach; ?>
  </div>
  <?php elseif(!$featured): ?>
  <div class="empty-state">
    <svg width="60" height="60" viewBox="0 0 60 60" fill="none"><rect x="5" y="10" width="50" height="40" rx="6" stroke="rgba(255,255,255,.12)" stroke-width="2"/><path d="M15 22h30M15 30h20M15 38h15" stroke="rgba(255,255,255,.12)" stroke-width="2" stroke-linecap="round"/></svg>
    <p style="font-size:16px;font-family:var(--font-h);font-weight:600">No posts yet.</p>
    <p style="font-size:14px;margin-top:8px;font-family:var(--font-b)">Check back soon — new articles coming.</p>
  </div>
  <?php endif; ?>

  <!-- Pagination -->
  <?php if($pager['pages'] > 1): ?>
  <div class="pagination">
    <?php if($page > 1): ?>
      <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page-1])) ?>" class="page-btn">←</a>
    <?php endif; ?>
    <?php for($i=1; $i<=$pager['pages']; $i++): ?>
      <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" class="page-btn <?= $i===$page ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>
    <?php if($page < $pager['pages']): ?>
      <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page+1])) ?>" class="page-btn">→</a>
    <?php endif; ?>
  </div>
  <?php endif; ?>

</section>

<script>
document.addEventListener('DOMContentLoaded', function(){
  if(typeof gsap==='undefined'||typeof ScrollTrigger==='undefined')return;

  // Featured post
  var featured=document.querySelector('.featured-post');
  if(featured){
    gsap.from(featured,{
      opacity:0,y:60,scale:.97,duration:1.1,ease:'power4.out',
      scrollTrigger:{trigger:featured,start:'top 80%'}
    });
  }

  // Blog grid cards stagger
  gsap.utils.toArray('.blog-grid .blog-card').forEach(function(card,i){
    gsap.from(card,{
      opacity:0,y:50,scale:.95,duration:.9,delay:i*.1,ease:'power4.out',
      scrollTrigger:{trigger:card,start:'top 88%'}
    });
  });

  // Category filter buttons
  gsap.utils.toArray('.cat-btn').forEach(function(btn,i){
    gsap.from(btn,{
      opacity:0,y:20,scale:.8,duration:.4,delay:i*.05,ease:'back.out(1.5)',
      scrollTrigger:{trigger:'.cat-filter',start:'top 90%'}
    });
  });
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
