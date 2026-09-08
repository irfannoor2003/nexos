<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';
$pageTitle  = 'SEO Optimization | Nexos';
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
  .detail-sub{max-width:740px;color:var(--sub);font-size:18px;line-height:1.8}
  .mini-badge{display:inline-flex;align-items:center;gap:8px;padding:8px 18px;border:1px solid var(--border);border-radius:100px;background:rgba(255,255,255,.04);font-size:10px;letter-spacing:1.4px;text-transform:uppercase;color:var(--sub);margin-bottom:24px}
  .pill-row{display:flex;flex-wrap:wrap;gap:12px;margin-top:28px}
  .pill{padding:8px 16px;border:1px solid var(--border);border-radius:100px;background:rgba(255,255,255,.02);font-size:12px;letter-spacing:1.2px;text-transform:uppercase;color:var(--sub)}
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
  .detail-stat,.process-card,.service-item,.quote-box,.detail-card,.card,.benefit-box,.cta-panel{transform-style:preserve-3d;transition:transform .35s var(--spring),box-shadow .35s var(--spring),border-color .35s ease}
  .detail-stat:hover,.process-card:hover,.service-item:hover,.quote-box:hover,.detail-card:hover,.card:hover,.benefit-box:hover,.cta-panel:hover{transform:translateY(-6px) translateZ(0)}
  @keyframes pulseOrb {0%,100%{transform:scale(1);opacity:.8}50%{transform:scale(1.15);opacity:1}}
  .detail-section{padding:100px 60px;position:relative}
  .detail-inner{max-width:1200px;margin:0 auto}
  .two-col{display:grid;grid-template-columns:1.1fr .9fr;gap:48px;align-items:center}
  .lead{color:var(--sub);font-size:18px;line-height:1.9}
  .stats{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-top:44px}
  .stat{padding:24px 20px;border:1px solid var(--border);border-radius:22px;background:rgba(255,255,255,.02);transition:all .35s var(--spring)}
  .stat:hover{transform:translateY(-4px); box-shadow:var(--shadow-md)}
  .stat .kicker{display:block;font-size:11px;letter-spacing:1.2px;text-transform:uppercase;color:var(--sub);margin-bottom:12px}
  .stat strong{font-size:30px;font-family:var(--font-h)}
  .process-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-top:34px}
  .process-card{padding:28px 22px;border:1px solid var(--border);border-radius:24px;background:rgba(255,255,255,.02);transition:all .35s var(--spring)}
  .process-card:hover{transform:translateY(-7px);box-shadow:var(--shadow-md)}
  .process-card .num{display:inline-flex;align-items:center;justify-content:center;min-width:48px;height:48px;border-radius:14px;background:rgba(21,101,255,.12);border:1px solid rgba(21,101,255,.2);font-size:18px;font-weight:700;margin-bottom:20px}
  .process-card h3{font-size:20px;margin-bottom:10px}
  .process-card p{color:var(--sub);line-height:1.7}
  .service-list{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-top:28px}
  .process-card-icon{display:inline-flex;align-items:center;justify-content:center;width:44px;height:44px;border-radius:12px;background:rgba(21,101,255,.12);border:1px solid rgba(21,101,255,.2);margin-bottom:14px;transition:all .35s var(--spring)}
  .process-card-icon svg{width:22px;height:22px;color:var(--blue2)}
  .process-card:hover .process-card-icon{background:rgba(21,101,255,.18);transform:scale(1.15) rotate(-6deg)}
  .service-item li::before{content:'✓';position:absolute;left:0;top:0;color:var(--blue2);font-weight:700;font-size:14px}
  .service-item{padding:26px 22px;border:1px solid var(--border);border-radius:22px;background:rgba(255,255,255,.02);transition:all .35s var(--spring)}
  .service-item:hover{transform:translateY(-4px);box-shadow:var(--shadow-md)}
  .service-item h4{margin-bottom:12px;font-size:20px}
  .service-item ul{list-style:none;display:flex;flex-direction:column;gap:10px;color:var(--sub)}
  .service-item li{position:relative;padding-left:18px}
  .process-card-icon{display:inline-flex;align-items:center;justify-content:center;width:44px;height:44px;border-radius:12px;background:rgba(21,101,255,.12);border:1px solid rgba(21,101,255,.2);margin-bottom:14px;transition:all .35s var(--spring)}
  .process-card-icon svg{width:22px;height:22px;color:var(--blue2)}
  .process-card:hover .process-card-icon{background:rgba(21,101,255,.18);transform:scale(1.15) rotate(-6deg)}
  .service-item li::before{content:'✓';position:absolute;left:0;top:0;color:var(--blue2);font-weight:700;font-size:14px}
  .cta-panel{padding:70px 30px;border:1px solid var(--border);border-radius:28px;background:linear-gradient(135deg,rgba(21,101,255,.1),rgba(255,255,255,.02));text-align:center;position:relative;overflow:hidden}
  .cta-panel::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.02) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.02) 1px,transparent 1px);background-size:24px 24px;mask-image:radial-gradient(ellipse 80% 80% at 50% 50%,#000 20%,transparent 100%)}
  .cta-panel > *{position:relative;z-index:1}
  @keyframes floatCard {0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
  @media(max-width:980px){
    .detail-hero,.detail-section{padding-left:24px;padding-right:24px}
    .detail-hero-layout,.two-col,.process-grid,.service-list,.stats{grid-template-columns:1fr}
    .detail-media{height:380px}
  }
</style>

<section class="detail-page">
  <section class="detail-hero">
    <div class="detail-shell">
      <div class="detail-hero-layout">
        <div class="detail-copy reveal-l">
          <div class="page-breadcrumb"><a href="/">Home</a><span>/</span><a href="/services.php">Services</a><span>/</span><span style="color:var(--text)">SEO Optimization</span></div>
          <div class="mini-badge"><span class="badge-dot"></span>Search Engine Growth</div>
          <h1 class="sec-h detail-title">Turn rankings into <span class="em gradient">real revenue.</span></h1>
          <p class="detail-sub">We help your business get found by the people already looking for your services and convert that traffic into leads, bookings, and sales.</p>
          <div class="stats">
            <div class="stat"><span class="kicker">Strategy</span><strong>Audit</strong></div>
            <div class="stat"><span class="kicker">Target</span><strong>Traffic</strong></div>
            <div class="stat"><span class="kicker">Result</span><strong>Growth</strong></div>
          </div>
        </div>
        <div class="detail-media reveal-r">
          <div class="mini-orb"></div>
          <img src="<?= site_img('svc_seo_detail', '/assets/images/svc-seo.jpg') ?>" alt="SEO strategy dashboard" loading="lazy">
          <div class="floating-panel">
            <span class="kicker">Growth</span>
            <strong>+182%</strong>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="detail-section">
    <div class="detail-inner two-col">
      <div>
        <div class="sec-label">Why it matters</div>
        <h2 class="sec-h">Most businesses are not <span class="em">ranking because they do not have a system.</span></h2>
        <p class="lead">Ranking high on search engines is not just about keywords. It is about technical health, content quality, authority, and a strategy built to attract real buyer intent.</p>
      </div>
      <div class="service-item" style="height:100%">
        <h4>What we focus on</h4>
        <ul>
          <li>Technical SEO improvements</li>
          <li>Page optimization for conversion</li>
          <li>Keyword and competitor analysis</li>
          <li>Authority and backlink strategy</li>
          <li>Local SEO for lead generation</li>
        </ul>
      </div>
    </div>
  </section>

  <section class="detail-section" style="background:var(--bg2)">
    <div class="detail-inner">
      <div class="sec-label">Our process</div>
      <h2 class="sec-h">A clean SEO system built for <span class="em">lasting visibility.</span></h2>
      <div class="process-grid">
        <div class="process-card">
          <div class="num">01</div>
          <h3>Audit</h3>
          <p>We review technical issues, indexing gaps, rankings, and site structure.</p>
        </div>
        <div class="process-card">
          <div class="num">02</div>
          <h3>Research</h3>
          <p>We identify the keywords and intent that matter most to your business.</p>
        </div>
        <div class="process-card">
          <div class="num">03</div>
          <h3>Optimize</h3>
          <p>We improve pages, content, metadata, site speed, and user experience.</p>
        </div>
        <div class="process-card">
          <div class="num">04</div>
          <h3>Scale</h3>
          <p>We strengthen authority and track ranking growth with measurable reporting.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="detail-section">
    <div class="detail-inner">
      <div class="sec-label">What we do</div>
      <h2 class="sec-h">SEO that supports your <span class="em">whole funnel.</span></h2>
      <div class="service-list">
        <div class="service-item">
          <h4>Technical SEO</h4>
          <ul>
            <li>Core Web Vitals improvement</li>
            <li>Structured site architecture</li>
            <li>Indexing and crawlability fixes</li>
            <li>Schema and metadata optimisation</li>
          </ul>
        </div>
        <div class="service-item">
          <h4>On-Page SEO</h4>
          <ul>
            <li>Title and meta optimization</li>
            <li>Internal linking strategy</li>
            <li>Content cluster planning</li>
            <li>Landing page refinement</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <section class="detail-section" style="background:var(--bg2)">
    <div class="detail-inner cta-panel">
      <div class="sec-label">Ready to rank</div>
      <h2 class="sec-h" style="margin-bottom:12px;">Ready to get found by <span class="em">the right buyers?</span></h2>
      <p class="lead" style="max-width:760px;margin:0 auto 26px;">Your next customer is already searching. We make sure your business shows up in the right place at the right time.</p>
      <a href="/contact.php" class="btn-primary">Book a strategy call</a>
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
