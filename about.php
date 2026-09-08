<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';
$pageTitle  = 'About Us | Nexos Digital Marketing Agency';
$activePage = 'about';
include __DIR__ . '/includes/header.php';
?>
<style>
/* ABOUT PAGE — PREMIUM LUXURY 3D */
.about-hero{position:relative;padding:160px 60px 100px;overflow:hidden;background:var(--bg)}
.about-hero-bg{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.02) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.02) 1px,transparent 1px);background-size:72px 72px;mask-image:radial-gradient(ellipse 80% 80% at 50% 40%,#000 30%,transparent 100%)}
.about-hero-glow{position:absolute;width:600px;height:600px;background:radial-gradient(circle,rgba(255,255,255,.03) 0%,transparent 70%);top:-200px;right:-100px;animation:breathe 8s ease-in-out infinite}
.about-hero-glow2{position:absolute;width:400px;height:400px;background:radial-gradient(circle,rgba(255,255,255,.02) 0%,transparent 70%);bottom:-100px;left:-50px;animation:breathe 10s ease-in-out infinite 3s}
.about-hero-content{position:relative;z-index:2;max-width:800px}
.about-breadcrumb{display:flex;align-items:center;gap:8px;font-size:12px;color:var(--sub);margin-bottom:24px;font-family:var(--font-b)}
.about-breadcrumb a{color:var(--sub);transition:color .2s}
.about-breadcrumb a:hover{color:var(--blue2)}
.about-breadcrumb span{color:rgba(100,120,200,.4)}
.about-hero-badge{display:inline-flex;align-items:center;gap:8px;padding:7px 18px;border-radius:100px;background:rgba(255,255,255,.04);border:1px solid var(--border);font-family:var(--font-b);font-size:11px;font-weight:600;color:var(--sub);letter-spacing:1px;text-transform:uppercase;margin-bottom:28px;opacity:0;animation:fadeUp .7s .1s var(--ease) forwards}
.about-hero-h1{font-family:var(--font-h);font-weight:800;font-size:clamp(38px,5.5vw,72px);line-height:1.08;letter-spacing:-2px;color:var(--text);margin-bottom:20px;opacity:0;animation:fadeUp .9s .2s var(--ease) forwards}
.about-hero-h1 .em{background:linear-gradient(135deg,var(--blue),var(--blue2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;font-weight:700}
.about-hero-desc{font-size:17px;color:var(--sub);line-height:1.85;max-width:680px;opacity:0;animation:fadeUp .9s .38s var(--ease) forwards}

/* STATS ROW */
.stats-sec{background:var(--bg2);padding:70px 60px;border-top:1px solid var(--border);border-bottom:1px solid var(--border)}
.stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
.stat-box{background:var(--card);border:1px solid var(--border);border-radius:var(--r-xl);padding:36px 24px;text-align:center;position:relative;overflow:hidden;transition:all .4s var(--spring);transform-style:preserve-3d}
.stat-box::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:var(--border);opacity:0;transition:opacity .4s}
.stat-box:hover{border-color:var(--border);box-shadow:0 4px 20px rgba(0,0,0,.2)}
.stat-box:hover::before{opacity:1}
.stat-box-icon{width:48px;height:48px;background:rgba(255,255,255,.03);border:1px solid var(--border);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;transition:all .3s var(--spring)}
.stat-box:hover .stat-box-icon{background:rgba(255,255,255,.06);transform:scale(1.1)}
.stat-box-n{font-family:var(--font-h);font-size:44px;font-weight:800;color:var(--text);line-height:1}
.stat-box-l{font-size:13px;color:var(--sub);margin-top:8px;font-weight:500}

/* STORY SECTION */
.story-section{background:var(--bg);padding:100px 60px;position:relative;overflow:hidden}
.story-section::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,var(--border-accent),transparent)}
.story-grid{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
.story-text .sec-label{margin-bottom:22px}
.story-text .sec-h{margin-bottom:20px}
.story-text p{font-size:15px;color:var(--sub);line-height:1.85;margin-bottom:16px}
.story-img-wrap{position:relative;border-radius:var(--r-xl);overflow:hidden;border:1px solid var(--border);height:480px}
.story-img-wrap img{width:100%;height:100%;object-fit:cover;transition:transform .6s var(--ease)}
.story-img-wrap:hover img{transform:scale(1.04)}
.story-img-wrap::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(0,0,0,.2),transparent 60%);pointer-events:none}
.story-img-badge{position:absolute;bottom:24px;left:24px;background:var(--card);backdrop-filter:blur(12px);border:1px solid var(--border);border-radius:var(--r-lg);padding:16px 24px;display:flex;align-items:center;gap:12px;z-index:1}
.story-img-badge .badge-num{font-family:var(--font-h);font-size:28px;font-weight:800;color:var(--text)}
.story-img-badge .badge-text{font-size:12px;color:var(--sub);line-height:1.4}

