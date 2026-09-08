<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';
$pageTitle  = 'Portfolio | Nexos Digital Marketing Agency';
$activePage = 'portfolio';
include __DIR__ . '/includes/header.php';
?>
<style>
/* HERO */
.port-hero{position:relative;padding:170px 64px 110px;overflow:hidden;background:var(--bg)}
.port-hero-bg{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.025) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.025) 1px,transparent 1px);background-size:80px 80px;mask-image:radial-gradient(ellipse 80% 80% at 50% 40%,#000 30%,transparent 100%)}
.port-hero-glow{position:absolute;width:700px;height:700px;background:radial-gradient(circle,rgba(255,255,255,.03) 0%,transparent 70%);top:-250px;right:-150px;animation:breathe 10s ease-in-out infinite}
.port-hero-content{position:relative;z-index:2;max-width:900px}
.port-breadcrumb{font-family:var(--font-h);font-size:12px;color:var(--sub);margin-bottom:16px;display:flex;align-items:center;gap:8px;opacity:0;animation:fadeUp .8s .1s var(--premium) forwards}
.port-breadcrumb a{color:var(--sub);text-decoration:none;transition:color .2s}
.port-breadcrumb a:hover{color:var(--text)}
.port-hero-badge{display:inline-flex;align-items:center;gap:8px;font-family:var(--font-h);font-size:11px;font-weight:600;color:var(--sub);background:rgba(255,255,255,.03);border:1px solid var(--border);padding:7px 18px;border-radius:100px;margin-bottom:20px;letter-spacing:.5px;text-transform:uppercase;opacity:0;animation:fadeUp .8s .18s var(--premium) forwards}
.port-hero-h1{font-family:var(--font-h);font-size:clamp(38px,5vw,68px);font-weight:800;line-height:1.08;color:var(--text);letter-spacing:-2px;margin-bottom:22px;opacity:0;animation:fadeUp .8s .26s var(--premium) forwards}
.port-hero-h1 .em{background:linear-gradient(135deg,var(--blue),var(--blue2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.port-hero-desc{font-size:17px;color:var(--sub);line-height:1.9;max-width:640px;opacity:0;animation:fadeUp .8s .34s var(--premium) forwards}

/* SHOWCASE */
.port-showcase{position:relative;background:var(--bg);border-top:1px solid var(--border)}
.port-showcase-inner{display:flex;min-height:100vh}
.port-viewer{position:sticky;top:0;width:55%;height:100vh;overflow:hidden;flex-shrink:0}
.port-media{position:absolute;inset:0;opacity:0;transition:opacity .6s ease;pointer-events:none}
.port-media.active{opacity:1}
.port-media img,.port-media video{width:100%;height:100%;object-fit:cover}
.port-media-overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(5,5,8,.6),transparent 50%)}
.port-counter{position:absolute;bottom:40px;left:40px;z-index:3;font-family:var(--font-h);font-size:64px;font-weight:800;color:rgba(255,255,255,.06);line-height:1;letter-spacing:-3px}
.port-counter span{color:rgba(255,255,255,.3);font-size:32px}
.port-counter .current{color:rgba(255,255,255,.8)}
.port-list{width:45%;padding:0 60px 0 50px;display:flex;flex-direction:column;justify-content:center}
.port-item{min-height:100vh;display:flex;flex-direction:column;justify-content:center;padding:60px 0;border-bottom:1px solid var(--border);opacity:.3;transition:opacity .5s ease}
.port-item.active{opacity:1}
.port-item:last-child{border-bottom:none}
.port-number{font-family:var(--font-h);font-size:14px;font-weight:700;color:var(--sub);letter-spacing:2px;margin-bottom:16px}
.port-category{display:inline-flex;font-family:var(--font-h);font-size:10px;font-weight:600;color:var(--sub);background:rgba(255,255,255,.03);border:1px solid var(--border);padding:4px 12px;border-radius:100px;letter-spacing:.5px;text-transform:uppercase;margin-bottom:20px;width:fit-content}
.port-item-title{font-family:var(--font-h);font-size:clamp(24px,2.8vw,38px);font-weight:800;color:var(--text);line-height:1.15;letter-spacing:-1px;margin-bottom:16px}
.port-item-desc{font-size:15px;color:var(--sub);line-height:1.85;margin-bottom:20px;max-width:480px}
.port-item-tags{display:flex;flex-wrap:wrap;gap:6px}
.port-item-tags span{font-family:var(--font-h);font-size:11px;color:var(--sub);background:rgba(255,255,255,.03);border:1px solid var(--border);padding:4px 12px;border-radius:100px}
.port-item-link{display:inline-flex;align-items:center;gap:8px;font-family:var(--font-h);font-size:13px;font-weight:600;color:var(--text);text-decoration:none;margin-top:24px;transition:gap .3s var(--spring)}
.port-item-link:hover{gap:14px}
.port-item-link svg{width:16px;height:16px}

/* PROJECTS GRID (after showcase) */
.port-grid-sec{padding:110px 64px;position:relative;background:var(--bg2)}
.port-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:60px}
.port-grid-card{background:var(--card);border:1px solid var(--border);border-radius:var(--r-xl);overflow:hidden;transition:all .4s var(--spring);transform-style:preserve-3d}
.port-grid-card:hover{border-color:var(--border);box-shadow:0 4px 20px rgba(0,0,0,.2)}
.port-grid-img{width:100%;height:220px;overflow:hidden}
.port-grid-img img{width:100%;height:100%;object-fit:cover;transition:transform .6s var(--ease)}
.port-grid-card:hover .port-grid-img img{transform:scale(1.08)}
.port-grid-body{padding:24px 24px 28px}
.port-grid-tag{font-family:var(--font-h);font-size:10px;font-weight:600;color:var(--sub);background:rgba(255,255,255,.03);border:1px solid var(--border);padding:3px 10px;border-radius:100px;display:inline-block;margin-bottom:10px;letter-spacing:.3px;text-transform:uppercase}
.port-grid-title{font-family:var(--font-h);font-size:16px;font-weight:700;color:var(--text);margin-bottom:8px;line-height:1.3}
.port-grid-desc{font-size:13px;color:var(--sub);line-height:1.7}

/* CTA */
.port-cta{background:var(--bg);border-top:1px solid var(--border);padding:120px 64px;text-align:center;position:relative;overflow:hidden}
.port-cta-bg{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.015) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.015) 1px,transparent 1px);background-size:60px 60px;pointer-events:none}
.port-cta-orb{position:absolute;width:500px;height:500px;background:radial-gradient(circle,rgba(255,255,255,.02) 0%,transparent 70%);top:-150px;right:-100px;pointer-events:none}
.port-cta-content{position:relative;z-index:2;max-width:640px;margin:0 auto}
.port-cta-h2{font-family:var(--font-h);font-size:clamp(32px,4vw,52px);font-weight:800;color:var(--text);line-height:1.12;letter-spacing:-1.5px;margin-bottom:18px}
.port-cta-p{font-size:16px;color:var(--sub);line-height:1.8;margin-bottom:36px}

