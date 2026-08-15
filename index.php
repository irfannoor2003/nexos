<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';
$pageTitle  = 'Nexos | Digital Marketing Agency in Pakistan';
$activePage = 'home';
$db = getDB();
$latestPosts = $db->query("SELECT p.*, c.name as cat_name FROM posts p LEFT JOIN categories c ON p.category_id=c.id WHERE p.status='published' ORDER BY p.created_at DESC LIMIT 3")->fetchAll();
include __DIR__ . '/includes/header.php';
?>
<style>
/* ═══════════════════════════════════════════════════
   MARQUEE
   ═══════════════════════════════════════════════════ */
.marquee-wrap{
  position:relative;z-index:3;
  border-top:1px solid var(--border-accent);border-bottom:1px solid var(--border-accent);
  padding:16px 0;overflow:hidden;
  background:linear-gradient(90deg,var(--bg2),var(--bg3),var(--bg2));
}
.marquee-track{display:flex;white-space:nowrap;animation:marquee 35s linear infinite;will-change:transform}
.marquee-wrap:hover .marquee-track{animation-play-state:paused}
.mq-item{
  display:inline-flex;align-items:center;gap:16px;
  padding:0 32px;font-size:11px;font-weight:600;
  color:var(--sub);letter-spacing:.8px;
  font-family:var(--font-b);transition:color .3s;
}
.mq-item:hover{color:var(--blue)}
.mq-sep{
  width:4px;height:4px;
  background:linear-gradient(135deg,var(--blue),var(--blue2));
  border-radius:50%;flex-shrink:0;
  box-shadow:0 0 8px var(--blue-glow);
}
@keyframes marquee{from{transform:translateX(0)}to{transform:translateX(-50%)}}

/* ═══════════════════════════════════════════════════
   HERO
   ═══════════════════════════════════════════════════ */
.hero{
  position:relative;min-height:100vh;
  display:flex;flex-direction:column;justify-content:center;
  padding:80px 64px;overflow:hidden;
}
.hero-bg{position:absolute;inset:0;z-index:0;overflow:hidden}
.hero-grid{
  position:absolute;inset:0;
  background-image:linear-gradient(rgba(255,255,255,.02) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.02) 1px,transparent 1px);
  background-size:80px 80px;
  mask-image:radial-gradient(ellipse 80% 80% at 50% 40%,#000 30%,transparent 100%);
}
.hero-glow{
  position:absolute;width:900px;height:900px;
  background:radial-gradient(circle,rgba(255,255,255,.03) 0%,transparent 70%);
  top:-250px;right:-250px;
  animation:breathe 10s ease-in-out infinite;
}
.hero-glow2{
  position:absolute;width:600px;height:600px;
  background:radial-gradient(circle,rgba(255,255,255,.02) 0%,transparent 70%);
  bottom:-150px;left:-150px;
  animation:breathe 12s ease-in-out infinite 3s;
}
.hero-content{position:relative;z-index:2;max-width:940px;width:100%;text-align:left}

.hero-badge{
  display:inline-flex;align-items:center;gap:10px;
  padding:8px 20px;border-radius:100px;
  background:rgba(255,255,255,.04);border:1px solid var(--border);
  font-family:var(--font-b);font-size:10px;font-weight:600;
  color:var(--sub);letter-spacing:1.2px;text-transform:uppercase;
  margin-bottom:36px;
  opacity:0;animation:fadeUp .5s .05s var(--ease) forwards;
}
.badge-dot{
  width:6px;height:6px;
  background:var(--sub);border-radius:50%;
  animation:pulse 1.4s infinite;
}
.hero-h1{
  font-family:var(--font-h);font-weight:800;
  font-size:clamp(44px,6.5vw,92px);
  line-height:1.04;letter-spacing:-2px;
}
.word-em{
  font-style:italic;font-weight:700;
  background:linear-gradient(135deg,var(--blue),var(--blue2));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;
  background-clip:text;
}
.word-outline{
  -webkit-text-stroke:2px rgba(255,255,255,.08);color:transparent;
}
[data-theme="light"] .word-outline{-webkit-text-stroke:2px rgba(0,0,0,.08)}
.hero-desc{
  font-size:17px;color:var(--sub);line-height:1.9;
  max-width:640px;margin-top:30px;
  opacity:0;animation:fadeUp .6s .18s var(--ease) forwards;
}
.hero-desc strong{color:var(--text);font-weight:600}
.hero-actions{
  display:flex;gap:16px;align-items:center;
  margin-top:48px;flex-wrap:wrap;
  opacity:0;animation:fadeUp .6s .26s var(--ease) forwards;
}
.hero-stats{
  display:flex;gap:44px;margin-top:44px;
  opacity:0;animation:fadeUp .6s .34s var(--ease) forwards;
  flex-wrap:wrap;
}
.stat{
  padding:18px 24px;
  background:rgba(255,255,255,.02);
  border:1px solid var(--border);
  border-radius:18px;
  transition:border-color .3s,background .3s;
}
.stat:hover{
  border-color:var(--border);
  background:rgba(255,255,255,.04);
}
.stat-n{font-family:var(--font-h);font-size:40px;font-weight:800;line-height:1;
  color:var(--text);
}
.stat-l{font-size:12px;color:var(--sub);margin-top:6px;letter-spacing:.3px}
.hero-scroll{
  position:absolute;bottom:36px;left:64px;z-index:2;
  display:flex;align-items:center;gap:12px;
  font-size:10px;letter-spacing:2.5px;text-transform:uppercase;color:var(--sub);
  opacity:0;animation:fadeUp .6s .5s var(--ease) forwards;
}
.scroll-line{
  width:44px;height:1px;
  background:linear-gradient(90deg,var(--text),transparent);
  animation:scroll-pulse 2.5s ease-in-out infinite;
}
@keyframes scroll-pulse{0%,100%{opacity:1;width:44px}50%{opacity:.4;width:26px}}

/* ═══════════════════════════════════════════════════
   HERO 3D FLOATING BADGES (CONSTELLATION)
   ═══════════════════════════════════════════════════ */