/* MISSION CARDS */
.mission-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:60px}
.mission-card{background:var(--card);border:1px solid var(--border);border-radius:var(--r-xl);padding:40px 32px;position:relative;overflow:hidden;transition:all .4s var(--spring);transform-style:preserve-3d}
.mission-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:var(--border);opacity:0;transition:opacity .4s}
.mission-card:hover{border-color:var(--border);box-shadow:0 4px 20px rgba(0,0,0,.2)}
.mission-card:hover::before{opacity:1}
.mission-ico{width:60px;height:60px;background:rgba(255,255,255,.03);border:1px solid var(--border);border-radius:var(--r);display:flex;align-items:center;justify-content:center;margin-bottom:24px;transition:all .3s var(--spring)}
.mission-card:hover .mission-ico{background:rgba(255,255,255,.06);transform:scale(1.08) rotate(-4deg)}
.mission-title{font-family:var(--font-h);font-size:20px;font-weight:700;color:var(--text);margin-bottom:12px}
.mission-desc{font-family:var(--font-b);font-size:14px;color:var(--sub);line-height:1.8}

/* TIMELINE — UNIQUE ZIGZAG */
.timeline-sec{background:var(--bg2);padding:100px 60px;position:relative;overflow:hidden}
.timeline-sec::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,var(--border-accent),transparent)}
.timeline-grid{display:grid;position:relative;margin-top:70px}
.timeline-grid::before{
  content:'';position:absolute;left:50%;top:0;bottom:0;width:2px;transform:translateX(-50%);
  background:linear-gradient(180deg,var(--blue),var(--blue2),var(--border),transparent);
}
.tl-row{display:grid;grid-template-columns:1fr 1fr;gap:60px;margin-bottom:34px;position:relative}
.tl-row:last-child{margin-bottom:0}
.tl-card{
  position:relative;background:var(--card);border:1px solid var(--border);
  border-radius:var(--r-xl);padding:34px 32px;
  transition:all .4s var(--spring);overflow:hidden;
}
.tl-card::before{
  content:'';position:absolute;top:0;left:0;right:0;height:3px;
  background:linear-gradient(90deg,var(--blue),var(--blue2));
  opacity:0;transition:opacity .4s;
}
.tl-card:hover{
  border-color:rgba(21,101,255,.35);
  transform:translateY(-6px);
  box-shadow:0 20px 48px rgba(0,0,0,.35);
}
.tl-card:hover::before{opacity:1}
.tl-year-chip{
  display:inline-flex;align-items:center;gap:8px;
  font-family:var(--font-h);font-size:13px;font-weight:800;
  color:var(--blue2);letter-spacing:2px;
  background:rgba(21,101,255,.08);border:1px solid rgba(21,101,255,.2);
  padding:6px 14px;border-radius:100px;margin-bottom:16px;
}
.tl-year-chip svg{width:13px;height:13px}
.tl-title{font-family:var(--font-h);font-size:20px;font-weight:700;color:var(--text);margin-bottom:10px}
.tl-desc{font-family:var(--font-b);font-size:14px;color:var(--sub);line-height:1.75}
.tl-dot-center{
  position:absolute;left:50%;top:28px;transform:translateX(-50%);
  width:20px;height:20px;border-radius:50%;
  background:var(--bg2);border:4px solid var(--blue2);
  box-shadow:0 0 0 6px rgba(21,101,255,.12);
  transition:all .3s var(--spring);z-index:2;
}
.tl-row:hover .tl-dot-center{box-shadow:0 0 0 10px rgba(21,101,255,.2);transform:translateX(-50%) scale(1.15)}
.tl-num{
  position:absolute;font-family:var(--font-h);font-weight:800;
  font-size:96px;line-height:1;color:rgba(21,101,255,.05);
  top:8px;right:20px;pointer-events:none;user-select:none;
  transition:color .4s;
}
.tl-card:hover .tl-num{color:rgba(21,101,255,.12)}