@media(max-width:1024px){
  .port-showcase-inner{flex-direction:column}
  .port-viewer{position:relative;width:100%;height:50vh;top:auto}
  .port-list{width:100%;padding:40px 24px}
  .port-item{min-height:auto;padding:40px 0}
  .port-counter{bottom:20px;left:20px;font-size:40px}
}
@media(max-width:768px){
  .port-hero{padding:140px 24px 80px}
  .port-grid{grid-template-columns:1fr}
  .port-cta{padding:80px 24px}
}
</style>

<!-- HERO -->
<section class="port-hero">
  <div class="port-hero-bg"></div>
  <div class="port-hero-glow"></div>
  <div class="port-hero-content">
    <div class="port-breadcrumb"><a href="/">Home</a><span>/</span><span style="color:var(--text)">Portfolio</span></div>
    <div class="port-hero-badge">Our Work</div>
    <h1 class="port-hero-h1">Projects We're <span class="em">Proud Of.</span></h1>
    <p class="port-hero-desc">Real campaigns, real results. Every project we deliver is crafted with precision, data, and creative fire — built to move metrics and make an impact.</p>
  </div>
</section>

<!-- STICKY SHOWCASE -->
<section class="port-showcase" id="portShowcase">
  <div class="port-showcase-inner">
    <!-- Sticky Viewer -->
    <div class="port-viewer" id="portViewer">
      <div class="port-media active" data-index="0">
        <img src="<?= site_img('port_showcase_1', '/assets/images/svc-seo.jpg') ?>" alt="E-Commerce SEO Campaign" loading="lazy">
        <div class="port-media-overlay"></div>
      </div>
      <div class="port-media" data-index="1">
        <img src="<?= site_img('port_showcase_2', '/assets/images/svc-ads.jpg') ?>" alt="Google Ads Strategy" loading="lazy">
        <div class="port-media-overlay"></div>
      </div>
      <div class="port-media" data-index="2">
        <img src="<?= site_img('port_showcase_3', '/assets/images/svc-web.jpg') ?>" alt="Web Design &amp; Development" loading="lazy">
        <div class="port-media-overlay"></div>
      </div>
      <div class="port-media" data-index="3">
        <img src="<?= site_img('port_showcase_4', '/assets/images/svc-social.jpg') ?>" alt="Social Media Marketing" loading="lazy">
        <div class="port-media-overlay"></div>
      </div>
      <div class="port-media" data-index="4">
        <img src="<?= site_img('port_showcase_5', '/assets/images/svc-brand.jpg') ?>" alt="Brand Identity" loading="lazy">
        <div class="port-media-overlay"></div>
      </div>
      <div class="port-media" data-index="5">
        <img src="<?= site_img('port_showcase_6', '/assets/images/svc-ai.jpg') ?>" alt="AI Automation" loading="lazy">
        <div class="port-media-overlay"></div>
      </div>
      <div class="port-counter"><span class="current" id="portCurrent">01</span><span> / 06</span></div>
    </div>

    <!-- Project List -->
    <div class="port-list" id="portList">
      <div class="port-item active" data-index="0">
        <div class="port-number">01</div>
        <div class="port-category">SEO &amp; Organic Growth</div>
        <h2 class="port-item-title">E-Commerce SEO Overhaul</h2>
        <p class="port-item-desc">A complete SEO transformation for a Lahore-based fashion e-com brand — 340% organic traffic increase, 280% revenue growth, and top-3 rankings for 40+ high-intent keywords within 6 months.</p>
        <div class="port-item-tags"><span>Technical SEO</span><span>Content Strategy</span><span>Link Building</span><span>GA4</span></div>
        <a href="#" class="port-item-link">View Case Study <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
      </div>

      <div class="port-item" data-index="1">
        <div class="port-number">02</div>
        <div class="port-category">Paid Advertising</div>
        <h2 class="port-item-title">Google Ads ROI Engine</h2>
        <p class="port-item-desc">Scaled a SaaS client from $12k to $84k monthly ad spend while maintaining sub-3x ROAS. Smart bidding, audience layering, and relentless creative testing delivered a 6.2x average return.</p>
        <div class="port-item-tags"><span>Google Ads</span><span>Meta Ads</span><span>Conversion Tracking</span><span>A/B Testing</span></div>
        <a href="#" class="port-item-link">View Case Study <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
      </div>

      <div class="port-item" data-index="2">
        <div class="port-number">03</div>
        <div class="port-category">Web Design &amp; Development</div>
        <h2 class="port-item-title">Custom Web Platform</h2>
        <p class="port-item-desc">Designed and developed a high-performance Next.js platform for a real estate startup. 98 Lighthouse score, sub-second load times, and a 52% increase in lead conversion within the first quarter.</p>
        <div class="port-item-tags"><span>UX/UI Design</span><span>Next.js</span><span>Tailwind</span><span>CMS Integration</span></div>
        <a href="#" class="port-item-link">View Case Study <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
      </div>

      <div class="port-item" data-index="3">
        <div class="port-number">04</div>
        <div class="port-category">Social Media Marketing</div>
        <h2 class="port-item-title">Social-First Brand Launch</h2>
        <p class="port-item-desc">From zero to 150k followers in 5 months for a D2C wellness brand. Organic content strategy, influencer collaborations, and paid social synergised to drive a 4x ROAS on Meta.</p>
        <div class="port-item-tags"><span>Meta Ads</span><span>TikTok</span><span>Content Strategy</span><span>Influencer Marketing</span></div>
        <a href="#" class="port-item-link">View Case Study <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
      </div>

      <div class="port-item" data-index="4">
        <div class="port-number">05</div>
        <div class="port-category">Brand Identity</div>
        <h2 class="port-item-title">Complete Brand Overhaul</h2>
        <p class="port-item-desc">A full rebrand for a fintech startup — logo, typography, colour system, stationery, and digital assets. The new identity drove a 94% brand recall score and a successful Series A raise.</p>
        <div class="port-item-tags"><span>Logo Design</span><span>Brand Guidelines</span><span>Typography</span><span>Packaging</span></div>
        <a href="#" class="port-item-link">View Case Study <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
      </div>

      <div class="port-item" data-index="5">
        <div class="port-number">06</div>
        <div class="port-category">AI &amp; Automation</div>
        <h2 class="port-item-title">AI-Powered Workflow</h2>
        <p class="port-item-desc">Built custom AI automation pipelines for a logistics company — automated invoice processing, customer query triage, and route optimisation. Saved 1,200+ human hours monthly and reduced errors by 94%.</p>
        <div class="port-item-tags"><span>AI Agents</span><span>Workflow Automation</span><span>API Integration</span><span>LLMs</span></div>
        <a href="#" class="port-item-link">View Case Study <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
      </div>
    </div>
  </div>