.hf-scene{
  position:absolute;right:3%;top:18%;width:40%;height:64%;z-index:3;
  pointer-events:none;perspective:1200px;
  opacity:0;animation:fadeIn .8s .3s var(--ease) forwards, sceneFloat 6s ease-in-out .8s infinite;
}
@keyframes sceneFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
.hf-svg{
  position:absolute;inset:0;width:100%;height:100%;z-index:0;
  pointer-events:none;overflow:visible;
}
.hf-svg line{
  stroke:rgba(255,255,255,.04);stroke-width:1;stroke-dasharray:3 4;
  transition:stroke .4s,stroke-width .4s;
}
.hf-svg line.active{
  stroke:rgba(21,101,255,.2);stroke-width:1.5;stroke-dasharray:none;
}
.hf-badge{
  position:absolute;z-index:1;
  display:flex;align-items:center;gap:8px;
  background:var(--card);border:1px solid var(--border);
  border-radius:10px;padding:7px 13px;
  pointer-events:auto;cursor:pointer;
  transition:border-color .4s var(--spring),box-shadow .4s var(--spring),background .4s;
  transform-style:preserve-3d;backface-visibility:hidden;
}
.hf-badge:hover{
  border-color:var(--blue);background:var(--bg3);
  box-shadow:0 8px 32px rgba(21,101,255,.12),0 0 0 1px rgba(21,101,255,.15);
}
.hf-b1{left:45%;top:4%}
.hf-b2{left:65%;top:12%}
.hf-b3{left:44%;top:34%}
.hf-b4{left:66%;top:42%}
.hf-b5{left:43%;top:64%}
.hf-b6{left:65%;top:74%}
.hf-b1{animation: b1In .5s .4s var(--ease) forwards, b1Float 7s ease-in-out .4s infinite}
.hf-b2{animation: b2In .5s .55s var(--ease) forwards, b2Float 8s ease-in-out .55s infinite}
.hf-b3{animation: b3In .5s .7s var(--ease) forwards, b3Float 6.5s ease-in-out .7s infinite}
.hf-b4{animation: b4In .5s .85s var(--ease) forwards, b4Float 7.5s ease-in-out .85s infinite}
.hf-b5{animation: b5In .5s 1s var(--ease) forwards, b5Float 8.5s ease-in-out 1s infinite}
.hf-b6{animation: b6In .5s 1.15s var(--ease) forwards, b6Float 7s ease-in-out 1.15s infinite}
@keyframes b1In{0%{opacity:0;transform:translateX(-15px) translateY(8px) scale(.9)}100%{opacity:1;transform:translateX(0) translateY(0) scale(1)}}
@keyframes b2In{0%{opacity:0;transform:translateX(15px) translateY(5px) scale(.9)}100%{opacity:1;transform:translateX(0) translateY(0) scale(1)}}
@keyframes b3In{0%{opacity:0;transform:translateX(-12px) translateY(-8px) scale(.9)}100%{opacity:1;transform:translateX(0) translateY(0) scale(1)}}
@keyframes b4In{0%{opacity:0;transform:translateX(12px) translateY(6px) scale(.9)}100%{opacity:1;transform:translateX(0) translateY(0) scale(1)}}
@keyframes b5In{0%{opacity:0;transform:translateX(-15px) translateY(-6px) scale(.9)}100%{opacity:1;transform:translateX(0) translateY(0) scale(1)}}
@keyframes b6In{0%{opacity:0;transform:translateX(14px) translateY(-4px) scale(.9)}100%{opacity:1;transform:translateX(0) translateY(0) scale(1)}}
@keyframes b1Float{
  0%,100%{transform:translate3d(0,0,0) rotateX(0deg) rotateY(0deg)}
  25%{transform:translate3d(4px,-6px,2px) rotateX(.8deg) rotateY(1deg)}
  50%{transform:translate3d(-5px,-2px,-1px) rotateX(-.5deg) rotateY(-.8deg)}
  75%{transform:translate3d(3px,5px,2px) rotateX(.3deg) rotateY(.6deg)}
}
@keyframes b2Float{
  0%,100%{transform:translate3d(0,0,0) rotateX(0deg) rotateY(0deg)}
  25%{transform:translate3d(-6px,4px,-2px) rotateX(-.6deg) rotateY(-1.5deg)}
  50%{transform:translate3d(3px,7px,1px) rotateX(.8deg) rotateY(.6deg)}
  75%{transform:translate3d(-4px,-3px,2px) rotateX(-.4deg) rotateY(.3deg)}
}
@keyframes b3Float{
  0%,100%{transform:translate3d(0,0,0) rotateX(0deg) rotateY(0deg)}
  30%{transform:translate3d(6px,-5px,-2px) rotateX(1.2deg) rotateY(-.8deg)}
  60%{transform:translate3d(-4px,6px,3px) rotateX(-.8deg) rotateY(1.2deg)}
  90%{transform:translate3d(5px,-3px,-1px) rotateX(.3deg) rotateY(-.5deg)}
}
@keyframes b4Float{
  0%,100%{transform:translate3d(0,0,0) rotateX(0deg) rotateY(0deg)}
  25%{transform:translate3d(-3px,-7px,1px) rotateX(-.6deg) rotateY(1.2deg)}
  50%{transform:translate3d(6px,3px,-3px) rotateX(.8deg) rotateY(-.8deg)}
  75%{transform:translate3d(-5px,5px,2px) rotateX(-.3deg) rotateY(.6deg)}
}
@keyframes b5Float{
  0%,100%{transform:translate3d(0,0,0) rotateX(0deg) rotateY(0deg)}
  25%{transform:translate3d(-5px,-4px,3px) rotateX(-.8deg) rotateY(.5deg)}
  50%{transform:translate3d(5px,6px,-2px) rotateX(.6deg) rotateY(-1.2deg)}
  75%{transform:translate3d(-3px,-5px,1px) rotateX(.3deg) rotateY(.3deg)}
}
@keyframes b6Float{
  0%,100%{transform:translate3d(0,0,0) rotateX(0deg) rotateY(0deg)}
  30%{transform:translate3d(5px,6px,-2px) rotateX(.6deg) rotateY(-.8deg)}
  55%{transform:translate3d(-6px,-3px,2px) rotateX(-.8deg) rotateY(1.2deg)}
  80%{transform:translate3d(3px,-6px,1px) rotateX(.4deg) rotateY(-.3deg)}
}
.hf-ico{
  width:26px;height:26px;border-radius:7px;
  display:flex;align-items:center;justify-content:center;flex-shrink:0;
  transition:all .35s var(--spring);
}
.hf-badge:hover .hf-ico{transform:scale(1.12) rotate(-3deg)}
.hf-ico-green{background:rgba(16,185,129,.1);color:#10b981}
.hf-ico-blue{background:rgba(21,101,255,.1);color:var(--blue)}
.hf-ico-gold{background:rgba(234,179,8,.1);color:#eab308}
.hf-ico-purple{background:rgba(139,92,246,.1);color:#8b5cf6}
.hf-ico-rose{background:rgba(244,63,94,.1);color:#f43f5e}
.hf-lw{position:relative;width:7px;height:7px;flex-shrink:0}
.hf-ld{width:7px;height:7px;border-radius:50%;background:#10b981;box-shadow:0 0 8px rgba(16,185,129,.4);animation:livePulse 1.8s ease-in-out infinite}
.hf-lr{position:absolute;inset:-3px;border-radius:50%;border:1.5px solid rgba(16,185,129,.12);animation:liveRing 2s ease-out infinite}
.hf-txt{font-family:var(--font-b);font-size:11px;font-weight:600;color:var(--sub);letter-spacing:.1px;white-space:nowrap;line-height:1.15}
.hf-txt strong{color:var(--text);font-weight:700}
.hf-txt .em{color:var(--blue);font-weight:700}
@keyframes livePulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.7;transform:scale(.85)}}
@keyframes liveRing{0%{transform:scale(1);opacity:1}100%{transform:scale(2.2);opacity:0}}
@media(max-width:1300px){.hf-scene{width:38%}}
@media(max-width:1100px){.hf-scene{width:32%}}
@media(max-width:1024px){.hf-scene{display:none}}

/* ═══════════════════════════════════════════════════
   PAIN SECTION
   ═══════════════════════════════════════════════════ */
.pain-inner{display:grid;grid-template-columns:1fr 1fr;gap:90px;align-items:center}
.frustration-list{display:flex;flex-direction:column;gap:2px}
.frust-item{
  display:flex;align-items:center;gap:18px;
  padding:18px 0;border-bottom:1px solid var(--border);
  transition:transform .3s var(--spring),background .3s;
  padding-left:0;padding-right:0;border-radius:0;
}
.frust-item:hover{transform:translateX(6px)}
.frust-icon{
  width:42px;height:42px;border-radius:14px;
  background:rgba(255,80,80,.06);border:1px solid rgba(255,80,80,.12);
  display:flex;align-items:center;justify-content:center;flex-shrink:0;
  transition:transform .3s var(--spring),background .3s;
}
.frust-item:hover .frust-icon{transform:scale(1.1);background:rgba(255,80,80,.1)}
.frust-text{font-size:14px;font-weight:500;color:var(--sub)}

/* ═══════════════════════════════════════════════════
   SERVICES GRID
   ═══════════════════════════════════════════════════ */
.svc-grid{
  display:grid;grid-template-columns:repeat(3,1fr);
  gap:1px;background:var(--border-accent);
  margin-top:76px;
  border:1px solid var(--border-accent);
  border-radius:var(--r-xl);overflow:hidden;
}
.svc-card{
  background:var(--card);padding:44px 36px;
  position:relative;overflow:hidden;
  transition:background .5s,transform .6s var(--spring),box-shadow .5s;
  cursor:default;transform-style:preserve-3d;
}
.svc-card::before{
  content:'';position:absolute;top:0;left:0;right:0;height:2px;
  background:var(--border);
  opacity:0;transition:opacity .4s;
}
.svc-card:hover{background:var(--bg3)}
.svc-card:hover::before{opacity:1}
.svc-num{font-family:var(--font-b);font-size:10px;font-weight:600;color:var(--sub);letter-spacing:1.5px;margin-bottom:26px}
.svc-ico{
  width:58px;height:58px;
  background:rgba(255,255,255,.04);border:1px solid var(--border);
  border-radius:18px;display:flex;align-items:center;justify-content:center;
  margin-bottom:22px;transition:all .4s var(--spring);flex-shrink:0;
}
.svc-card:hover .svc-ico{
  background:rgba(255,255,255,.06);
  transform:scale(1.08) rotate(-4deg);
}
.svc-title{font-family:var(--font-h);font-size:18px;font-weight:700;color:var(--text);margin-bottom:12px;line-height:1.3}
.svc-desc{font-size:13px;color:var(--sub);line-height:1.8}
.svc-arrow{
  position:absolute;top:26px;right:26px;width:34px;height:34px;
  border-radius:50%;border:1px solid var(--border);
  display:flex;align-items:center;justify-content:center;
  transition:all .35s var(--spring);
}
.svc-card:hover .svc-arrow{
  background:var(--bg3);
  border-color:var(--border);color:var(--text);
  transform:rotate(45deg);
}

/* ═══════════════════════════════════════════════════
   INDUSTRIES - SLIDER
   ═══════════════════════════════════════════════════ */
.ind-slider-wrap{position:relative;margin-top:66px}
.ind-slider{display:flex;gap:14px;overflow-x:auto;scroll-snap-type:x mandatory;scroll-behavior:smooth;padding:6px 4px 16px;scrollbar-width:none;-ms-overflow-style:none}
.ind-slider::-webkit-scrollbar{display:none}
.ind-card{
  flex:0 0 150px;scroll-snap-align:start;
  background:var(--card);border:1px solid var(--border);border-radius:var(--r-lg);
  padding:28px 12px;display:flex;flex-direction:column;align-items:center;gap:12px;
  transition:all .4s var(--spring);cursor:default;
}
.ind-card:hover{border-color:var(--border);background:var(--bg3);box-shadow:0 4px 16px rgba(0,0,0,.2)}
.ind-ico{
  width:52px;height:52px;
  background:rgba(255,255,255,.03);border:1px solid var(--border);
  border-radius:50%;display:flex;align-items:center;justify-content:center;
  flex-shrink:0;transition:all .35s var(--spring);
}
.ind-card:hover .ind-ico{background:rgba(255,255,255,.06);border-color:var(--border)}
.ind-label{font-family:var(--font-b);font-size:11px;font-weight:600;color:var(--sub);text-align:center;line-height:1.35}
.ind-arrow{position:absolute;top:50%;transform:translateY(-50%);z-index:2;width:40px;height:40px;border-radius:50%;background:var(--card);border:1px solid var(--border);color:var(--text);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .3s var(--spring);opacity:0;pointer-events:none}
.ind-slider-wrap:hover .ind-arrow{opacity:1;pointer-events:auto}
.ind-arrow:hover{background:var(--bg3);border-color:var(--border)}
.ind-arrow.prev{left:-10px}
.ind-arrow.next{right:-10px}
@media(max-width:768px){.ind-card{flex:0 0 130px;padding:22px 10px}.ind-arrow{display:none}}

/* ═══════════════════════════════════════════════════
   PROCESS
   ═══════════════════════════════════════════════════ */
.process-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:22px;margin-top:66px;position:relative}
.process-card{
  background:var(--card);border:1px solid var(--border);
  border-radius:var(--r-xl);padding:40px 30px;
  transition:all .4s var(--spring);transform-style:preserve-3d;
  position:relative;z-index:1;
}
.process-card:hover{
  border-color:var(--border);
}
.process-num{
  font-family:var(--font-h);
  font-size:clamp(60px,6vw,96px);font-weight:900;
  color:var(--sub);
  line-height:1;margin-bottom:14px;
  opacity:.15;
}
.process-title{font-family:var(--font-h);font-size:17px;font-weight:700;color:var(--text);margin-bottom:12px}
.process-desc{font-size:13.5px;color:var(--sub);line-height:1.8}

/* ═══════════════════════════════════════════════════
   TESTIMONIALS
   ═══════════════════════════════════════════════════ */
.testi-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin-top:66px}
.testi-card{
  background:var(--card);border:1px solid var(--border);
  border-radius:var(--r-xl);padding:40px;
  transition:all .4s var(--spring);transform-style:preserve-3d;position:relative;
}
.testi-card::before{
  content:'\201C';position:absolute;top:18px;right:26px;
  font-size:80px;font-family:Georgia,serif;
  color:var(--border);line-height:1;pointer-events:none;
}
.testi-card:hover{border-color:var(--border)}
.testi-stars{font-size:16px;color:var(--sub);margin-bottom:20px;letter-spacing:3px}
.testi-quote{font-size:14px;color:var(--sub);line-height:1.85;margin-bottom:26px;font-style:italic;position:relative;z-index:1}
.testi-avatar{
  width:46px;height:46px;border-radius:50%;overflow:hidden;
  border:2px solid var(--border);flex-shrink:0;
  transition:border-color .3s,transform .3s var(--spring);
}
.testi-card:hover .testi-avatar{border-color:var(--text);transform:scale(1.1)}
.testi-avatar img{width:100%;height:100%;object-fit:cover}
.testi-name{font-family:var(--font-h);font-size:14px;font-weight:700;color:var(--text)}
.testi-role{font-size:12px;color:var(--sub)}

/* ═══════════════════════════════════════════════════
   PORTFOLIO HOME
   ═══════════════════════════════════════════════════ */
.port-grid-home{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:60px}
.port-home-card{background:var(--card);border:1px solid var(--border);border-radius:var(--r-xl);overflow:hidden;display:block;text-decoration:none;transition:all .4s var(--spring)}
.port-home-card:hover{border-color:var(--border)}
.port-home-img{width:100%;height:200px;overflow:hidden}
.port-home-img img{width:100%;height:100%;object-fit:cover;transition:transform .6s var(--ease)}
.port-home-card:hover .port-home-img img{transform:scale(1.08)}
.port-home-body{padding:20px 22px 24px}
.port-home-tag{font-family:var(--font-h);font-size:10px;font-weight:600;color:var(--sub);background:rgba(255,255,255,.03);border:1px solid var(--border);padding:3px 10px;border-radius:100px;display:inline-block;margin-bottom:8px;letter-spacing:.3px;text-transform:uppercase}
.port-home-title{font-family:var(--font-h);font-size:16px;font-weight:700;color:var(--text);margin-bottom:6px;line-height:1.3}
.port-home-desc{font-size:13px;color:var(--sub);line-height:1.7}
@media(max-width:768px){.port-grid-home{grid-template-columns:1fr}}

/* ═══════════════════════════════════════════════════
   BLOG HOME
   ═══════════════════════════════════════════════════ */
.blog-grid-home{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin-top:66px}
.blog-card{
  background:var(--card);border:1px solid var(--border);
  border-radius:var(--r-xl);overflow:hidden;
  transition:all .4s var(--spring);display:block;
  transform-style:preserve-3d;
}
.blog-card:hover{
  border-color:var(--border);
}
.blog-card-img{
  height:210px;background:var(--bg3);
  display:flex;align-items:center;justify-content:center;
  border-bottom:1px solid var(--border);overflow:hidden;position:relative;
}
.blog-card-img::after{
  content:'';position:absolute;inset:0;
  background:linear-gradient(to top,rgba(5,5,8,.5),transparent 50%);
  pointer-events:none;transition:opacity .3s;
}
.blog-card:hover .blog-card-img::after{opacity:0}
.blog-card-img img{width:100%;height:100%;object-fit:cover;transition:transform .7s var(--ease)}
.blog-card:hover .blog-card-img img{transform:scale(1.08)}
.blog-card-body{padding:30px}
.blog-cat{font-family:var(--font-b);font-size:10px;font-weight:700;color:var(--sub);letter-spacing:1.2px;text-transform:uppercase;margin-bottom:12px}
.blog-title{font-family:var(--font-h);font-size:18px;font-weight:700;color:var(--text);line-height:1.3;margin-bottom:12px;transition:color .2s}
.blog-card:hover .blog-title{color:var(--text)}
.blog-excerpt{font-size:13px;color:var(--sub);line-height:1.75;margin-bottom:20px}
.blog-meta{font-size:11px;color:var(--sub);display:flex;align-items:center;gap:10px;opacity:.5}

/* ═══════════════════════════════════════════════════
   CTA
   ═══════════════════════════════════════════════════ */
.cta-sec{position:relative;overflow:hidden;padding:160px 64px;text-align:center;background:var(--bg)}
.cta-bg{position:absolute;inset:0;
  background:radial-gradient(ellipse 60% 80% at 50% 50%,rgba(255,255,255,.02),transparent);
}
.cta-bg-img{
  position:absolute;inset:0;
  background:url('<?= site_img('home_cta', '/assets/images/cta-work.jpg') ?>') center/cover no-repeat;
  opacity:.04;transition:opacity .6s;
}
.cta-sec:hover .cta-bg-img{opacity:.07}
.cta-grid-el{
  position:absolute;inset:0;
  background-image:linear-gradient(rgba(255,255,255,.015) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.015) 1px,transparent 1px);
  background-size:64px 64px;
  mask-image:radial-gradient(ellipse 80% 80% at 50% 50%,#000 20%,transparent 100%);
}
.cta-orb{
  position:absolute;border-radius:50%;
  background:radial-gradient(circle,rgba(255,255,255,.025),transparent 70%);
  animation:float 7s ease-in-out infinite;pointer-events:none;
}
.cta-orb-1{width:340px;height:340px;top:10%;left:10%;animation-delay:0s}
.cta-orb-2{width:240px;height:240px;bottom:10%;right:15%;animation-delay:2.5s}
.cta-orb-3{width:180px;height:180px;top:50%;left:60%;animation-delay:5s}
.cta-title{
  font-family:var(--font-h);font-weight:900;
  font-size:clamp(38px,6.5vw,86px);
  line-height:1.04;letter-spacing:-2px;
  color:var(--text);margin-bottom:22px;
  position:relative;z-index:2;
}
.cta-title .em{
  background:linear-gradient(135deg,var(--blue),var(--blue2));
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;
  background-clip:text;
}
.cta-sub{font-size:16px;color:var(--sub);line-height:1.85;max-width:520px;margin:0 auto 56px;position:relative;z-index:2}
.cta-btns{display:flex;gap:16px;justify-content:center;flex-wrap:wrap;position:relative;z-index:2}
.btn-white{
  display:inline-flex;align-items:center;gap:10px;
  background:var(--text);color:var(--bg);
  padding:17px 36px;border-radius:100px;
  font-family:var(--font-b);font-size:14px;font-weight:700;
  transition:all .35s var(--spring);
  box-shadow:0 4px 24px rgba(0,0,0,.25);
}
.btn-white:hover{box-shadow:0 10px 36px rgba(0,0,0,.35)}
.btn-ghost{
  display:inline-flex;align-items:center;gap:10px;
  background:transparent;color:var(--text);
  padding:16px 36px;border-radius:100px;
  border:1.5px solid var(--border);
  font-family:var(--font-b);font-size:14px;font-weight:600;
  transition:all .35s var(--spring);
}
.btn-ghost:hover{
  background:rgba(255,255,255,.04);border-color:var(--border);
}

/* ═══════════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════════ */
@media(max-width:1200px){.ind-grid{grid-template-columns:repeat(4,1fr)}}
@media(max-width:1024px){
  .hero{padding:110px 28px 90px}
  .hero-scroll{display:none}
  .pain-inner{grid-template-columns:1fr;gap:48px}
  .svc-grid{grid-template-columns:1fr 1fr}
  .ind-grid{grid-template-columns:repeat(3,1fr)}
  .process-grid{grid-template-columns:1fr 1fr}
  .testi-grid{grid-template-columns:1fr 1fr}
  .blog-grid-home{grid-template-columns:1fr 1fr}
  .cta-sec{padding:100px 28px}
}
@media(max-width:640px){
  .hero-h1{font-size:clamp(36px,10vw,56px);letter-spacing:-1px}
  .hero-stats{gap:14px}
  .stat{padding:14px 18px}
  .stat-n{font-size:30px}
  .hero-actions{flex-direction:column;align-items:flex-start}
  .svc-grid{grid-template-columns:1fr}
  .ind-grid{grid-template-columns:repeat(2,1fr)}
  .process-grid{grid-template-columns:1fr}
  .testi-grid{grid-template-columns:1fr}
  .blog-grid-home{grid-template-columns:1fr}
  .cta-btns{flex-direction:column;align-items:center}
  .cta-sec{padding:80px 20px}
  .hero{padding:90px 20px 70px}
}
</style>

<!-- HERO -->
<section class="hero" id="home">
  <div class="hero-bg">
    <div class="hero-grid"></div>
    <div class="hero-glow"></div>
    <div class="hero-glow2"></div>
    <canvas id="particles-canvas" style="position:absolute;inset:0;z-index:0;pointer-events:none"></canvas>
  </div>

  <div class="hero-content">
    <div class="hero-badge"><span class="badge-dot"></span>Digital Marketing Agency in Pakistan</div>
    <h1 class="hero-h1">
      Helping Businesses Generate More <span class="word-em">Leads,</span> <span class="word-outline">Sales &amp; Revenue.</span>
    </h1>
    <p class="hero-desc">We help businesses grow through <strong>SEO, Google Ads, Meta Ads, Web Design, AI Automation,</strong> and Performance Marketing &mdash; with full transparency, no lock-in contracts, and results you can actually measure.</p>
    <div class="hero-actions">
      <a href="/contact.php" class="btn-primary">
        Book a Free Strategy Call
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3 7h8M7 3l4 4-4 4" stroke="#0a0a10" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </a>
      <a href="/services.php" class="btn-outline">Get a Free SEO Audit &rarr;</a>
    </div>
    <div class="hero-stats">
      <div class="stat"><div class="stat-n counter" data-t="250">250+</div><div class="stat-l">Projects Delivered</div></div>
      <div class="stat"><div class="stat-n counter" data-t="180">180+</div><div class="stat-l">Happy Clients</div></div>
      <div class="stat"><div class="stat-n">340%</div><div class="stat-l">Avg. Revenue Growth</div></div>
      <div class="stat"><div class="stat-n counter" data-t="8">8+</div><div class="stat-l">Years of Experience</div></div>
    </div>
  </div>
  <!-- Hero 3D Constellation Badges -->
  <div class="hf-scene" id="hfScene">
    <svg class="hf-svg" id="hfSvg"></svg>
    <div class="hf-badge hf-b1" onclick="location.href='/contact.php'" title="Book a free strategy call">
      <div class="hf-lw"><div class="hf-ld"></div><div class="hf-lr"></div></div>
      <span class="hf-txt"><strong>Available</strong> for projects</span>
    </div>
    <div class="hf-badge hf-b2" onclick="location.href='/services.php'" title="Get a free SEO audit">
      <div class="hf-ico hf-ico-blue">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      </div>
      <span class="hf-txt"><strong>Free</strong> SEO Audit</span>
    </div>
    <div class="hf-badge hf-b3" onclick="location.href='/contact.php'" title="Book a strategy call">
      <div class="hf-ico hf-ico-purple">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
      </div>
      <span class="hf-txt"><strong>Book a Call</strong></span>
    </div>
    <div class="hf-badge hf-b4" onclick="location.href='/portfolio.php'" title="View our portfolio">
      <div class="hf-ico hf-ico-gold">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
      </div>
      <span class="hf-txt"><strong>180+</strong> Happy Clients</span>
    </div>
    <div class="hf-badge hf-b5" onclick="location.href='/#results'" title="See our results">
      <div class="hf-ico hf-ico-green">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
      </div>
      <span class="hf-txt"><strong>340%</strong> Avg. Growth</span>
    </div>
    <div class="hf-badge hf-b6" onclick="location.href='/about.php'" title="Learn about us">
      <div class="hf-ico hf-ico-rose">
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
      </div>
      <span class="hf-txt"><strong>No Lock-in</strong> Contracts</span>
    </div>
  </div>
  <div class="hero-scroll"><span class="scroll-line"></span>Scroll to explore</div>
</section>

<!-- MARQUEE -->
<div class="marquee-wrap">
  <div class="marquee-track">
    <?php $mqi=['SEO Optimization','Google Ads','Meta Ads Management','Web Design & Development','AI Automation','E-Commerce Solutions','Performance Marketing','Lead Generation','Brand Strategy','Shopify Development'];foreach(array_merge($mqi,$mqi) as $item):?>
    <span class="mq-item"><span class="mq-sep"></span><?=h($item)?></span>
    <?php endforeach;?>
  </div>
</div>

<!-- PAIN SECTION -->
<section class="sec" style="background:var(--bg);overflow:hidden" id="pain">
  <div style="position:absolute;inset:0;background:radial-gradient(ellipse 60% 60% at 80% 50%,rgba(255,255,255,.015),transparent);pointer-events:none"></div>
  <div class="pain-inner">
    <div class="reveal-l">
      <div class="sec-label">The Problem</div>
      <h2 class="sec-h">Tired of Agencies That <span class="em">Over-Promise</span> and Under-Deliver?</h2>
      <p class="sec-sub">Many businesses spend money on SEO, Google Ads, and web development without seeing measurable results. Sound familiar?</p>
    </div>
    <div class="reveal-r">
      <div class="frustration-list">
        <?php foreach(['Wasting budget on ads with zero ROI','Poor Google rankings despite investing in SEO','Low-quality leads that never convert into sales','No transparency or plain-English reporting from your agency','Slow website driving away potential customers'] as $i=>$f):?>
        <div class="frust-item"<?=$i===4?' style="border-bottom:none"':''?>>
          <div class="frust-icon">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
              <circle cx="8" cy="8" r="7" stroke="#ff5555" stroke-width="1.5"/>
              <path d="M8 4.5v4M8 11.5v.5" stroke="#ff5555" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
          <span class="frust-text"><?=h($f)?></span>
        </div>
        <?php endforeach;?>
      </div>
    </div>
  </div>
</section>

<!-- SERVICES PREVIEW -->
<section class="sec" style="background:var(--bg2)" id="services">
  <div style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:24px">
    <div>
      <div class="sec-label reveal">What We Do</div>
      <h2 class="sec-h reveal">Everything You Need to<br><span class="em">Succeed Online.</span></h2>
      <p class="sec-sub reveal">Complete, custom solutions tailored to your specific business goals.</p>
    </div>
    <a href="/services.php" class="btn-primary reveal" style="flex-shrink:0;margin-bottom:20px">View All Services &rarr;</a>
  </div>
  <div class="svc-grid stagger-grid">
    <?php
    $svcs=[
      ['01','SEO Optimization','Having a beautiful website means nothing if nobody finds it. We optimise from the inside out so search engines love you.',
       '<circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M3 12h18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M12 3c-3 3.5-3 9.5 0 18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M12 3c3 3.5 3 9.5 0 18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>'],
      ['02','Digital Advertising','Put your brand in front of people already eager to buy. Every dollar turns into measurable revenue.',
       '<rect x="2" y="4" width="20" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M2 9h20" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M6 15h4M14 15h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>'],
      ['03','E-Commerce Solutions','From Shopify to Amazon — we make buying fast, secure, and easy, and reduce abandoned carts.',
       '<path d="M6 2L3 7v13a2 2 0 002 2h14a2 2 0 002-2V7l-3-5z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M3 7h18" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M16 11a4 4 0 01-8 0" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>'],
      ['04','Web Design &amp; Dev','High-performing, mobile-first websites that run flawlessly. No slow pages, no glitches.',
       '<rect x="2" y="3" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 21h8M12 17v4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M7 9l3 3-3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M13 15h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>'],
      ['05','Performance Marketing','Storytelling-style creatives that stop the scroll, paired with hyper-targeted audience data.',
       '<rect x="2" y="2" width="20" height="20" rx="3" stroke="currentColor" stroke-width="1.6"/><path d="M3 17l5-6 4 4 4-5 4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>'],
      ['06','Brand Strategy','We understand your business DNA and architect a custom digital ecosystem that converts.',
       '<circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M4 20a8 8 0 0116 0" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>'],
    ];
    foreach($svcs as $s):?>
    <div class="svc-card shimmer-card reveal">
      <div class="svc-arrow">
        <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 10L10 2M4 2h6v6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </div>
      <div class="svc-num"><?=$s[0]?></div>
      <div class="svc-ico">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><?=$s[3]?></svg>
      </div>
      <div class="svc-title"><?=$s[1]?></div>
      <div class="svc-desc"><?=$s[2]?></div>
    </div>
    <?php endforeach;?>
  </div>
</section>

<!-- WHO WE SERVE -->
<section class="sec" style="background:var(--bg)" id="industries">
  <div class="sec-center">
    <div class="sec-label reveal">Industries</div>
    <h2 class="sec-h reveal">We Serve <span class="em">Every</span> Industry</h2>
    <p class="sec-sub reveal">From schools to salons, real estate to restaurants &mdash; we proudly serve businesses across every sector.</p>
  </div>
  <div class="ind-slider-wrap">
    <div class="ind-slider" id="indSlider">
      <?php
      $inds=[
        ['Education','<path d="M12 2L2 7l10 5 10-5-10-5z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M2 17l10 5 10-5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M2 12l10 5 10-5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>'],
        ['FMCG &amp; Retail','<path d="M6 2L3 7v13a2 2 0 002 2h14a2 2 0 002-2V7l-3-5z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M3 7h18" stroke="currentColor" stroke-width="1.6"/>'],
        ['Health Care','<path d="M12 2a10 10 0 100 20A10 10 0 0012 2z" stroke="currentColor" stroke-width="1.6"/><path d="M12 8v8M8 12h8" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>'],
        ['Jewellers','<path d="M12 2l3 6h6l-5 4 2 7-6-4-6 4 2-7-5-4h6z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>'],
        ['Real Estate','<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 22V12h6v10" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>'],
        ['Banking &amp; Finance','<rect x="2" y="5" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M2 10h20" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M6 15h2M10 15h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>'],
        ['B2B','<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M23 21v-2a4 4 0 00-3-3.87" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M16 3.13a4 4 0 010 7.75" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>'],
        ['E-Commerce','<path d="M5 5h14l-1.5 9h-11z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M3 3H1" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><circle cx="9" cy="20" r="1.5" fill="currentColor"/><circle cx="15" cy="20" r="1.5" fill="currentColor"/>'],
        ['Salon &amp; Beauty','<circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M4 20a8 8 0 0116 0" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>'],
        ['Restaurants','<path d="M18 8h1a4 4 0 010 8h-1" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M6 2v4M10 2v4M14 2v4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>'],
        ['Travel &amp; Tourism','<circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.6"/><path d="M2 12h20M12 2a15 15 0 010 20M12 2a15 15 0 000 20" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>'],
        ['Immigration &amp; IELTS','<rect x="2" y="4" width="20" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M12 4v16M2 12h7M15 12h7" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>'],
        ['Automotive','<rect x="2" y="7" width="20" height="12" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M4 7l3-4h10l3 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><circle cx="7" cy="17" r="2" stroke="currentColor" stroke-width="1.4"/><circle cx="17" cy="17" r="2" stroke="currentColor" stroke-width="1.4"/>'],
        ['Legal &amp; Consulting','<path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 2v6h6M8 13h8M8 17h5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>'],
        ['Construction','<path d="M3 22V8l9-6 9 6v14H3z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><rect x="9" y="13" width="6" height="9" stroke="currentColor" stroke-width="1.4" rx="1"/>'],
        ['SaaS &amp; Tech','<rect x="2" y="3" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.6"/><path d="M8 21h8M12 17v4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/><path d="M7 9l3 3-3 3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>'],
        ['Gaming &amp; Media','<polygon points="5,3 19,12 5,21" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/>'],
        ['Home Services','<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 22V12h6v10" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>'],
      ];
      foreach($inds as $ind):?>
      <div class="ind-card">
        <div class="ind-ico">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><?=$ind[1]?></svg>
        </div>
        <div class="ind-label"><?=$ind[0]?></div>
      </div>
      <?php endforeach;?>
    </div>
    <button class="ind-arrow prev" onclick="document.getElementById('indSlider').scrollBy({left:-340,behavior:'smooth'})">‹</button>
    <button class="ind-arrow next" onclick="document.getElementById('indSlider').scrollBy({left:340,behavior:'smooth'})">›</button>
  </div>
</section>

<!-- PORTFOLIO -->
<section class="sec" style="background:var(--bg2)" id="portfolio">
  <div class="sec-center reveal">
    <div class="sec-label">Our Work</div>
    <h2 class="sec-h">Featured <span class="em">Projects</span></h2>
    <p class="sec-sub">Real campaigns, real results. A peek at what we've delivered for our clients.</p>
  </div>
  <div class="port-grid-home stagger-grid">
    <a href="/portfolio.php" class="port-home-card reveal shimmer-card">
      <div class="port-home-img"><img loading="lazy" src="<?= site_img('home_portfolio_1', '/assets/images/svc-seo.jpg') ?>" alt="Project" loading="lazy"></div>
      <div class="port-home-body">
        <div class="port-home-tag">SEO</div>
        <div class="port-home-title">E-Commerce SEO Overhaul</div>
        <div class="port-home-desc">340% organic traffic increase for a fashion brand.</div>
      </div>
    </a>
    <a href="/portfolio.php" class="port-home-card reveal shimmer-card">
      <div class="port-home-img">        <img loading="lazy" src="<?= site_img('home_portfolio_2', '/assets/images/svc-web.jpg') ?>" alt="Project" loading="lazy"></div>
      <div class="port-home-body">
        <div class="port-home-tag">Web Design</div>
        <div class="port-home-title">Custom Web Platform</div>
        <div class="port-home-desc">98 Lighthouse score, 52% lead conversion increase.</div>
      </div>
    </a>
    <a href="/portfolio.php" class="port-home-card reveal shimmer-card">
      <div class="port-home-img"><img loading="lazy" src="<?= site_img('home_portfolio_3', '/assets/images/svc-ads.jpg') ?>" alt="Project" loading="lazy"></div>
      <div class="port-home-body">
        <div class="port-home-tag">Paid Ads</div>
        <div class="port-home-title">Google Ads ROI Engine</div>
        <div class="port-home-desc">Scaled ad spend from $12k to $84k at 6.2x ROAS.</div>
      </div>
    </a>
  </div>
  <div class="sec-center reveal" style="margin-top:40px">
    <a href="/portfolio.php" class="btn-outline">View All Projects →</a>
  </div>
</section>

<!-- HOW WE WORK -->
<section class="sec" style="background:var(--bg2)" id="process">
  <div class="sec-center">
    <div class="sec-label reveal">How We Work</div>
    <h2 class="sec-h reveal">Simple Process. <span class="em">Real Results.</span></h2>
    <p class="sec-sub reveal">From first call to measurable growth &mdash; here is exactly how we work.</p>
  </div>
  <div class="process-grid stagger-grid">
    <?php $steps=[
      ['01','Discovery Call','We learn about your business, goals, target audience, and current challenges. No jargon, no pushy sales tactics.'],
      ['02','Custom Strategy','We build a tailored roadmap specific to your business. Every tactic is chosen based on your data, not a copy-paste template.'],
      ['03','Execution & Launch','Our team gets to work. You will see real-time progress and have a dedicated point of contact throughout.'],
      ['04','Report & Optimise','We send plain-English monthly reports showing exactly what moved, what we learned, and what we are doing next.'],
    ];foreach($steps as $s):?>
    <div class="process-card reveal">
      <div class="process-num"><?=$s[0]?></div>
      <div class="process-title"><?=h($s[1])?></div>
      <div class="process-desc"><?=h($s[2])?></div>
    </div>
    <?php endforeach;?>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="sec" style="background:var(--bg)" id="results">
  <div class="sec-center">
    <div class="sec-label reveal">Client Results</div>
    <h2 class="sec-h reveal">Real Businesses. <span class="em">Real Growth.</span></h2>
    <p class="sec-sub reveal">Here is what our clients say after working with Nexos.</p>
  </div>
  <div class="testi-grid stagger-grid">
    <?php $testimonials=[
      ['We went from page 5 on Google to the number one spot for our main keyword in under 4 months. The SEO team at Nexos is genuinely the best investment we have made.','Bilal Tariq','CEO, TechFusion PK',site_img('home_testimonial_1','/assets/images/client-bilal.jpg')],
      ['Our Meta Ads were burning money before Nexos. They rebuilt everything from scratch. Within 6 weeks we were getting 4x the leads at half the cost.','Aisha Malik','Founder, Luxe Interiors',site_img('home_testimonial_2','/assets/images/client-aisha.jpg')],
      ['What sets Nexos apart is the transparency. I actually understand where my money is going and what it is doing. Monthly reports are clear and honest.','Hamza Rehman','Director, GreenBuild Solutions',site_img('home_testimonial_3','/assets/images/client-hamza.jpg')],
    ];foreach($testimonials as $t):?>
    <div class="testi-card reveal">
      <div class="testi-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
      <p class="testi-quote">"<?=h($t[0])?>"</p>
      <div style="display:flex;align-items:center;gap:14px">
        <div class="testi-avatar"><img src="<?=$t[3]?>" alt="<?=h($t[1])?>"></div>
        <div>
          <div class="testi-name"><?=h($t[1])?></div>
          <div class="testi-role"><?=h($t[2])?></div>
        </div>
      </div>
    </div>
    <?php endforeach;?>
  </div>
</section>

<!-- CTA -->
<section class="cta-sec">
  <div class="cta-bg"></div>
  <div class="cta-bg-img"></div>
  <div class="cta-grid-el"></div>
  <div class="cta-orb cta-orb-1"></div>
  <div class="cta-orb cta-orb-2"></div>
  <div class="cta-orb cta-orb-3"></div>
  <div class="sec-label reveal" style="margin:0 auto 24px">Start Growing Today</div>
  <h2 class="cta-title reveal">Stop Guessing.<br>Start <span class="em">Scaling.</span></h2>
  <p class="cta-sub reveal">Book a free 30-minute strategy call. We will audit your current digital presence and show you exactly where the biggest growth opportunities are.</p>
  <div class="cta-btns reveal">
    <a href="/contact.php" class="btn-white">
      Start a Project
      <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M3 7h8M7 3l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </a>
    <a href="/contact.php" class="btn-ghost">
      <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M13 9.9v2a1.3 1.3 0 01-1.45 1.3 13.2 13.2 0 01-5.75-2.03 13 13 0 01-4-4 13.2 13.2 0 01-2.03-5.78A1.3 1.3 0 012.1 0h2a1.3 1.3 0 011.3 1.1c.08.64.24 1.27.47 1.87a1.3 1.3 0 01-.3 1.4L4.6 5.4a10.4 10.4 0 004 4l.97-.97a1.3 1.3 0 011.41-.3c.6.23 1.23.39 1.87.47A1.3 1.3 0 0113 9.9Z" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
      Book a Call
    </a>
  </div>
</section>

<!-- LATEST BLOG -->
<?php if(!empty($latestPosts)):?>
<section class="sec" style="background:var(--bg2)">
  <div class="sec-center">
    <div class="sec-label reveal">Insights</div>
    <h2 class="sec-h reveal">Latest from the <span class="em">Blog</span></h2>
    <p class="sec-sub reveal">Expert insights, growth strategies, and digital marketing wisdom.</p>
  </div>
  <div class="blog-grid-home stagger-grid">
    <?php foreach($latestPosts as $post):?>
    <a href="/blog/<?=h($post['slug'])?>" class="blog-card reveal">
      <div class="blog-card-img">
        <?php if($post['cover_image']):?>
          <img src="/uploads/blog/<?=h($post['cover_image'])?>" alt="<?=h($post['title'])?>">
        <?php else:?>
          <svg width="48" height="48" viewBox="0 0 48 48" fill="none"><rect x="4" y="8" width="40" height="28" rx="4" stroke="rgba(255,255,255,.15)" stroke-width="2"/><path d="M12 28l8-10 6 7 5-5 7 8" stroke="rgba(255,255,255,.15)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        <?php endif;?>
      </div>
      <div class="blog-card-body">
        <?php if($post['cat_name']):?><div class="blog-cat"><?=h($post['cat_name'])?></div><?php endif;?>
        <div class="blog-title"><?=h($post['title'])?></div>
        <div class="blog-excerpt"><?=h($post['excerpt']?:excerpt($post['content']))?></div>
        <div class="blog-meta">
          <span><?=date('M j, Y',strtotime($post['created_at']))?></span>
          <span>&middot;</span>
          <span><?=number_format($post['views'])?> views</span>
        </div>
      </div>
    </a>
    <?php endforeach;?>
  </div>
  <div style="text-align:center;margin-top:48px"><a href="/blog.php" class="btn-outline">Read All Posts &rarr;</a></div>
</section>
<?php endif;?>

<script>
/* PARTICLES - optimised: dots only, no O(n²) line connections */
(function(){
  var canvas=document.getElementById('particles-canvas');
  if(!canvas)return;
  var ctx=canvas.getContext('2d');
  var W,H,pts=[];
  var raf;
  function rsz(){W=canvas.width=canvas.offsetWidth;H=canvas.height=canvas.offsetHeight;}
  rsz();
  window.addEventListener('resize',function(){rsz();init();},{passive:true});
  function init(){
    pts=[];
    /* Fewer particles — 1 per 18000px² instead of 12000 */
    var count=Math.min(Math.floor(W*H/18000),60);
    for(var i=0;i<count;i++){
      pts.push({x:Math.random()*W,y:Math.random()*H,vx:(Math.random()-.5)*.2,vy:(Math.random()-.5)*.2,r:Math.random()*.8+.3,op:Math.random()*.25+.04,hue:Math.random()>.7?43:220});
    }
  }
  init();
  function draw(){
    ctx.clearRect(0,0,W,H);
    for(var i=0;i<pts.length;i++){
      var p=pts[i];
      p.x+=p.vx;p.y+=p.vy;
      if(p.x<0)p.x=W;else if(p.x>W)p.x=0;
      if(p.y<0)p.y=H;else if(p.y>H)p.y=0;
      ctx.beginPath();
      ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
      ctx.fillStyle='hsla('+p.hue+',60%,'+(p.hue===43?'55%':'65%')+','+p.op+')';
      ctx.fill();
    }
    raf=requestAnimationFrame(draw);
  }
  /* Pause particles when tab is hidden to save CPU */
  document.addEventListener('visibilitychange',function(){
    if(document.hidden){cancelAnimationFrame(raf);}
    else{draw();}
  });
  draw();
})();
/* CONSTELLATION LINES - connect floating badges */
(function(){
  var scene=document.getElementById('hfScene');
  var svg=document.getElementById('hfSvg');
  if(!scene||!svg||window.innerWidth<=1024)return;
  var badges=scene.querySelectorAll('.hf-badge');
  var pairs=[[0,1],[0,2],[1,2],[1,3],[2,3],[2,4],[3,4],[3,5],[4,5]];
  var lines=[];
  var rafC;
  for(var i=0;i<pairs.length;i++){
    var line=document.createElementNS('http://www.w3.org/2000/svg','line');
    svg.appendChild(line);lines.push(line);
  }
  function upd(){
    var sr=scene.getBoundingClientRect();
    for(var i=0;i<pairs.length;i++){
      var b1=badges[pairs[i][0]],b2=badges[pairs[i][1]];
      var r1=b1.getBoundingClientRect(),r2=b2.getBoundingClientRect();
      var x1=r1.left+r1.width/2-sr.left,y1=r1.top+r1.height/2-sr.top;
      var x2=r2.left+r2.width/2-sr.left,y2=r2.top+r2.height/2-sr.top;
      lines[i].setAttribute('x1',x1);lines[i].setAttribute('y1',y1);
      lines[i].setAttribute('x2',x2);lines[i].setAttribute('y2',y2);
    }
    rafC=requestAnimationFrame(upd);
  }
  upd();
  /* Hover highlight */
  for(var i=0;i<badges.length;i++){
    (function(idx){
      badges[idx].addEventListener('mouseenter',function(){
        for(var j=0;j<lines.length;j++){
          if(pairs[j][0]===idx||pairs[j][1]===idx)lines[j].classList.add('active');
        }
      });
      badges[idx].addEventListener('mouseleave',function(){
        for(var j=0;j<lines.length;j++)lines[j].classList.remove('active');
      });
    })(i);
  }
  /* Pause when hidden */
  document.addEventListener('visibilitychange',function(){
    if(document.hidden){cancelAnimationFrame(rafC);}
    else{upd();}
  });
})();
/* CARD SPOTLIGHT */
var svcCards=document.querySelectorAll('.svc-card');
for(var i=0;i<svcCards.length;i++){(function(card){card.addEventListener('mousemove',function(e){var r=card.getBoundingClientRect();card.style.setProperty('--mx',((e.clientX-r.left)/r.width*100)+'%');card.style.setProperty('--my',((e.clientY-r.top)/r.height*100)+'%');});})(svcCards[i]);}
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