/* VALUES */
.val-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-top:60px}
.val-card{background:var(--card);border:1px solid var(--border);border-radius:var(--r-xl);padding:40px;position:relative;overflow:hidden;transition:all .4s var(--spring);transform-style:preserve-3d}
.val-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:var(--border);opacity:0;transition:opacity .4s}
.val-card:hover{border-color:var(--border);box-shadow:0 4px 20px rgba(0,0,0,.2)}
.val-card:hover::before{opacity:1}
.val-ico{width:56px;height:56px;background:rgba(255,255,255,.03);border:1px solid var(--border);border-radius:var(--r);display:flex;align-items:center;justify-content:center;margin-bottom:24px;transition:all .3s var(--spring)}
.val-card:hover .val-ico{background:rgba(255,255,255,.06);transform:scale(1.08) rotate(-4deg)}
.val-title{font-family:var(--font-h);font-size:20px;font-weight:700;color:var(--text);margin-bottom:12px}
.val-desc{font-family:var(--font-b);font-size:14px;color:var(--sub);line-height:1.8}

/* TEAM */
.team-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-top:60px}
.team-card{background:var(--card);border:1px solid var(--border);border-radius:var(--r-xl);overflow:hidden;transition:all .4s var(--spring);transform-style:preserve-3d;position:relative}
.team-card:hover{border-color:var(--border);box-shadow:0 4px 20px rgba(0,0,0,.2)}
.team-av{height:220px;background:linear-gradient(135deg,var(--bg3),var(--bg2));position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center}
.team-av img{width:100%;height:100%;object-fit:cover;transition:transform .6s var(--ease)}
.team-card:hover .team-av img{transform:scale(1.08)}
.team-av::after{content:'';position:absolute;inset:0;background:linear-gradient(to top,rgba(6,8,16,.6) 0%,transparent 50%);pointer-events:none}
.team-initials{font-family:var(--font-h);font-size:56px;font-weight:800;color:var(--sub);opacity:.3}
.team-body{padding:24px}
.team-name{font-family:var(--font-h);font-size:18px;font-weight:700;color:var(--text);margin-bottom:4px}
.team-role{font-family:var(--font-h);font-size:13px;color:var(--sub);font-weight:500;margin-bottom:12px}
.team-desc{font-family:var(--font-b);font-size:13px;color:var(--sub);line-height:1.7}
.team-social{display:flex;gap:8px;margin-top:16px}
.team-social a{width:32px;height:32px;border-radius:50%;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--sub);transition:all .3s var(--spring)}
.team-social a:hover{border-color:var(--text);color:var(--text);background:rgba(255,255,255,.04)}

/* ABOUT CTA */
.about-cta{background:var(--bg);border-top:1px solid var(--border);padding:120px 60px;text-align:center;position:relative;overflow:hidden}
.about-cta-bg{position:absolute;inset:0;background:radial-gradient(ellipse 60% 80% at 50% 50%,rgba(255,255,255,.02),transparent);pointer-events:none}
.about-cta-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.015) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.015) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 80% 80% at 50% 50%,#000 20%,transparent 100%)}
.about-cta-orb{position:absolute;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,.025),transparent 70%);animation:float 6s ease-in-out infinite;pointer-events:none}
.about-cta-orb-1{width:250px;height:250px;top:10%;left:15%;animation-delay:0s}
.about-cta-orb-2{width:180px;height:180px;bottom:10%;right:20%;animation-delay:2s}
.about-cta-content{position:relative;z-index:2}
.about-cta .sec-h{margin-bottom:18px}
.about-cta .sec-sub{margin:0 auto 44px}

/* GLOBAL OVERRIDES - removed, using global styles from header.php */

/* RESPONSIVE */
@media(max-width:1024px){
  .about-hero,.stats-sec,.story-section,.timeline-sec,.about-cta{padding-left:28px;padding-right:28px}
  .stats-row{grid-template-columns:1fr 1fr}
  .story-grid{grid-template-columns:1fr;gap:48px}
  .mission-grid{grid-template-columns:1fr}
  .val-grid{grid-template-columns:1fr}
  .team-grid{grid-template-columns:1fr 1fr}
}
@media(max-width:640px){
  .about-hero{padding:130px 20px 60px}
  .stats-sec,.story-section,.timeline-sec,.about-cta{padding-left:20px;padding-right:20px}
  .stats-row{grid-template-columns:1fr 1fr}
  .stat-box-n{font-size:34px}
  .team-grid{grid-template-columns:1fr}
  .val-grid{grid-template-columns:1fr}
  .story-img-wrap{height:300px}
  .timeline-grid::before{left:12px}
  .tl-row{grid-template-columns:1fr;gap:20px}
  .tl-dot-center{left:12px;top:26px;width:16px;height:16px;border-width:3px;box-shadow:0 0 0 5px rgba(21,101,255,.12)}
  .tl-card{padding:24px 20px;margin-left:32px}
  .tl-num{font-size:72px}
}
</style>