</section>

<!-- PROJECTS GRID -->
<section class="port-grid-sec">
  <div class="sec-center reveal">
    <div class="sec-label">More Work</div>
    <h2 class="sec-h">Recent <span class="em">Projects</span></h2>
    <p class="sec-sub">A selection of recent campaigns and builds we're especially proud of.</p>
  </div>
  <div class="port-grid stagger-grid">
    <div class="port-grid-card reveal shimmer-card">
      <div class="port-grid-img"><img src="<?= site_img('port_grid_1', '/assets/images/svc-design.jpg') ?>" alt="Project" loading="lazy"></div>
      <div class="port-grid-body">
        <div class="port-grid-tag">Web Design</div>
        <div class="port-grid-title">Luxury Hotel Booking Platform</div>
        <div class="port-grid-desc">Full-stack booking engine with real-time availability, payment integration, and admin dashboard.</div>
      </div>
    </div>
    <div class="port-grid-card reveal shimmer-card">
      <div class="port-grid-img"><img src="<?= site_img('port_grid_2', '/assets/images/svc-dashboard.jpg') ?>" alt="Project" loading="lazy"></div>
      <div class="port-grid-body">
        <div class="port-grid-tag">SEO</div>
        <div class="port-grid-title">National Retail Chain SEO</div>
        <div class="port-grid-desc">Multi-location local SEO strategy driving 12,000+ monthly organic leads across 18 cities.</div>
      </div>
    </div>
    <div class="port-grid-card reveal shimmer-card">
      <div class="port-grid-img"><img src="<?= site_img('port_grid_3', '/assets/images/svc-brand.jpg') ?>" alt="Project" loading="lazy"></div>
      <div class="port-grid-body">
        <div class="port-grid-tag">Brand Identity</div>
        <div class="port-grid-title">HealthTech Startup Rebrand</div>
        <div class="port-grid-desc">Complete visual identity overhaul for a Series A health-tech company entering new markets.</div>
      </div>
    </div>
    <div class="port-grid-card reveal shimmer-card">
      <div class="port-grid-img"><img src="<?= site_img('port_grid_4', '/assets/images/svc-perf.jpg') ?>" alt="Project" loading="lazy"></div>
      <div class="port-grid-body">
        <div class="port-grid-tag">Paid Ads</div>
        <div class="port-grid-title">E-Commerce Scaling Campaign</div>
        <div class="port-grid-desc">Scaled monthly ad spend from $8k to $60k while maintaining sub-3x blended ROAS target.</div>
      </div>
    </div>
    <div class="port-grid-card reveal shimmer-card">
      <div class="port-grid-img"><img src="<?= site_img('port_grid_5', '/assets/images/svc-ai.jpg') ?>" alt="Project" loading="lazy"></div>
      <div class="port-grid-body">
        <div class="port-grid-tag">AI Automation</div>
        <div class="port-grid-title">Automated Customer Support</div>
        <div class="port-grid-desc">AI chatbot + workflow automation handling 85% of L1 support queries for a SaaS platform.</div>
      </div>
    </div>
    <div class="port-grid-card reveal shimmer-card">
      <div class="port-grid-img"><img src="<?= site_img('port_grid_6', '/assets/images/svc-social.jpg') ?>" alt="Project" loading="lazy"></div>
      <div class="port-grid-body">
        <div class="port-grid-tag">Social Media</div>
        <div class="port-grid-title">Viral Campaign for D2C Brand</div>
        <div class="port-grid-desc">Organic + paid social strategy that generated 12M+ impressions and 150k new followers.</div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="port-cta">
  <div class="port-cta-bg"></div>
  <div class="port-cta-orb"></div>
  <div class="port-cta-content reveal">
    <h2 class="port-cta-h2">Let's Build Something <span class="em">Remarkable.</span></h2>
    <p class="port-cta-p">Your next success story starts here. Tell us about your project, and we'll craft a strategy that actually moves the needle.</p>
    <a href="/contact.php" class="btn-primary">Start Your Project →</a>
  </div>
