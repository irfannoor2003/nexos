<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';
$pageTitle  = 'Digital Advertising | Nexos';
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
  .detail-sub{max-width:740px;color:var(--sub);font-size:18px;line-height:1.8}
  .mini-badge{display:inline-flex;align-items:center;gap:8px;padding:8px 18px;border:1px solid var(--border);border-radius:100px;background:rgba(255,255,255,.04);font-size:10px;letter-spacing:1.4px;text-transform:uppercase;color:var(--sub);margin-bottom:24px}
  .detail-media{position:relative;height:520px;border:1px solid var(--border);border-radius:32px;overflow:hidden;background:var(--bg2);box-shadow:var(--shadow-xl);transform-style:preserve-3d;transform:perspective(1200px) rotateX(0deg) rotateY(0deg);animation:floatCard 7s ease-in-out infinite;transition:transform .4s ease,box-shadow .4s ease}
  .detail-media::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,.08),transparent 45%);z-index:2;pointer-events:none}
  .detail-media:hover{box-shadow:0 30px 80px rgba(21,101,255,.12)}
  .detail-media img{width:100%;height:100%;object-fit:cover;filter:saturate(1.1) contrast(1.08);transform:scale(1.03)}
  .detail-media .floating-panel{position:absolute;right:20px;bottom:20px;z-index:3;background:var(--card);border:1px solid var(--border);backdrop-filter:blur(16px);border-radius:18px;padding:18px 20px;min-width:180px;box-shadow:var(--shadow-md);transform:translateZ(30px)}
  .floating-panel .kicker{font-size:10px;letter-spacing:1.2px;text-transform:uppercase;color:var(--sub);display:block;margin-bottom:8px}
  .floating-panel strong{font-size:26px;font-family:var(--font-h)}
  .detail-media .mini-orb{position:absolute;left:20px;top:20px;width:86px;height:86px;border-radius:50%;background:radial-gradient(circle,rgba(21,101,255,.36),transparent 68%);filter:blur(12px);z-index:1;animation:pulseOrb 5s ease-in-out infinite}
  .detail-media .svg-orbit{position:absolute;inset:auto 28px 26px auto;z-index:4;display:grid;place-items:center;width:120px;height:120px;border-radius:50%;background:var(--bg3);border:1px solid var(--border);box-shadow:var(--shadow-md);transform:translateZ(50px)}
  .detail-media .svg-orbit svg{width:52px;height:52px;color:var(--blue2)}
  .detail-card,.process-card,.service-item,.quote-box,.benefit-box,.cta-panel{transform-style:preserve-3d;transition:transform .35s var(--spring),box-shadow .35s var(--spring),border-color .35s ease}
  .detail-card:hover,.process-card:hover,.service-item:hover,.quote-box:hover,.benefit-box:hover,.cta-panel:hover{transform:translateY(-6px) translateZ(0)}
  @keyframes pulseOrb {0%,100%{transform:scale(1);opacity:.8}50%{transform:scale(1.15);opacity:1}}
  .detail-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-top:46px}
  .detail-card-icon{display:flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:12px;background:rgba(21,101,255,.12);border:1px solid rgba(21,101,255,.2);margin-bottom:12px;transition:all .35s var(--spring)}
  .detail-card-icon svg{width:20px;height:20px;color:var(--blue2)}
  .detail-card:hover .detail-card-icon{background:rgba(21,101,255,.18);transform:scale(1.15) rotate(-6deg)}
  .detail-card{padding:26px 20px;border:1px solid var(--border);border-radius:22px;background:rgba(255,255,255,.02);transition:all .35s var(--spring)}
  .detail-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-md)}
  .detail-card h3{font-size:18px;margin-bottom:10px}
  .detail-card p{color:var(--sub);line-height:1.7}
  .detail-section{padding:100px 60px;position:relative}
  .detail-inner{max-width:1200px;margin:0 auto}
  .two-col{display:grid;grid-template-columns:1.05fr .95fr;gap:48px;align-items:center}
  .lead{color:var(--sub);font-size:18px;line-height:1.9}
  .benefit-box{padding:28px;border:1px solid var(--border);border-radius:26px;background:linear-gradient(180deg,rgba(255,255,255,.02),rgba(255,255,255,.01));box-shadow:var(--shadow-md)}
  .benefit-box h3{font-size:22px;margin-bottom:18px}
  .benefit-list{list-style:none;display:grid;grid-template-columns:1fr 1fr;gap:12px 18px;color:var(--sub)}
  .benefit-list li{position:relative;padding-left:20px}
  .benefit-list li::before{content:'✓';position:absolute;left:0;color:var(--blue2)}
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
          <div class="page-breadcrumb"><a href="/">Home</a><span>/</span><a href="/services.php">Services</a><span>/</span><span style="color:var(--text)">Digital Advertising</span></div>
          <div class="mini-badge"><span class="badge-dot"></span>Performance Growth</div>
          <h1 class="sec-h detail-title">Stop guessing.<br><span class="em gradient">Start scaling.</span></h1>
          <p class="detail-sub">We build ad campaigns that are rooted in data, audience intent, and conversion strategy so your budget delivers measurable growth.</p>
          <div class="detail-grid">
            <div class="detail-card"><h3>Meta Ads</h3><p>Reach the right user at the perfect moment with focused campaigns.</p></div>
            <div class="detail-card"><h3>Google Ads</h3><p>Capture high-intent search traffic from people ready to buy.</p></div>
            <div class="detail-card"><h3>Retargeting</h3><p>Bring warm leads back and improve conversion efficiency.</p></div>
            <div class="detail-card"><h3>Analytics</h3><p>Track performance clearly and optimize every spend decision.</p></div>
          </div>
        </div>
        <div class="detail-media reveal-r">
          <div class="mini-orb"></div>
          <img src="<?= site_img('svc_ads_detail', '/assets/images/svc-ads.jpg') ?>" alt="Ad campaign performance" loading="lazy">
          <div class="floating-panel">
            <span class="kicker">ROAS</span>
            <strong>6.2x</strong>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="detail-section">
    <div class="detail-inner two-col">
      <div>
        <div class="sec-label">Our promise</div>
        <h2 class="sec-h">Meta and Google ads built for <span class="em">real ROI.</span></h2>
        <p class="lead">Advertising only works when it is built around audience behavior, channel fit, and a clear funnel. We create campaigns that bring qualified traffic, lower wasted spend, and keep performance measurable.</p>
      </div>
      <div class="benefit-box">
        <h3>Benefits of performance marketing</h3>
        <ul class="benefit-list">
          <li>Strong lead generation</li>
          <li>More qualified traffic</li>
          <li>Lower wasted budget</li>
          <li>Improved conversion rates</li>
          <li>Smarter retargeting</li>
          <li>Clear ROI reports</li>
        </ul>
      </div>
    </div>
  </section>

  <section class="detail-section" style="background:var(--bg2)">
    <div class="detail-inner">
      <div class="sec-label">Campaign system</div>
      <h2 class="sec-h">A complete advertising engine from <span class="em">creative to conversion.</span></h2>
      <div class="service-list">
        <div class="service-item">
          <div class="index">01</div>
          <h3>Campaign Strategy</h3>
          <p>We define audience segments, channel mix, and funnel priorities before any spend begins.</p>
        </div>
        <div class="service-item">
          <div class="index">02</div>
          <h3>Creative Direction</h3>
          <p>We shape the ad message, hook, offer, and landing page content to improve conversion quality.</p>
        </div>
        <div class="service-item">
          <div class="index">03</div>
          <h3>Optimization</h3>
          <p>We monitor, test, and tune campaigns continuously to improve clicks, leads, and return on ad spend.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="detail-section">
    <div class="detail-inner cta-panel">
      <div class="sec-label">Ready to scale</div>
      <h2 class="sec-h" style="margin-bottom:12px;">Your next campaign should <span class="em">convert, not just click.</span></h2>
      <p class="lead" style="max-width:760px;margin:0 auto 26px;">We build ad systems that attract the right people, reduce wasted spend, and turn attention into demand.</p>
      <a href="/contact.php" class="btn-primary">Start a campaign</a>
    </div>
  </section>