<!-- HERO -->
<section class="about-hero">
  <div class="about-hero-bg"></div>
  <div class="about-hero-glow"></div>
  <div class="about-hero-glow2"></div>
  <div class="about-hero-content">
    <div class="about-breadcrumb"><a href="/">Home</a><span>/</span><span style="color:var(--text)">About Us</span></div>
    <div class="about-hero-badge">Our Story</div>
    <h1 class="about-hero-h1">
      We are Not Just an Agency.<br>We are Your <span class="em">Growth Partner.</span>
    </h1>
    <p class="about-hero-desc">Founded in Lahore, Nexos was built on a single belief: every ambitious Pakistani business deserves a digital partner that shows up, delivers transparent results, and speaks plain English &mdash; no jargon, no excuses, no disappearing after the contract is signed.</p>
  </div>
</section>

<!-- STATS -->
<section class="stats-sec">
  <div class="stats-row">
    <div class="stat-box reveal">
      <div class="stat-box-icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M22 12h-4l-3 9L9 3l-3 9H2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </div>
      <div class="stat-box-n counter" data-t="250">0+</div>
      <div class="stat-box-l">Projects Delivered</div>
    </div>
    <div class="stat-box reveal">
      <div class="stat-box-icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      </div>
      <div class="stat-box-n counter" data-t="180">0+</div>
      <div class="stat-box-l">Happy Clients</div>
    </div>
    <div class="stat-box reveal">
      <div class="stat-box-icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      </div>
      <div class="stat-box-n counter" data-t="8">0</div>
      <div class="stat-box-l">Years of Experience</div>
    </div>
    <div class="stat-box reveal">
      <div class="stat-box-icon">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" stroke="currentColor" stroke-width="2" rx="1"/><rect x="14" y="3" width="7" height="7" stroke="currentColor" stroke-width="2" rx="1"/><rect x="3" y="14" width="7" height="7" stroke="currentColor" stroke-width="2" rx="1"/><rect x="14" y="14" width="7" height="7" stroke="currentColor" stroke-width="2" rx="1"/></svg>
      </div>
      <div class="stat-box-n counter" data-t="17">0+</div>
      <div class="stat-box-l">Industries Served</div>
    </div>
  </div>
</section>

<!-- STORY -->
<section class="story-section">
  <div class="story-grid">
    <div class="story-text reveal-l">
      <div class="sec-label">The Nexos Story</div>
      <h2 class="sec-h">Built to Fix What is <span class="em">Broken</span> in Digital Marketing.</h2>
      <p>Our founders spent years on the client side of the table &mdash; watching budget after budget get wasted by agencies that over-promised and disappeared after the contract was signed.</p>
      <p>So we built the agency we always wished existed. One that treats your business like their own, communicates in plain language, and only declares victory when the numbers actually move.</p>
      <p>Today Nexos serves clients across 17+ industries &mdash; from local salons to international SaaS companies &mdash; delivering the same obsessive attention to quality and results-first thinking that we started with on day one.</p>
      <a href="/contact.php" class="btn-primary" style="margin-top:36px">Work With Us &rarr;</a>
    </div>
    <div class="reveal-r">
      <div class="story-img-wrap">
        <img src="<?= site_img('about_teamwork', '/assets/images/about-teamwork.jpg') ?>" alt="Nexos team collaboration">
        <div class="story-img-badge">
          <div class="badge-num">8+</div>
          <div class="badge-text">Years of<br>Excellence</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MISSION -->
