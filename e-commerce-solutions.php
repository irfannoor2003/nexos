<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';
$pageTitle  = 'E-Commerce Solutions | Nexos';
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
  .detail-sub{max-width:760px;color:var(--sub);font-size:18px;line-height:1.8}
  .mini-badge{display:inline-flex;align-items:center;gap:8px;padding:8px 18px;border:1px solid var(--border);border-radius:100px;background:rgba(255,255,255,.04);font-size:10px;letter-spacing:1.4px;text-transform:uppercase;color:var(--sub);margin-bottom:24px}
  .stats{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-top:44px}
  .stat{padding:24px 20px;border:1px solid var(--border);border-radius:22px;background:rgba(255,255,255,.02);transition:all .35s var(--spring)}
  .stat:hover{transform:translateY(-4px);box-shadow:var(--shadow-md)}
  .stat .kicker{display:block;font-size:11px;letter-spacing:1.2px;text-transform:uppercase;color:var(--sub);margin-bottom:12px}
  .stat strong{font-size:30px;font-family:var(--font-h)}
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
  .detail-card,.service-item,.process-card,.quote-box,.benefit-box,.cta-panel{transform-style:preserve-3d;transition:transform .35s var(--spring),box-shadow .35s var(--spring),border-color .35s ease}
  .detail-card:hover,.service-item:hover,.process-card:hover,.quote-box:hover,.benefit-box:hover,.cta-panel:hover{transform:translateY(-6px) translateZ(0)}
  @keyframes pulseOrb {0%,100%{transform:scale(1);opacity:.8}50%{transform:scale(1.15);opacity:1}}
  .detail-section{padding:100px 60px;position:relative}
  .detail-inner{max-width:1200px;margin:0 auto}
  .two-col{display:grid;grid-template-columns:1.1fr .9fr;gap:48px;align-items:center}
  .lead{color:var(--sub);font-size:18px;line-height:1.9}
  .feature-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-top:28px}
  .feature-card{padding:28px 22px;border:1px solid var(--border);border-radius:24px;background:rgba(255,255,255,.02);transition:all .35s var(--spring)}
  .feature-card:hover{transform:translateY(-4px);box-shadow:var(--shadow-md)}
  .feature-card h3{font-size:20px;margin-bottom:10px}
  .feature-card p{color:var(--sub);line-height:1.7}
  .process-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-top:34px}
  .process-card-icon{display:inline-flex;align-items:center;justify-content:center;width:44px;height:44px;border-radius:12px;background:rgba(21,101,255,.12);border:1px solid rgba(21,101,255,.2);margin-bottom:14px;transition:all .35s var(--spring)}
  .process-card-icon svg{width:22px;height:22px;color:var(--blue2)}
  .process-card:hover .process-card-icon{background:rgba(21,101,255,.18);transform:scale(1.15) rotate(-6deg)}
  .process-card{padding:28px 22px;border:1px solid var(--border);border-radius:24px;background:rgba(255,255,255,.02);transition:all .35s var(--spring)}
  .process-card:hover{transform:translateY(-7px);box-shadow:var(--shadow-md)}
  .process-card .num{display:inline-flex;align-items:center;justify-content:center;min-width:48px;height:48px;border-radius:14px;background:rgba(21,101,255,.12);border:1px solid rgba(21,101,255,.2);font-size:18px;font-weight:700;margin-bottom:20px}
  .process-card h3{font-size:20px;margin-bottom:10px}
  .process-card p{color:var(--sub);line-height:1.7}
  .cta-panel{padding:70px 30px;border:1px solid var(--border);border-radius:28px;background:linear-gradient(135deg,rgba(21,101,255,.1),rgba(255,255,255,.02));text-align:center;position:relative;overflow:hidden}
  .cta-panel::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.02) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.02) 1px,transparent 1px);background-size:24px 24px;mask-image:radial-gradient(ellipse 80% 80% at 50% 50%,#000 20%,transparent 100%)}
  .cta-panel > *{position:relative;z-index:1}
  .process-card-icon{display:inline-flex;align-items:center;justify-content:center;width:44px;height:44px;border-radius:12px;background:rgba(21,101,255,.12);border:1px solid rgba(21,101,255,.2);margin-bottom:14px;transition:all .35s var(--spring)}
  .process-card-icon svg{width:22px;height:22px;color:var(--blue2)}
  .process-card:hover .process-card-icon{background:rgba(21,101,255,.18);transform:scale(1.15) rotate(-6deg)}
  @media(max-width:980px){
    .detail-hero,.detail-section{padding-left:24px;padding-right:24px}
    .detail-hero-layout,.two-col,.feature-grid,.process-grid,.stats{grid-template-columns:1fr}
    .detail-media{height:380px}
  }
</style>

<section class="detail-page">
  <section class="detail-hero">
    <div class="detail-shell">
      <div class="detail-hero-layout">
        <div class="detail-copy reveal-l">
          <div class="page-breadcrumb"><a href="/">Home</a><span>/</span><a href="/services.php">Services</a><span>/</span><span style="color:var(--text)">E-Commerce Solutions</span></div>
          <div class="mini-badge">Storefront Growth</div>
          <h1 class="sec-h detail-title">Build a storefront that <span class="em gradient">sells every day.</span></h1>
          <p class="detail-sub">We design and optimize ecommerce experiences that make product discovery easy, buying frictionless, and customer retention stronger over time.</p>
          <div class="stats">
            <div class="stat"><span class="kicker">Focus</span><strong>UX</strong></div>
            <div class="stat"><span class="kicker">Stack</span><strong>Shopify</strong></div>
            <div class="stat"><span class="kicker">Goal</span><strong>Sales</strong></div>
          </div>
        </div>
        <div class="detail-media reveal-r">
          <div class="mini-orb"></div>
          <div class="svg-orbit" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 2L6 6H3a2 2 0 00-2 2v12a2 2 0 002 2h18a2 2 0 002-2V8a2 2 0 00-2-2h-3l-3-4z" /><circle cx="12" cy="15" r="3.5"/></svg>
          </div>
          <img src="<?= site_img('svc_ecom_detail', '/assets/images/svc-ecom.jpg') ?>" alt="E-commerce store optimization" loading="lazy">
          <div class="floating-panel">
            <span class="kicker">Cart</span>
            <strong>+29%</strong>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="detail-section">
    <div class="detail-inner two-col">
      <div>
        <div class="sec-label">Why it matters</div>
        <h2 class="sec-h">Your store should feel as <span class="em">premium as the products you sell.</span></h2>
        <p class="lead">A strong ecommerce experience does not just display products. It guides customer intent, removes hesitation, and makes checkout feel effortless from first click to final order.</p>
      </div>
      <div class="feature-card">
        <h3>Built for conversion</h3>
        <p>We design product flows, messaging, and buying journeys around trust, clarity, and urgency so your store converts more visitors into paying customers.</p>
      </div>
    </div>
  </section>

  <section class="detail-section" style="background:var(--bg2)">
    <div class="detail-inner">
      <div class="sec-label">Our approach</div>
      <h2 class="sec-h">From product launch to checkout, we improve <span class="em">every step.</span></h2>
      <div class="process-grid">
        <div class="process-card">
          <div class="num">01</div>
          <h3>Plan</h3>
          <p>We map the buying journey and identify friction points in the funnel.</p>
        </div>
        <div class="process-card">
          <div class="num">02</div>
          <h3>Design</h3>
          <p>We shape the storefront structure, categories, and product messaging for clarity.</p>
        </div>
        <div class="process-card">
          <div class="num">03</div>
          <h3>Build</h3>
          <p>We implement a fast, mobile-ready store that supports growth and scalability.</p>
        </div>
        <div class="process-card">
          <div class="num">04</div>
          <h3>Optimize</h3>
          <p>We refine conversion strategy, cart flow, and customer retention systems over time.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="detail-section">
    <div class="detail-inner">
      <div class="sec-label">What we deliver</div>
      <h2 class="sec-h">Everything needed to grow your <span class="em">online store.</span></h2>
      <div class="feature-grid">
        <div class="feature-card">
          <h3>Store Design</h3>
          <p>Modern storefronts built to look premium, feel intuitive, and help customers buy quickly.</p>
        </div>
        <div class="feature-card">
          <h3>Product Pages</h3>
          <p>Clear product layouts, persuasive content, and stronger buyer confidence for better conversion.</p>
        </div>
        <div class="feature-card">
          <h3>Marketplace Growth</h3>
          <p>Support for Amazon, Daraz, and other sales channels with a strategy aligned to your business model.</p>
        </div>
        <div class="feature-card">
          <h3>CRO & Retention</h3>
          <p>Optimization beyond the first click, including cart flow improvement and repeat purchase systems.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="detail-section" style="background:var(--bg2)">
    <div class="detail-inner cta-panel">
      <div class="sec-label">Ready to sell smarter</div>
      <h2 class="sec-h" style="margin-bottom:12px;">Create an ecommerce experience that <span class="em">drives revenue.</span></h2>
      <p class="lead" style="max-width:760px;margin:0 auto 26px;">A well-built store does not just look good—it creates momentum, confidence, and repeat sales. We help you turn that into growth.</p>
      <a href="/contact.php" class="btn-primary">Talk to us</a>
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
