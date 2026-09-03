<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';
$pageTitle  = 'Web Design & Development | Nexos';
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
  .pill-row{display:flex;flex-wrap:wrap;gap:12px;margin-top:28px}
  .pill{padding:8px 16px;border:1px solid var(--border);border-radius:100px;background:rgba(255,255,255,.02);font-size:12px;letter-spacing:1.2px;text-transform:uppercase;color:var(--sub)}
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
  .card,.faq-item,.cta-panel{transform-style:preserve-3d;transition:transform .35s var(--spring),box-shadow .35s var(--spring),border-color .35s ease}
  .card:hover,.faq-item:hover,.cta-panel:hover{transform:translateY(-6px) translateZ(0)}
  @keyframes pulseOrb {0%,100%{transform:scale(1);opacity:.8}50%{transform:scale(1.15);opacity:1}}
  .detail-section{padding:100px 60px;position:relative}
  .detail-inner{max-width:1200px;margin:0 auto}
  .two-col{display:grid;grid-template-columns:1.1fr .9fr;gap:48px;align-items:center}
  .lead{color:var(--sub);font-size:18px;line-height:1.9}
  .cards{display:grid;grid-template-columns:repeat(2,1fr);gap:22px;margin-top:30px}
  .card{padding:28px 22px;border:1px solid var(--border);border-radius:24px;background:rgba(255,255,255,.02);transition:all .35s var(--spring)}
  .card:hover{transform:translateY(-4px);box-shadow:var(--shadow-md)}
  .svc-card-icon{display:flex;align-items:center;justify-content:center;width:44px;height:44px;border-radius:12px;background:rgba(21,101,255,.12);border:1px solid rgba(21,101,255,.2);margin-bottom:14px;transition:all .35s var(--spring)}
  .svc-card-icon svg{width:22px;height:22px;color:var(--blue2)}
  .card:hover .svc-card-icon{background:rgba(21,101,255,.18);transform:scale(1.15) rotate(-6deg)}
  .card h3{font-size:22px;margin-bottom:12px}
  .card p{color:var(--sub);line-height:1.7}
  .faq-wrap{margin-top:36px;border:1px solid var(--border);border-radius:24px;overflow:hidden;background:rgba(255,255,255,.015)}
  .faq-item{padding:24px 26px;border-top:1px solid var(--border)}
  .faq-item:first-child{border-top:none}
  .faq-item h4{font-size:18px;margin-bottom:8px}
  .faq-item p{color:var(--sub);line-height:1.7}
  .cta-panel{padding:70px 30px;border:1px solid var(--border);border-radius:28px;background:linear-gradient(135deg,rgba(21,101,255,.1),rgba(255,255,255,.02));text-align:center;position:relative;overflow:hidden}
  .cta-panel::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.02) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.02) 1px,transparent 1px);background-size:24px 24px;mask-image:radial-gradient(ellipse 80% 80% at 50% 50%,#000 20%,transparent 100%)}
  .cta-panel > *{position:relative;z-index:1}
  @keyframes floatCard {0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
  @media(max-width:980px){
    .detail-hero,.detail-section{padding-left:24px;padding-right:24px}
    .detail-hero-layout,.two-col,.cards{grid-template-columns:1fr}
    .detail-media{height:380px}
  }
</style>

<section class="detail-page">
  <section class="detail-hero">
    <div class="detail-shell">
      <div class="detail-hero-layout">
        <div class="detail-copy reveal-l">
          <div class="page-breadcrumb"><a href="/">Home</a><span>/</span><a href="/services.php">Services</a><span>/</span><span style="color:var(--text)">Web Design &amp; Development</span></div>
          <div class="mini-badge"><span class="badge-dot"></span>Website Design &amp; Development</div>
          <h1 class="sec-h detail-title">Websites built to<br><span class="em gradient">grow your business.</span></h1>
          <p class="detail-sub">Beautiful, fast and conversion-focused websites designed to turn visitors into customers.</p>
          <div class="pill-row">
            <span class="pill">WordPress</span>
            <span class="pill">Custom Development</span>
            <span class="pill">E-commerce</span>
            <span class="pill">UX/UI Design</span>
          </div>
        </div>
        <div class="detail-media reveal-r">
          <div class="mini-orb"></div>
          <div class="svg-orbit" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="12" rx="2"/><path d="M8 20h8M12 16v4"/><path d="M7 8h10M7 11h7"/></svg>
          </div>
          <img src="<?= site_img('svc_web_detail', '/assets/images/svc-web.jpg') ?>" alt="Website design and development" loading="lazy">
          <div class="floating-panel">
            <span class="kicker">Load time</span>
            <strong>1.8s</strong>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="detail-section">
    <div class="detail-inner two-col">
      <div>
        <div class="section-tag">Digital foundations</div>
        <h2 class="section-title">From strategy and UX to development and optimisation.</h2>
        <p class="lead">We build websites around your goals, your customers and where your business is heading.</p>
      </div>
      <div class="cards">
        <div class="card">
          <h3>Website Strategy</h3>
          <p>We understand your business, audience and goals to create the right structure, content and user journey.</p>
        </div>
        <div class="card">
          <h3>UX/UI Design</h3>
          <p>We design clear, intuitive digital experiences that bring clarity and confidence to every decision.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="detail-section" style="background:var(--bg2)">
    <div class="detail-inner">
      <div class="sec-label">Our services</div>
      <h2 class="sec-h">Built for the way your <span class="em">business works.</span></h2>
      <div class="cards">
        <div class="card">
          <h3>WordPress</h3>
          <p>Flexible, scalable WordPress websites designed around your brand, content and business requirements.</p>
        </div>
        <div class="card">
          <h3>Custom Development</h3>
          <p>For more complex requirements, we build tailored digital solutions around your workflows, integrations and business needs.</p>
        </div>
        <div class="card">
          <h3>E-commerce</h3>
          <p>We create smooth online shopping experiences that make products easy to discover and purchases easy to complete.</p>
        </div>
        <div class="card">
          <h3>Portfolio &amp; Launch</h3>
          <p>We help you present your work beautifully and ensure your site is optimised for real business growth.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="detail-section">
    <div class="detail-inner">
      <div class="sec-label">FAQ</div>
      <h2 class="sec-h">Frequently asked <span class="em">questions</span></h2>
      <div class="faq-wrap">
        <div class="faq-item">
          <h4>Do you build WordPress websites?</h4>
          <p>Yes. We build flexible WordPress websites that are easy to manage, update and scale as your business grows.</p>
        </div>
        <div class="faq-item">
          <h4>Can you redesign my existing website?</h4>
          <p>Absolutely. We can modernise the structure, design and UX to better meet your current business goals.</p>
        </div>
        <div class="faq-item">
          <h4>Can you build an e-commerce website?</h4>
          <p>Yes. We design and build storefronts that are clear, conversion-focused and built for long-term growth.</p>
        </div>
        <div class="faq-item">
          <h4>How long does a website project take?</h4>
          <p>Timelines depend on scope, but many projects are completed in several weeks with a clear delivery plan.</p>
        </div>
        <div class="faq-item">
          <h4>Do you provide support after launch?</h4>
          <p>Yes. We offer launch support and ongoing updates so your website continues to perform after go-live.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="detail-section" style="background:var(--bg2)">
    <div class="detail-inner cta-panel">
      <div class="sec-label">Ready to build</div>
      <h2 class="sec-h" style="margin-bottom:12px;">Ready to build a <span class="em">stronger digital presence?</span></h2>
      <p class="lead" style="max-width:760px;margin:0 auto 26px;">Your website should work as hard as your business does. We build digital experiences designed to convert.</p>
      <a href="/contact.php" class="btn-primary">Start your project</a>
    </div>
  </section>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