<section class="sec" style="background:var(--bg2)">
  <div class="sec-center">
    <div class="sec-label reveal">Our Mission</div>
    <h2 class="sec-h reveal">What Drives <span class="em">Everything</span> We Do</h2>
    <p class="sec-sub reveal">Three principles that guide every decision, every campaign, and every client relationship at Nexos.</p>
  </div>
  <div class="mission-grid">
    <div class="mission-card reveal">
      <div class="mission-ico">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/></svg>
      </div>
      <div class="mission-title">Radical Transparency</div>
      <div class="mission-desc">No hidden metrics, no tech-speak. Every report is written in plain English so you always know exactly where your money goes and what it produces.</div>
    </div>
    <div class="mission-card reveal">
      <div class="mission-ico">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><rect x="2" y="2" width="20" height="20" rx="3" stroke="currentColor" stroke-width="1.8"/><path d="M3 17l5-6 4 4 4-5 4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </div>
      <div class="mission-title">Results Over Promises</div>
      <div class="mission-desc">We do not declare victory with words. We declare it with numbers. Every campaign is measured against real business outcomes, not vanity metrics.</div>
    </div>
    <div class="mission-card reveal">
      <div class="mission-ico">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </div>
      <div class="mission-title">No Lock-In Contracts</div>
      <div class="mission-desc">We earn your business every single month. We do not hide behind long-term contracts to mask mediocre results. If we are not delivering, you should be free to walk away.</div>
    </div>
  </div>
</section>

<!-- TIMELINE -->
<section class="timeline-sec">
  <div class="sec-center">
    <div class="sec-label reveal">Our Journey</div>
    <h2 class="sec-h reveal">From Two Founders to a <span class="em">Full-Service Agency</span></h2>
    <p class="sec-sub reveal">A decade of growth, driven by one principle: your success is our success.</p>
  </div>
  <div class="timeline-grid">
    <?php $timeline=[
      ['2017','Founded in Lahore','Nexos started with two founders and a shared frustration with how agencies treated clients. The mission: results, transparency, no nonsense.'],
      ['2019','First 50 Clients','Word-of-mouth grew the client base to 50 businesses across Pakistan. SEO and web design became our core signature services.'],
      ['2021','Expanded to International Markets','Launched Meta and Google Ads services and began serving clients in the UK, UAE, and North America.'],
      ['2023','AI & Automation Division','Added AI automation services to help clients save hours weekly and scale operations without scaling headcount.'],
      ['2025','250+ Projects & Growing','Serving 180+ active clients with a specialist team &mdash; still guided by the same founding principle: your success is our success.'],
    ];foreach($timeline as $i=>$t):
      $left = ($i % 2 === 0);?>
    <div class="tl-row reveal">
      <div class="tl-col" style="grid-column:<?=$left?'1':'2'?>;grid-row:1">
        <div class="tl-card">
          <span class="tl-num">0<?=$i+1?></span>
          <div class="tl-year-chip">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
            <?=$t[0]?>
          </div>
          <div class="tl-title"><?=h($t[1])?></div>
          <div class="tl-desc"><?=h($t[2])?></div>
        </div>
      </div>
      <div class="tl-dot-center"></div>
      <div class="tl-col" style="grid-column:<?=$left?'2':'1'?>;grid-row:1"></div>
    </div>
    <?php endforeach;?>
  </div>
</section>

<!-- VALUES -->
<section class="sec" style="background:var(--bg)">
  <div class="sec-center">
    <div class="sec-label reveal">Our Values</div>
    <h2 class="sec-h reveal">The Principles We <span class="em">Live By</span></h2>
    <p class="sec-sub reveal">These are not words on a wall. They are the lens every decision at Nexos is made through.</p>
  </div>
  <div class="val-grid">
    <?php $vals=[
      ['Total Transparency','No tech-speak or hidden metrics. Just plain English reports that show exactly where your money goes and what it is producing. You will always know what we are doing and why.','<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/>'],
      ['Data-Driven Decisions','Every campaign is backed by real numbers, not hunches. We rely on hard data and analytics to drive every strategic move. If it cannot be measured, we treat it with healthy scepticism.','<rect x="2" y="2" width="20" height="20" rx="3" stroke="currentColor" stroke-width="1.8"/><path d="M4 17l4-5 4 3 4-6 4 3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>'],
      ['True Partnership','We treat your business, your budget, and your goals as if they were our own. Your success is our success. We are invested in the long-term outcome, not just the next invoice.','<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="1.8"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>'],
      ['No Lock-In Contracts','We earn your business every single month. We do not hide behind long-term contracts to mask mediocre results. If we are not delivering, you should be free to walk away &mdash; and we are confident you will not want to.','<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>'],
    ];foreach($vals as $v):?>
    <div class="val-card reveal">
      <div class="val-ico"><svg width="26" height="26" viewBox="0 0 24 24" fill="none"><?=$v[2]?></svg></div>
      <div class="val-title"><?=h($v[0])?></div>
      <div class="val-desc"><?=$v[1]?></div>
    </div>
    <?php endforeach;?>
  </div>
