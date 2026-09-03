<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';
$pageTitle  = 'Digital Marketing | Nexos';
$activePage = 'services';
include __DIR__ . '/includes/header.php';
?>
<style>
  .detail-page{background:var(--bg);color:var(--text)}
  .detail-hero{position:relative;padding:170px 64px 110px;overflow:hidden;background:var(--bg)}
  .detail-hero::before{
    content:'';position:absolute;inset:0;
    background-image:linear-gradient(rgba(255,255,255,.025) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.025) 1px,transparent 1px);
    background-size:80px 80px;mask-image:radial-gradient(ellipse 80% 80% at 50% 40%,#000 30%,transparent 100%);
  }
  .detail-hero::after{
    content:'';position:absolute;width:900px;height:900px;left:-220px;top:-260px;background:radial-gradient(circle,rgba(21,101,255,.14),transparent 62%);filter:blur(18px)
  }
  .detail-shell{position:relative;z-index:1;max-width:1200px;margin:0 auto}
  .detail-hero-layout{display:grid;grid-template-columns:1.15fr .85fr;gap:48px;align-items:center}
  .detail-copy{position:relative;z-index:2}
  .detail-title{margin:0 0 18px;font-size:clamp(42px,5.8vw,84px);letter-spacing:-2px;line-height:0.96}
  .detail-title .gradient{background:linear-gradient(135deg,var(--blue),var(--blue2));-webkit-background-clip:text;background-clip:text;color:transparent}
  .detail-sub{max-width:760px;color:var(--sub);font-size:18px;line-height:1.8}
  .mini-badge{display:inline-flex;align-items:center;gap:8px;padding:8px 18px;border:1px solid var(--border);border-radius:100px;background:rgba(255,255,255,.04);font-size:10px;letter-spacing:1.4px;text-transform:uppercase;color:var(--sub);margin-bottom:24px}
  .detail-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-top:46px}
  .detail-card{padding:26px 20px;border:1px solid var(--border);border-radius:22px;background:rgba(255,255,255,.02);transition:all .35s var(--spring)}
  .detail-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-md)}
  .detail-card h3{font-size:18px;margin-bottom:10px}
  .detail-card p{color:var(--sub);line-height:1.7}
  .detail-media{position:relative;height:520px;border:1px solid var(--border);border-radius:32px;overflow:hidden;background:var(--bg2);box-shadow:var(--shadow-xl);transform-style:preserve-3d;transform:perspective(1200px) rotateX(0deg) rotateY(0deg);animation:floatCard 7s ease-in-out infinite;transition:transform .4s ease,box-shadow .4s ease}
  .detail-media::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,.08),transparent 45%);z-index:2;pointer-events:none}
  .detail-media:hover{box-shadow:0 30px 80px rgba(21,101,255,.12)}
  .detail-media img{width:100%;height:100%;object-fit:cover;filter:saturate(1.1) contrast(1.08);transform:scale(1.03)}
  .detail-media .floating-panel{position:absolute;right:20px;bottom:20px;z-index:3;background:rgba(12,12,20,.82);border:1px solid var(--border);backdrop-filter:blur(16px);border-radius:18px;padding:18px 20px;min-width:180px;box-shadow:var(--shadow-md);transform:translateZ(30px)}
  .floating-panel .kicker{font-size:10px;letter-spacing:1.2px;text-transform:uppercase;color:var(--sub);display:block;margin-bottom:8px}
  .floating-panel strong{font-size:26px;font-family:var(--font-h)}
  .detail-media .mini-orb{position:absolute;left:20px;top:20px;width:86px;height:86px;border-radius:50%;background:radial-gradient(circle,rgba(21,101,255,.36),transparent 68%);filter:blur(12px);z-index:1;animation:pulseOrb 5s ease-in-out infinite}
  .detail-media .svg-orbit{position:absolute;inset:auto 28px 26px auto;z-index:4;display:grid;place-items:center;width:120px;height:120px;border-radius:50%;background:rgba(15,17,27,.7);border:1px solid var(--border);box-shadow:var(--shadow-md);transform:translateZ(50px)}
  .detail-media .svg-orbit svg{width:52px;height:52px;color:var(--blue2)}
  .detail-card,.service-item,.benefit-box,.cta-panel,.card,.quote-box{transform-style:preserve-3d;transition:transform .35s var(--spring),box-shadow .35s var(--spring),border-color .35s ease}
  .detail-card:hover,.service-item:hover,.benefit-box:hover,.cta-panel:hover,.card:hover,.quote-box:hover{transform:translateY(-6px) translateZ(0)}
  @keyframes pulseOrb {0%,100%{transform:scale(1);opacity:.8}50%{transform:scale(1.15);opacity:1}}
  .detail-section{padding:100px 60px;position:relative}
  .detail-inner{max-width:1200px;margin:0 auto}
  .two-col{display:grid;grid-template-columns:1.05fr .95fr;gap:48px;align-items:center}
  .lead{color:var(--sub);font-size:18px;line-height:1.9}
  .benefit-box{padding:28px;border:1px solid var(--border);border-radius:26px;background:linear-gradient(180deg,rgba(255,255,255,.02),rgba(255,255,255,.01));box-shadow:var(--shadow-md)}
  .benefit-box h3{font-size:22px;margin-bottom:18px}
  .benefit-list{list-style:none;display:grid;grid-template-columns:1fr 1fr;gap:12px 18px;color:var(--sub)}
  .benefit-list li{position:relative;padding-left:20px}
  .benefit-list li::before{content:'✓';position:absolute;left:0;color:var(--blue2)}
  .detail-card-icon{display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:12px;background:rgba(21,101,255,.12);border:1px solid rgba(21,101,255,.2);margin-bottom:12px;transition:all .35s var(--spring)}
  .detail-card-icon svg{width:20px;height:20px;color:var(--blue2)}
  .detail-card:hover .detail-card-icon{background:rgba(21,101,255,.18);transform:scale(1.15) rotate(-6deg)}
  .service-list{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin-top:30px}
  .service-item{padding:28px 22px;border:1px solid var(--border);border-radius:24px;background:rgba(255,255,255,.02);transition:all .35s var(--spring)}
  .service-item:hover{transform:translateY(-4px);box-shadow:var(--shadow-md)}
  .service-item .index{display:inline-flex;align-items:center;justify-content:center;min-width:40px;height:40px;border-radius:12px;background:rgba(21,101,255,.12);border:1px solid rgba(21,101,255,.2);font-size:14px;font-weight:700;margin-bottom:16px}
  .service-item h3{font-size:22px;margin-bottom:10px}
  .service-item p{color:var(--sub);line-height:1.7}
  .cta-panel{padding:70px 30px;border:1px solid var(--border);border-radius:28px;background:linear-gradient(135deg,rgba(21,101,255,.1),rgba(255,255,255,.02));text-align:center;position:relative;overflow:hidden}
  .cta-panel::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.02) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.02) 1px,transparent 1px);background-size:24px 24px;mask-image:radial-gradient(ellipse 80% 80% at 50% 50%,#000 20%,transparent 100%)}
  .cta-panel > *{position:relative;z-index:1}
  @keyframes floatCard {0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
  @media(max-width:980px){
    .detail-hero,.detail-section{padding-left:24px;padding-right:24px}
    .detail-hero-layout,.two-col,.detail-grid,.service-list,.benefit-list{grid-template-columns:1fr}
    .detail-media{height:380px}
  }
</style>

<section class="detail-page">
  <section class="detail-hero">
    <div class="detail-shell">
      <div class="detail-hero-layout">
        <div class="detail-copy reveal-l">
          <div class="page-breadcrumb"><a href="/">Home</a><span>/</span><a href="/services.php">Services</a><span>/</span><span style="color:var(--text)">Digital Marketing</span></div>
          <div class="mini-badge"><span class="badge-dot"></span>Marketing Agency</div>
          <h1 class="sec-h detail-title">Stop Marketing,<br><span class="em gradient">Start Growing.</span></h1>
          <p class="detail-sub">We build data-driven digital marketing systems that put your business in front of the right people, turn attention into leads, and turn leads into growth.</p>
          <div class="detail-grid">
            <div class="detail-card"><div class="detail-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7"/></svg></div><h3>Social Media</h3><p>Build community and visibility with content that converts.</p></div>
            <div class="detail-card"><div class="detail-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg></div><h3>Content</h3><p>Thoughtful content that helps your audience trust and choose you.</p></div>
            <div class="detail-card"><div class="detail-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><path d="M12 1v6m0 6v6M4.22 4.22l4.24 4.24m4.24 4.24l4.24 4.24M1 12h6m6 0h6M4.22 19.78l4.24-4.24m4.24-4.24l4.24-4.24"/></svg></div><h3>Email</h3><p>Keep prospects engaged and move them toward action.</p></div>
            <div class="detail-card"><div class="detail-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><polyline points="19 12 12 19 5 12"/></svg></div><h3>Paid Ads</h3><p>Run ads that are measurable, efficient and focused on ROI.</p></div>
          </div>
        </div>
        <div class="detail-media reveal-r">
          <div class="mini-orb"></div>
          <div class="svg-orbit" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 18V9.5A1.5 1.5 0 015.5 8H8V6a2 2 0 012-2h4a2 2 0 012 2v2h2.5A1.5 1.5 0 0120 9.5V18"/><path d="M2 18h20M9 12h6M12 9v6"/></svg>
          </div>
          <img src="<?= site_img('svc_marketing_detail', '/assets/images/svc-social.jpg') ?>" alt="Digital marketing campaign strategy" loading="lazy">
          <div class="floating-panel">
            <span class="kicker">Pipeline</span>
            <strong>+63%</strong>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="detail-section">
    <div class="detail-inner two-col">
      <div>
        <div class="sec-label">Our promise</div>
        <h2 class="sec-h">Digital experiences with <span class="em">purpose.</span></h2>
        <p class="lead">From design systems to complete strategic overhauls and headless CMS development, we design and build intuitive solutions that are ready for what’s next.</p>
      </div>
      <div class="benefit-box">
        <h3>Benefits of digital marketing</h3>
        <ul class="benefit-list">
          <li>Reach the right people</li>
          <li>Build lasting brand visibility</li>
          <li>Turn attention into opportunities</li>
          <li>Make your marketing measurable</li>
          <li>Create more efficient growth</li>
          <li>Stay ahead of changing demand</li>
        </ul>
      </div>
    </div>
  </section>

  <section class="detail-section" style="background:var(--bg2)">
    <div class="detail-inner">
      <div class="sec-label">End-to-end marketing</div>
      <h2 class="sec-h">Dive into our <span class="em">services</span></h2>
      <div class="service-list">
        <div class="service-item">
          <div class="index">01</div>
          <h3>Consultancy & Strategy</h3>
          <p>We build data-driven marketing strategies aligned with your business goals, audience and growth opportunities.</p>
        </div>
        <div class="service-item">
          <div class="index">02</div>
          <h3>Social Media Management</h3>
          <p>We create and manage purposeful social content that builds visibility, engagement and meaningful connections.</p>
        </div>
        <div class="service-item">
          <div class="index">03</div>
          <h3>Campaign Planning</h3>
          <p>We plan and optimise targeted campaigns designed to reach the right audience and generate qualified leads.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="detail-section">
    <div class="detail-inner cta-panel">
      <div class="sec-label">Ready to grow</div>
      <h2 class="sec-h" style="margin-bottom:12px;">Let’s build <span class="em">what’s next.</span></h2>
      <p class="lead" style="max-width:760px;margin:0 auto 26px;">Whether you need stronger leads, better campaigns or more consistent visibility, we create the digital engine to turn attention into measurable results.</p>
      <a href="/contact.php" class="btn-primary">Start your project</a>
    </div>
  </section>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