</section>

<script>
/* STICKY SCROLL SHOWCASE - GSAP */
gsap.registerPlugin(ScrollTrigger);
(function(){
  var viewer=document.getElementById('portViewer');
  var list=document.getElementById('portList');
  if(!viewer||!list)return;
  var items=list.querySelectorAll('.port-item');
  var medias=viewer.querySelectorAll('.port-media');
  var counter=document.getElementById('portCurrent');
  var videos=viewer.querySelectorAll('video');

  items.forEach(function(item){
    ScrollTrigger.create({
      trigger:item,
      start:'top 40%',
      end:'bottom 40%',
      onEnter:function(){setActive(item.dataset.index)},
      onEnterBack:function(){setActive(item.dataset.index)}
    });
  });

  function setActive(idx){
    medias.forEach(function(m){m.classList.toggle('active',m.dataset.index===idx)});
    items.forEach(function(it){it.classList.toggle('active',it.dataset.index===idx)});
    if(counter)counter.textContent=String(parseInt(idx)+1).padStart(2,'0');
    var activeMedia=medias[idx];
    var video=activeMedia&&activeMedia.querySelector('video');
    if(video&&!video.dataset.played){video.dataset.played='1';video.play().catch(function(){})}
  }

  setActive('0');

  // Portfolio grid cards stagger
  gsap.utils.toArray('.port-grid-card').forEach(function(card,i){
    gsap.from(card,{
      opacity:0,y:60,scale:.95,duration:1,delay:i*.12,ease:'power4.out',
      scrollTrigger:{trigger:card,start:'top 88%'}
    });
  });

  // Project list items slide in
  gsap.utils.toArray('.port-item').forEach(function(item,i){
    gsap.from(item,{
      opacity:0,x:40,duration:.8,delay:i*.1,ease:'power3.out',
      scrollTrigger:{trigger:item,start:'top 70%'}
    });
  });
})();
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