</section>

<script>
document.addEventListener('DOMContentLoaded', function(){
  if(typeof gsap==='undefined'||typeof ScrollTrigger==='undefined')return;

  // Process cards stagger
  gsap.utils.toArray('.process-card').forEach(function(card,i){
    gsap.from(card,{
      opacity:0,y:50,scale:.95,duration:.9,delay:i*.12,ease:'power4.out',
      scrollTrigger:{trigger:card,start:'top 88%'}
    });
  });

  // Service list items
  gsap.utils.toArray('.service-item').forEach(function(item,i){
    gsap.from(item,{
      opacity:0,y:40,duration:.8,delay:i*.1,ease:'power3.out',
      scrollTrigger:{trigger:item,start:'top 88%'}
    });
  });

  // Stats
  gsap.utils.toArray('.detail-section .stat').forEach(function(s,i){
    gsap.from(s,{
      opacity:0,y:30,scale:.9,duration:.6,delay:i*.1,ease:'back.out(1.5)',
      scrollTrigger:{trigger:s,start:'top 88%'}
    });
  });

  // CTA panel
  gsap.from('.cta-panel',{
    opacity:0,y:60,scale:.95,duration:1.1,ease:'power4.out',
    scrollTrigger:{trigger:'.cta-panel',start:'top 85%'}
  });
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
