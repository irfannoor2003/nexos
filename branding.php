<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';
$pageTitle  = 'Branding | Nexos';
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
    content:'';position:absolute;width:900px;height:900px;right:-220px;top:-260px;background:radial-gradient(circle,rgba(21,101,255,.14),transparent 62%);filter:blur(18px)
  }
  .detail-shell{position:relative;z-index:1;max-width:1200px;margin:0 auto}
  .detail-hero-layout{display:grid;grid-template-columns:1.15fr .85fr;gap:48px;align-items:center}
  .detail-copy{position:relative;z-index:2}
  .detail-title{margin:0 0 18px;font-size:clamp(42px,5.8vw,84px);letter-spacing:-2px;line-height:0.96}
  .detail-title .gradient{background:linear-gradient(135deg,var(--blue),var(--blue2));-webkit-background-clip:text;background-clip:text;color:transparent}
  .detail-sub{max-width:720px;color:var(--sub);font-size:18px;line-height:1.8;margin-bottom:0}
  .mini-badge{display:inline-flex;align-items:center;gap:8px;padding:8px 18px;border:1px solid var(--border);border-radius:100px;background:rgba(255,255,255,.04);font-size:10px;letter-spacing:1.4px;text-transform:uppercase;color:var(--sub);margin-bottom:24px}
  .detail-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-top:46px}
  .detail-stat{padding:26px 22px;border:1px solid var(--border);border-radius:22px;background:rgba(255,255,255,.02);transition:all .35s var(--spring)}
  .detail-stat:hover{transform:translateY(-4px);box-shadow:var(--shadow-md)}
  .detail-stat .kicker{display:block;font-size:11px;letter-spacing:1.3px;text-transform:uppercase;color:var(--sub);margin-bottom:12px}
  .detail-stat strong{font-size:30px;font-family:var(--font-h)}
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
  .detail-panel-grid .detail-stat,.process-card,.service-item,.quote-box,.detail-card,.card,.benefit-box,.cta-panel{transform-style:preserve-3d;transition:transform .35s var(--spring),box-shadow .35s var(--spring),border-color .35s ease}
  .detail-panel-grid .detail-stat:hover,.process-card:hover,.service-item:hover,.quote-box:hover,.detail-card:hover,.card:hover,.benefit-box:hover,.cta-panel:hover{transform:translateY(-6px) translateZ(0)}
  @keyframes pulseOrb {0%,100%{transform:scale(1);opacity:.8}50%{transform:scale(1.15);opacity:1}}
  .detail-section{padding:100px 60px;position:relative}
  .detail-inner{max-width:1200px;margin:0 auto}
  .two-col{display:grid;grid-template-columns:1.05fr .95fr;gap:48px;align-items:center}
  .lead{color:var(--sub);font-size:18px;line-height:1.9}
  .quote-box{padding:28px;border:1px solid var(--border);border-radius:26px;background:linear-gradient(180deg,rgba(255,255,255,.02),rgba(255,255,255,.01));box-shadow:var(--shadow-md)}
  .quote-box .mini{font-size:11px;letter-spacing:1.2px;text-transform:uppercase;color:var(--sub);margin-bottom:16px}
  .quote-box blockquote{font-size:28px;line-height:1.35;letter-spacing:-.8px;font-weight:600}
  .process-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-top:40px}
  .process-card{padding:28px 22px;border:1px solid var(--border);border-radius:24px;background:rgba(255,255,255,.02);transition:all .35s var(--spring)}
  .process-card:hover{transform:translateY(-7px);box-shadow:var(--shadow-md)}
  .process-card .num{display:inline-flex;align-items:center;justify-content:center;min-width:48px;height:48px;border-radius:14px;background:rgba(21,101,255,.12);border:1px solid rgba(21,101,255,.2);font-size:18px;font-weight:700;margin-bottom:20px}
  .process-card h3{font-size:20px;margin-bottom:10px}
  .process-card p{color:var(--sub);line-height:1.7}
  .service-list{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-top:28px}
  .service-item{padding:26px 22px;border:1px solid var(--border);border-radius:22px;background:rgba(255,255,255,.02);transition:all .35s var(--spring)}
  .service-item:hover{transform:translateY(-4px);box-shadow:var(--shadow-md)}
  .service-item h4{margin-bottom:12px;font-size:20px}
  .service-item ul{list-style:none;display:flex;flex-direction:column;gap:10px;color:var(--sub)}
  .service-item li{position:relative;padding-left:18px}
  .service-item li::before{content:'✓';position:absolute;left:0;top:0;color:var(--blue2);font-weight:700;font-size:14px}
  .process-card-icon{display:inline-flex;align-items:center;justify-content:center;width:44px;height:44px;border-radius:12px;background:rgba(21,101,255,.12);border:1px solid rgba(21,101,255,.2);margin-bottom:14px;transition:all .35s var(--spring)}
  .process-card-icon svg{width:22px;height:22px;color:var(--blue2)}
  .process-card:hover .process-card-icon{background:rgba(21,101,255,.18);transform:scale(1.15) rotate(-6deg)}
  .cta-panel{padding:70px 30px;border:1px solid var(--border);border-radius:28px;background:linear-gradient(135deg,rgba(21,101,255,.1),rgba(255,255,255,.02));text-align:center;position:relative;overflow:hidden}
  .cta-panel::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.02) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.02) 1px,transparent 1px);background-size:24px 24px;mask-image:radial-gradient(ellipse 80% 80% at 50% 50%,#000 20%,transparent 100%)}
  .cta-panel > *{position:relative;z-index:1}
  @keyframes floatCard {0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
  @media(max-width:980px){
    .detail-hero,.detail-section{padding-left:24px;padding-right:24px}
    .detail-hero-layout,.two-col,.process-grid,.service-list,.detail-stats{grid-template-columns:1fr}
    .detail-media{height:380px}
  }
</style>

<section class="detail-page">
  <section class="detail-hero">
    <div class="detail-shell">
      <div class="detail-hero-layout">
        <div class="detail-copy reveal-l">
          <div class="page-breadcrumb"><a href="/">Home</a><span>/</span><a href="/services.php">Services</a><span>/</span><span style="color:var(--text)">Branding</span></div>
          <div class="mini-badge"><span class="badge-dot"></span>Branding Agency</div>
          <h1 class="sec-h detail-title">Build a brand <span class="em gradient">people remember</span></h1>
          <p class="detail-sub">Strategic branding for businesses ready to look credible, stand apart and grow with confidence.</p>
          <div class="detail-stats">
            <div class="detail-stat"><span class="kicker">Focus</span><strong>Strategy</strong></div>
            <div class="detail-stat"><span class="kicker">Identity</span><strong>Positioning</strong></div>
            <div class="detail-stat"><span class="kicker">Activation</span><strong>Consistency</strong></div>
          </div>
        </div>
        <div class="detail-media reveal-r">
          <div class="mini-orb"></div>
          <div class="svg-orbit" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l2.8 5.7L20 8.5l-4.5 4.4 1.1 6.1L12 0 7.4 19l1.1-6.1L4 8.5l5.2-.8L12 2z"/></svg>
          </div>
          <img src="<?= site_img('svc_brand_detail', '/assets/images/svc-brand.jpg') ?>" alt="Brand identity strategy" loading="lazy">
          <div class="floating-panel">
            <span class="kicker">Identity</span>
            <strong>+41%</strong>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="detail-section">
    <div class="detail-inner two-col">
      <div>
        <div class="sec-label">Why it matters</div>
        <h2 class="sec-h">Your business has grown.<br><span class="em">Has your brand kept up?</span></h2>
        <p class="lead">Your business may have the expertise, products and experience to compete—but if your brand looks inconsistent, outdated or indistinguishable, customers may never see the value behind it.</p>
      </div>
      <div class="quote-box">
        <div class="mini">The challenge</div>
        <blockquote>“A brand isn’t what you put on your business. It’s what people remember about it.”</blockquote>
      </div>
    </div>
  </section>

  <section class="detail-section" style="background:var(--bg2)">
    <div class="detail-inner">
      <div class="sec-label">Our approach</div>
      <h2 class="sec-h">Strategy first. <span class="em">Design second.</span></h2>
      <div class="process-grid">
        <div class="process-card">
          <div class="process-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="1"/><path d="M12 3v6m0 6v6"/><path d="M3 12h6m6 0h6"/><circle cx="12" cy="12" r="9"/></svg></div>
          <div class="num">01</div>
          <h3>Discover</h3>
          <p>We learn your business, audience, market and competitive landscape.</p>
        </div>
        <div class="process-card">
          <div class="process-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M9 12h6M3 18h18"/></svg></div>
          <div class="num">02</div>
          <h3>Define</h3>
          <p>We clarify your positioning, personality, messaging and visual direction.</p>
        </div>
        <div class="process-card">
          <div class="process-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v18M3 12h18M7.5 7.5l3-3 3 3M16.5 16.5l-3 3-3-3"/></svg></div>
          <div class="num">03</div>
          <h3>Design</h3>
          <p>We create a distinctive visual identity designed around your strategy.</p>
        </div>
        <div class="process-card">
          <div class="process-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
          <div class="num">04</div>
          <h3>Activate</h3>
          <p>We apply your brand across digital, social, print and marketing touchpoints.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="detail-section">
    <div class="detail-inner">
      <div class="sec-label">What we do</div>
      <h2 class="sec-h">Everything you need to build a <span class="em">stronger brand.</span></h2>
      <div class="service-list">
        <div class="service-item">
          <div class="svc-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16M9 15h6M6 3h12v14H6z"/></svg></div>
          <h4>Brand Strategy</h4>
          <ul>
            <li>Brand positioning</li>
            <li>Audience research</li>
            <li>Competitor analysis</li>
            <li>Brand personality</li>
            <li>Messaging direction</li>
          </ul>
        </div>
        <div class="service-item">
          <div class="svc-card-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3L3 9v10h18V9l-9-6z"/><path d="M9 12h6M12 15v3"/></svg></div>
          <h4>Brand Identity</h4>
          <ul>
            <li>Logo design</li>
            <li>Visual identity</li>
            <li>Typography</li>
            <li>Color system</li>
            <li>Graphic language</li>
            <li>Brand guidelines</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section class="detail-section" style="background:var(--bg2)">
    <div class="detail-inner cta-panel">
      <div class="sec-label">Ready to grow</div>
      <h2 class="sec-h" style="margin-bottom:12px;">Your brand deserves<br><span class="em">more attention.</span></h2>
      <p class="lead" style="max-width:760px;margin:0 auto 26px;">We build brands that are recognizable, consistent and designed for real-world business growth.</p>
      <a href="/contact.php" class="btn-primary">Start your project</a>
    </div>
  </section>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
