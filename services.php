<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';
$pageTitle  = 'Services | Nexos Digital Marketing Agency';
$activePage = 'services';
include __DIR__ . '/includes/header.php';
?>
<style>
/* SERVICES PAGE — PREMIUM LUXURY */
.svc-hero{position:relative;padding:160px 60px 100px;overflow:hidden;background:var(--bg)}
.svc-hero-bg{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.02) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.02) 1px,transparent 1px);background-size:72px 72px;mask-image:radial-gradient(ellipse 80% 80% at 50% 40%,#000 30%,transparent 100%)}
.svc-hero-glow{position:absolute;width:600px;height:600px;background:radial-gradient(circle,rgba(255,255,255,.03) 0%,transparent 70%);top:-200px;right:-100px;animation:breathe 8s ease-in-out infinite}
.svc-hero-glow2{position:absolute;width:400px;height:400px;background:radial-gradient(circle,rgba(255,255,255,.02) 0%,transparent 70%);bottom:-100px;left:-50px;animation:breathe 10s ease-in-out infinite 3s}
.svc-hero-content{position:relative;z-index:2;max-width:800px}
.svc-breadcrumb{display:flex;align-items:center;gap:8px;font-size:12px;color:var(--sub);margin-bottom:24px;font-family:var(--font-b)}
.svc-breadcrumb a{color:var(--sub);transition:color .2s}
.svc-breadcrumb a:hover{color:var(--blue2)}
.svc-breadcrumb span{color:rgba(100,120,200,.4)}
.svc-hero-badge{display:inline-flex;align-items:center;gap:8px;padding:7px 18px;border-radius:100px;background:rgba(255,255,255,.04);border:1px solid var(--border);font-family:var(--font-b);font-size:11px;font-weight:600;color:var(--sub);letter-spacing:1px;text-transform:uppercase;margin-bottom:28px;opacity:0;animation:fadeUp .7s .1s var(--ease) forwards}
.svc-hero-h1{font-family:var(--font-h);font-weight:800;font-size:clamp(38px,5.5vw,72px);line-height:1.08;letter-spacing:-2px;color:var(--text);margin-bottom:20px;opacity:0;animation:fadeUp .9s .2s var(--ease) forwards}
.svc-hero-h1 .em{background:linear-gradient(135deg,var(--blue),var(--blue2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;font-weight:700}
.svc-hero-desc{font-family:var(--font-b);font-size:17px;color:var(--sub);line-height:1.85;max-width:620px;opacity:0;animation:fadeUp .9s .38s var(--ease) forwards}

/* SERVICE ROWS */
.svc-full-grid{display:grid;grid-template-columns:1fr;gap:0}
.svc-full-row{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center;padding:100px 0;border-bottom:1px solid var(--border);position:relative}
.svc-full-row:last-child{border-bottom:none}
.svc-full-row.reverse .svc-full-visual{order:-1}
.svc-full-num{font-family:var(--font-h);font-size:clamp(70px,9vw,130px);font-weight:900;color:var(--sub);line-height:1;margin-bottom:8px;opacity:.1}
.svc-full-title{font-family:var(--font-h);font-size:clamp(26px,3vw,42px);font-weight:800;color:var(--text);margin-bottom:16px;line-height:1.15}
.svc-full-desc{font-family:var(--font-b);font-size:15px;color:var(--sub);line-height:1.85;margin-bottom:0}
.svc-tag-list{display:flex;flex-wrap:wrap;gap:8px;margin-top:24px}
.svc-tag{font-family:var(--font-h);font-size:10px;font-weight:600;color:var(--sub);background:rgba(255,255,255,.03);border:1px solid var(--border);padding:5px 14px;border-radius:100px;letter-spacing:.5px;transition:all .3s var(--spring)}
.svc-tag:hover{background:rgba(255,255,255,.06);border-color:var(--border);color:var(--text)}
.svc-full-visual{background:var(--bg3);border:1px solid var(--border);border-radius:var(--r-xl);height:380px;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden;transition:all .4s var(--spring)}
.svc-full-visual img{width:100%;height:100%;object-fit:cover;opacity:.85;transition:transform .6s var(--ease),opacity .4s}
.svc-full-row:hover .svc-full-visual{border-color:var(--border)}
.svc-full-row:hover .svc-full-visual img{transform:scale(1.06);opacity:1}
.svc-ico-big{width:80px;height:80px;background:rgba(255,255,255,.03);border:1px solid var(--border);border-radius:20px;display:flex;align-items:center;justify-content:center;position:relative;z-index:1;transition:all .3s var(--spring)}
.svc-full-row:hover .svc-ico-big{transform:scale(1.08) rotate(-4deg)}
.feature-list{display:flex;flex-direction:column;gap:12px;margin-top:28px}
.feature-item{display:flex;align-items:flex-start;gap:12px;font-family:var(--font-b);font-size:14px;color:var(--sub);line-height:1.6;transition:color .2s}
.feature-item:hover{color:var(--text)}
.feature-dot{width:20px;height:20px;background:rgba(255,255,255,.03);border:1px solid var(--border);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;transition:all .3s var(--spring)}
.feature-item:hover .feature-dot{background:rgba(255,255,255,.06);transform:scale(1.1)}

/* WHY CHOOSE US */
.why-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-top:60px}
.why-card{background:var(--card);border:1px solid var(--border);border-radius:var(--r-xl);padding:36px 28px;text-align:center;transition:all .4s var(--spring);transform-style:preserve-3d}
.why-card:hover{border-color:var(--border);box-shadow:0 4px 20px rgba(0,0,0,.2)}
.why-ico{width:56px;height:56px;background:rgba(255,255,255,.03);border:1px solid var(--border);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;transition:all .3s var(--spring)}
.why-card:hover .why-ico{background:rgba(255,255,255,.06);transform:scale(1.1)}
.why-title{font-family:var(--font-h);font-size:16px;font-weight:700;color:var(--text);margin-bottom:8px}
.why-desc{font-family:var(--font-b);font-size:13px;color:var(--sub);line-height:1.7}

/* PRICING */
.pricing-sec{background:var(--bg2);padding:100px 60px;position:relative}
.pricing-sec::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:var(--border)}
.pricing-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-top:60px}
.price-card{background:var(--card);border:1px solid var(--border);border-radius:var(--r-xl);padding:44px 36px;position:relative;transition:all .4s var(--spring);transform-style:preserve-3d;overflow:hidden}
.price-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:var(--border);opacity:0;transition:opacity .4s}
.price-card:hover{border-color:var(--border);box-shadow:0 4px 20px rgba(0,0,0,.2)}
.price-card:hover::before{opacity:1}
.price-card.popular{border-color:var(--border);background:rgba(255,255,255,.02)}
.price-card.popular::before{opacity:1}
.price-badge{position:absolute;top:-1px;left:50%;transform:translateX(-50%);background:linear-gradient(135deg,var(--blue),var(--blue2));color:#0a0a10;font-family:var(--font-h);font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;padding:6px 20px;border-radius:0 0 12px 12px;box-shadow:0 4px 20px rgba(21,101,255,.3)}
.price-icon{width:56px;height:56px;background:rgba(255,255,255,.03);border:1px solid var(--border);border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:24px;transition:all .3s var(--spring)}
.price-card:hover .price-icon{background:rgba(255,255,255,.06);transform:scale(1.08)}
.price-plan{font-family:var(--font-h);font-size:14px;font-weight:700;color:var(--sub);letter-spacing:.5px;margin-bottom:16px;text-transform:uppercase}
.price-amount{font-family:var(--font-h);font-size:40px;font-weight:800;color:var(--text);line-height:1;margin-bottom:6px}
.price-amount span{font-size:16px;color:var(--sub);font-weight:400}
.price-desc{font-family:var(--font-b);font-size:13px;color:var(--sub);margin-bottom:28px;line-height:1.7}
.price-features{list-style:none;display:flex;flex-direction:column;gap:12px;margin-bottom:36px}
.price-features li{font-family:var(--font-b);font-size:14px;color:var(--sub);display:flex;align-items:center;gap:10px;transition:color .2s}
.price-features li:hover{color:var(--text)}
.price-features li::before{content:'✓';color:var(--text);font-weight:600;font-size:13px;width:22px;height:22px;background:rgba(255,255,255,.03);border:1px solid var(--border);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all .3s var(--spring)}
.price-card:hover .price-features li::before{background:rgba(255,255,255,.06)}

/* CTA */
.svc-cta{background:var(--bg);border-top:1px solid var(--border);padding:120px 60px;text-align:center;position:relative;overflow:hidden}
.svc-cta-bg{position:absolute;inset:0;background:radial-gradient(ellipse 60% 80% at 50% 50%,rgba(255,255,255,.025),transparent);pointer-events:none}
.svc-cta-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.015) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.015) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 80% 80% at 50% 50%,#000 20%,transparent 100%)}
.svc-cta-orb{position:absolute;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,.03),transparent 70%);animation:float 6s ease-in-out infinite;pointer-events:none}
.svc-cta-orb-1{width:250px;height:250px;top:10%;left:15%;animation-delay:0s}
.svc-cta-orb-2{width:180px;height:180px;bottom:10%;right:20%;animation-delay:2s}
.svc-cta-content{position:relative;z-index:2}
.svc-cta .sec-h{margin-bottom:18px}
.svc-cta .sec-sub{margin:0 auto 44px}
.svc-cta .em{background:linear-gradient(135deg,var(--blue),var(--blue2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}

/* RESPONSIVE */
@keyframes svcRowIn{from{opacity:0;transform:translateY(60px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}
@keyframes svcVisualIn{from{opacity:0;transform:translateX(40px) scale(.95)}to{opacity:1;transform:translateX(0) scale(1)}}
@keyframes svcTextIn{from{opacity:0;transform:translateX(-40px)}to{opacity:1;transform:translateX(0)}}
@keyframes featureSlideIn{from{opacity:0;transform:translateX(-20px)}to{opacity:1;transform:translateX(0)}}
.svc-full-row.reveal.reveal .feature-item{animation:featureSlideIn .5s var(--premium) both}
.svc-full-row.reveal.reveal .feature-item:nth-child(1){animation-delay:.3s}
.svc-full-row.reveal.reveal .feature-item:nth-child(2){animation-delay:.38s}
.svc-full-row.reveal.reveal .feature-item:nth-child(3){animation-delay:.46s}
.svc-full-row.reveal.reveal .feature-item:nth-child(4){animation-delay:.54s}
.svc-full-row.reveal.reveal .feature-item:nth-child(5){animation-delay:.62s}
.svc-full-row.reveal.reveal .feature-item:nth-child(6){animation-delay:.7s}
@keyframes tagPopIn{from{opacity:0;transform:scale(.8)}to{opacity:1;transform:scale(1)}}
.svc-full-row.reveal.reveal .svc-tag{animation:tagPopIn .4s var(--spring) both}
.svc-full-row.reveal.reveal .svc-tag:nth-child(1){animation-delay:.5s}
.svc-full-row.reveal.reveal .svc-tag:nth-child(2){animation-delay:.56s}
.svc-full-row.reveal.reveal .svc-tag:nth-child(3){animation-delay:.62s}
.svc-full-row.reveal.reveal .svc-tag:nth-child(4){animation-delay:.68s}
.svc-full-row.reveal.reveal .svc-tag:nth-child(5){animation-delay:.74s}
@keyframes numFadeIn{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
.svc-full-row.reveal.reveal .svc-full-num{animation:numFadeIn .7s var(--premium) both}
@media(max-width:1024px){
  .svc-hero,.pricing-sec,.svc-cta{padding-left:28px;padding-right:28px}
  .svc-full-row.svc-full-row{grid-template-columns:1fr;gap:40px;padding:70px 0}
  .svc-full-row.reverse .svc-full-visual{order:0}
  .svc-full-visual{height:280px}
  .pricing-grid{grid-template-columns:1fr 1fr}
  .why-grid{grid-template-columns:1fr 1fr}
}
@media(max-width:640px){
  .svc-hero{padding:130px 20px 60px}
  .pricing-sec,.svc-cta{padding-left:20px;padding-right:20px}
  .svc-full-row{padding:50px 0}
  .svc-full-visual{height:220px}
  .pricing-grid{grid-template-columns:1fr}
  .why-grid{grid-template-columns:1fr}
  .svc-tag-list{gap:6px}
}
</style>

<!-- HERO -->
<section class="svc-hero">
  <div class="svc-hero-bg"></div>
  <div class="svc-hero-glow"></div>
  <div class="svc-hero-glow2"></div>
  <div class="svc-hero-content">
    <div class="svc-breadcrumb"><a href="/">Home</a><span>/</span><span style="color:var(--text)">Services</span></div>
    <div class="svc-hero-badge">What We Do</div>
    <h1 class="svc-hero-h1">
      Everything You Need to<br><span class="em">Dominate Online.</span>
    </h1>
    <p class="svc-hero-desc">Seven core services. One unified strategy. Built around your business, not a template.</p>
  </div>
</section>

<!-- SERVICES DETAIL -->
<section class="sec" style="background:var(--bg)" data-no-fade>
  <div class="svc-full-grid">
    <?php
    $services=[
      [
        'id'=>'seo','num'=>'01','title'=>'SEO Optimization','reverse'=>false,
        'desc'=>'Having a beautiful website does not matter if nobody finds it. We optimize your site from the inside out &mdash; from technical architecture to content strategy &mdash; so search engines love it and your ideal customers find exactly what they are looking for.',
        'features'=>['Full technical SEO audit & fixes','Keyword research & competitor gap analysis','On-page & off-page optimization','Monthly ranking reports in plain English','Local SEO for brick-and-mortar businesses','Content strategy & blog SEO'],
        'tags'=>['On-Page SEO','Technical SEO','Link Building','Local SEO','Content Strategy'],
        'icon'=>'<circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M3 12h18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M12 3c-3 3.5-3 9.5 0 18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M12 3c3 3.5 3 9.5 0 18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
        'image'=>site_img('svc_seo','/assets/images/svc-seo.jpg'),
        'detail_link'=>'/seo.php',
      ],
      [
        'id'=>'ads','num'=>'02','title'=>'Digital Advertising (Meta & Google)','reverse'=>true,
        'desc'=>'Put your brand directly in front of people who are already eager to buy. Through precise Meta Ads management and targeted Google campaigns, we stop wasted budget and turn every dollar you spend into measurable, real revenue growth.',
        'features'=>['Meta (Facebook & Instagram) Ads setup & management','Google Search, Display & Shopping Ads','Audience research & retargeting funnels','A/B testing ad creatives & copy','Real-time budget optimization','Weekly ROI performance reports'],
        'tags'=>['Meta Ads','Google Ads','Retargeting','Lead Generation','ROI Tracking'],
        'icon'=>'<rect x="2" y="4" width="20" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M2 9h20" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M6 15h4M14 15h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
        'image'=>site_img('svc_ads','/assets/images/svc-ads.jpg'),
        'detail_link'=>'/digital-advertising.php',
      ],
      [
        'id'=>'ecom','num'=>'03','title'=>'E-Commerce Solutions','reverse'=>false,
        'desc'=>'Whether launching your first storefront or expanding onto global marketplaces, we build seamless e-commerce experiences. From reducing abandoned carts on Shopify to dominating Amazon search &mdash; we make buying fast, secure, and easy.',
        'features'=>['Shopify & WooCommerce store builds','Amazon & Daraz marketplace optimization','Conversion rate optimization (CRO)','Product page design & copywriting','Payment gateway & logistics integration','Abandoned cart recovery flows'],
        'tags'=>['Shopify','WooCommerce','Amazon','Marketplace SEO','CRO'],
        'icon'=>'<path d="M6 2L3 7v13a2 2 0 002 2h14a2 2 0 002-2V7l-3-5z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M3 7h18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M16 11a4 4 0 01-8 0" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
        'image'=>site_img('svc_ecom','/assets/images/svc-ecom.jpg'),
        'detail_link'=>'/e-commerce-solutions.php',
      ],
      [
        'id'=>'web','num'=>'04','title'=>'Web Design & Development','reverse'=>true,
        'desc'=>'People judge a business by its digital cover. We specialise in clean, corporate, and tech-focused aesthetics that command authority. High-performing, mobile-friendly websites that run flawlessly &mdash; no glitchy pages, no slow load times.',
        'features'=>['Custom website design (no templates)','Mobile-first, responsive development','Speed & Core Web Vitals optimization','CMS integration (WordPress, custom)','Landing page design & A/B testing','12-month post-launch support'],
        'tags'=>['Web Design','WordPress','Custom Dev','Landing Pages','UI/UX'],
        'icon'=>'<rect x="2" y="3" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 21h8M12 17v4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M7 9l3 3-3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M13 15h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
        'image'=>site_img('svc_web','/assets/images/svc-web.jpg'),
        'detail_link'=>'/web-design-development.php',
      ],
      [
        'id'=>'perf','num'=>'05','title'=>'Performance Marketing','reverse'=>false,
        'desc'=>'Storytelling-style ad creatives that stop people from scrolling, combined with hyper-targeted audience data. Every campaign is launched with real numbers, not hunches &mdash; delivering measurable ROI and compounding returns over time.',
        'features'=>['UGC & storytelling-style video ads','Hyper-targeted audience segmentation','Full-funnel campaign architecture','Influencer & content partnership strategy','Cross-channel attribution tracking','Scaling profitable campaigns aggressively'],
        'tags'=>['Performance Ads','Video Creative','UGC','Attribution','Scaling'],
        'icon'=>'<rect x="2" y="2" width="20" height="20" rx="3" stroke="currentColor" stroke-width="1.6"/><path d="M3 17l5-6 4 4 4-5 4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
        'image'=>site_img('svc_perf','/assets/images/svc-perf.jpg'),
        'detail_link'=>'/performance-marketing.php',
      ],
      [
        'id'=>'ai','num'=>'06','title'=>'AI Automation','reverse'=>true,
        'desc'=>'Save hours every week and scale without scaling headcount. We design, build, and deploy AI-powered workflows tailored to your business &mdash; from intelligent chatbots and automated lead qualification to smart reporting systems and CRM automation.',
        'features'=>['AI chatbot design & deployment','Lead qualification & nurturing automation','CRM & workflow automation (Zapier, Make)','Automated reporting dashboards','Email & WhatsApp follow-up sequences','Custom AI tool integrations'],
        'tags'=>['AI Chatbots','Workflow Automation','CRM Automation','Lead Nurturing','Zapier/Make'],
        'icon'=>'<rect x="3" y="3" width="18" height="18" rx="3" stroke="currentColor" stroke-width="1.6"/><circle cx="9" cy="9" r="2" stroke="currentColor" stroke-width="1.4"/><circle cx="15" cy="9" r="2" stroke="currentColor" stroke-width="1.4"/><path d="M7 15c1 1.5 5 1.5 6 0" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
        'image'=>site_img('svc_ai','/assets/images/svc-ai.jpg'),
        'detail_link'=>'/ai-automation.php',
      ],
      [
        'id'=>'brand','num'=>'07','title'=>'Brand Strategy & Identity','reverse'=>false,
        'desc'=>'We do not believe in generic templates. We sit down with you, understand your business DNA, and architect a custom digital ecosystem &mdash; your brand story told with precision and impact across every channel and touchpoint.',
        'features'=>['Brand identity design (logo, colours, fonts)','Messaging & brand voice development','Competitor positioning analysis','Social media brand kit & guidelines','Email marketing templates & sequences','Pitch deck & presentation design'],
        'tags'=>['Brand Identity','Logo Design','Messaging','Social Branding','Pitch Decks'],
        'icon'=>'<circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M4 20a8 8 0 0116 0" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M12 12v4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
        'image'=>site_img('svc_brand','/assets/images/svc-brand.jpg'),
        'detail_link'=>'/branding.php',
      ],
    ];
    foreach($services as $si=>$svc):?>
    <div class="svc-full-row reveal<?=$svc['reverse']?' reverse':''?>" data-delay="<?=$si*120?>" id="<?=$svc['id']?>">
      <div class="svc-full-text">
        <div class="svc-full-num"><?=$svc['num']?></div>
        <h2 class="svc-full-title"><?=h($svc['title'])?></h2>
        <p class="svc-full-desc"><?=h($svc['desc'])?></p>
        <div class="feature-list">
          <?php foreach($svc['features'] as $f):?>
          <div class="feature-item">
            <div class="feature-dot">
              <svg width="10" height="10" viewBox="0 0 10 10" fill="none"><path d="M2 5l2 2 4-4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <?=h($f)?>
          </div>
          <?php endforeach;?>
        </div>
        <div class="svc-tag-list">
          <?php foreach($svc['tags'] as $tag):?>
          <span class="svc-tag"><?=h($tag)?></span>
          <?php endforeach;?>
        </div>
        <div style="margin-top:36px">
          <a href="<?= !empty($svc['detail_link']) ? $svc['detail_link'] : '/contact.php'; ?>" class="btn-primary">Get Started &rarr;</a>
        </div>
      </div>
      <div class="svc-full-vis">
        <div class="svc-full-visual">
          <img src="<?=$svc['image']?>" alt="<?=h($svc['title'])?>">
        </div>
      </div>
    </div>
    <?php endforeach;?>
  </div>
</section>

<!-- WHY CHOOSE US -->
<section class="sec" style="background:var(--bg2)" data-no-fade>
  <div class="sec-center">
    <div class="sec-label reveal" data-delay="0">Why Nexos</div>
    <h2 class="sec-h reveal" data-delay="120">Why Businesses <span class="em">Choose Us</span></h2>
    <p class="sec-sub reveal" data-delay="240">We are not the biggest agency. We are the one that actually shows up and delivers.</p>
  </div>
  <div class="why-grid">
    <?php $whys=[
      ['No Lock-In','We earn your business every month. No long-term contracts hiding mediocre results.','<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>'],
      ['Plain English','No jargon, no tech-speak. We explain everything in language you actually understand.','<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/>'],
      ['Real-Time Access','See exactly what is happening with your campaigns, rankings, and leads at any time.','<rect x="2" y="2" width="20" height="20" rx="3" stroke="currentColor" stroke-width="1.6"/><path d="M4 17l4-5 4 3 4-6 4 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>'],
      ['Dedicated Team','You get a dedicated account manager who knows your business inside and out.','<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>'],
    ];foreach($whys as $wi=>$w):?>
    <div class="why-card reveal" data-delay="<?=($wi+1)*120?>">
      <div class="why-ico"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"><?=$w[2]?></svg></div>
      <div class="why-title"><?=h($w[0])?></div>
      <div class="why-desc"><?=h($w[1])?></div>
    </div>
    <?php endforeach;?>
  </div>
</section>

<!-- PRICING -->
<section class="pricing-sec">
  <div class="sec-center">
    <div class="sec-label reveal" data-delay="0">Pricing</div>
    <h2 class="sec-h reveal" data-delay="120">Transparent, <span class="em">Flexible</span> Pricing</h2>
    <p class="sec-sub reveal" data-delay="240">No hidden fees. No lock-in contracts. Just honest pricing built around your goals and budget.</p>
  </div>
  <div class="pricing-grid">
    <div class="price-card reveal">
      <div class="price-icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 2L2 7l10 5 10-5-10-5z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M2 17l10 5 10-5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M2 12l10 5 10-5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </div>
      <div class="price-plan">Starter</div>
      <div class="price-amount">Custom<span> quote</span></div>
      <div class="price-desc">For small businesses and startups getting their digital presence off the ground.</div>
      <ul class="price-features">
        <li>1 core service</li><li>Monthly reporting</li><li>Email support</li><li>3-month commitment</li>
      </ul>
      <a href="/contact.php" class="btn-outline" style="width:100%;justify-content:center">Get a Quote</a>
    </div>
    <div class="price-card popular reveal" data-delay="120">
      <div class="price-badge">Most Popular</div>
      <div class="price-icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </div>
      <div class="price-plan">Growth</div>
      <div class="price-amount">Custom<span> quote</span></div>
      <div class="price-desc">For growing businesses ready to invest in multi-channel growth strategies.</div>
      <ul class="price-features">
        <li>3 core services bundled</li><li>Bi-weekly strategy calls</li><li>Priority support (24h)</li><li>Dedicated account manager</li><li>Flexible commitment</li>
      </ul>
      <a href="/contact.php" class="btn-primary" style="width:100%;justify-content:center">Get a Quote &rarr;</a>
    </div>
    <div class="price-card reveal" data-delay="240">
      <div class="price-icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </div>
      <div class="price-plan">Enterprise</div>
      <div class="price-amount">Custom<span> quote</span></div>
      <div class="price-desc">For established brands needing a full-service digital partner at scale.</div>
      <ul class="price-features">
        <li>All 7 services</li><li>Weekly performance reviews</li><li>Dedicated team</li><li>Custom reporting dashboard</li><li>White-glove onboarding</li>
      </ul>
      <a href="/contact.php" class="btn-outline" style="width:100%;justify-content:center">Let us Talk</a>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="svc-cta">
  <div class="svc-cta-bg"></div>
  <div class="svc-cta-grid"></div>
  <div class="svc-cta-orb svc-cta-orb-1"></div>
  <div class="svc-cta-orb svc-cta-orb-2"></div>
  <div class="svc-cta-content">
    <div class="sec-label reveal" data-delay="0" style="margin:0 auto 24px">Ready to Get Started?</div>
    <h2 class="sec-h reveal" data-delay="120">Stop Guessing.<br>Start <span class="em">Scaling.</span></h2>
    <p class="sec-sub reveal" data-delay="240">Book a free 30-minute strategy call. We will audit your current digital presence and show you exactly where the biggest growth opportunities are.</p>
    <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap" class="reveal" data-delay="360">
      <a href="/contact.php" class="btn-primary">Book a Free Strategy Call &rarr;</a>
      <a href="/about.php" class="btn-outline">Learn About Us</a>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