</section>

<!-- TEAM -->
<section class="sec" style="background:var(--bg2)">
  <div class="sec-center">
    <div class="sec-label reveal">The Team</div>
    <h2 class="sec-h reveal">The People Behind <span class="em">Your Growth</span></h2>
    <p class="sec-sub reveal">A tight-knit team of strategists, creatives, and engineers &mdash; all obsessed with one thing: results.</p>
  </div>
  <div class="team-grid">
    <?php $team=[
      ['M. Usman','CEO & Founder',site_img('about_team_1','/assets/images/team-usman.jpg'),'Driving Nexos vision and building lasting client partnerships across 17+ industries.'],
      ['M. Irfan','Lead Developer',site_img('about_team_2','/assets/images/team-irfan.jpg'),'Architecting high-performance websites and custom digital solutions that convert.'],
      ['Saad','AI & Automation Expert',site_img('about_team_3','/assets/images/team-saad.jpg'),'Designing intelligent workflows that save clients hours every week and scale operations.'],
    ];foreach($team as $t):?>
    <div class="team-card reveal">
      <div class="team-av">
        <img src="<?=$t[2]?>" alt="<?=h($t[0])?>">
      </div>
      <div class="team-body">
        <div class="team-name"><?=h($t[0])?></div>
        <div class="team-role"><?=$t[1]?></div>
        <div class="team-desc"><?=h($t[3])?></div>
        <div class="team-social">
          <a href="https://www.linkedin.com/company/nexos-digital-agency/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="2" width="20" height="20" rx="4"/><line x1="8" y1="11" x2="8" y2="17"/><line x1="8" y1="7" x2="8" y2="7.5"/><path d="M12 11v6M12 11a3 3 0 016 0v6"/></svg></a>
          <a href="https://www.instagram.com/nexosdigitalagency" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg></a>
        </div>
      </div>
    </div>
    <?php endforeach;?>
  </div>
</section>

<!-- CTA -->
<section class="about-cta">
  <div class="about-cta-bg"></div>
  <div class="about-cta-grid"></div>
  <div class="about-cta-orb about-cta-orb-1"></div>
  <div class="about-cta-orb about-cta-orb-2"></div>
  <div class="about-cta-content">
    <div class="sec-label reveal" style="margin:0 auto 24px">Start Growing Today</div>
    <h2 class="sec-h reveal">Ready to <span class="em">Work Together?</span></h2>
    <p class="sec-sub reveal">Let us have an honest conversation about what is possible for your business.</p>
    <div style="display:flex;gap:14px;justify-content:center;flex-wrap:wrap" class="reveal">
      <a href="/contact.php" class="btn-primary">Get a Free Consultation &rarr;</a>
      <a href="/services.php" class="btn-outline">Explore Services</a>
    </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function(){
  if(typeof gsap==='undefined'||typeof ScrollTrigger==='undefined')return;

  // Mission cards
  gsap.utils.toArray('.mission-card').forEach(function(card,i){
    gsap.from(card,{
      opacity:0,y:50,scale:.95,duration:.9,delay:i*.12,ease:'power4.out',
      scrollTrigger:{trigger:card,start:'top 88%'}
    });
  });

  // Value cards
  gsap.utils.toArray('.val-card').forEach(function(card,i){
    gsap.from(card,{
      opacity:0,y:50,rotateX:8,duration:.9,delay:i*.12,ease:'power4.out',
      scrollTrigger:{trigger:card,start:'top 88%'},
      transformPerspective:800
    });
  });

  // Team cards
  gsap.utils.toArray('.team-card').forEach(function(card,i){
    gsap.from(card,{
      opacity:0,y:60,scale:.95,duration:1,delay:i*.15,ease:'power4.out',
      scrollTrigger:{trigger:card,start:'top 88%'}
    });
  });

  // Story section image
  gsap.from('.story-img-wrap',{
    opacity:0,x:60,scale:.95,duration:1.1,ease:'power4.out',
    scrollTrigger:{trigger:'.story-img-wrap',start:'top 80%'}
  });
});
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
