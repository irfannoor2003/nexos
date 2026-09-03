<?php
$pageTitle  = $pageTitle ?? 'Nexos | Digital Marketing Agency in Pakistan';
$activePage = $activePage ?? 'home';
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=h($pageTitle)?></title>
  <link rel="icon" type="image/x-icon" href="<?= site_img('favicon', '/assets/images/favicon.ico') ?>">
  <link rel="apple-touch-icon" href="<?= site_img('favicon', '/assets/images/favicon.ico') ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    /* ═══════════════════════════════════════════════════
       NEXOS PREMIUM 3D LUXURY DESIGN SYSTEM
       ═══════════════════════════════════════════════════ */

    :root {
      /* ── LUXURY PALETTE ── */
      --gold:#1565FF; --gold2:#4D8DFF; --gold-dim:rgba(255,255,255,.04); --gold-glow:rgba(255,255,255,.04);
      --blue:#1565FF; --blue2:#4D8DFF; --blue-glow:rgba(21,101,255,.22);
      --accent:#8B5CF6; --accent-glow:rgba(139,92,246,.15);

      /* ── SURFACES ── */
      --bg:#050508; --bg2:#0a0a10; --bg3:#101018; --card:#0c0c14;
      --border:rgba(255,255,255,.06); --border-accent:rgba(255,255,255,.08);
      --text:#f0eef5; --sub:rgba(200,195,220,.5);
      --nav-bg:rgba(5,5,8,.85);

      /* ── DEPTH SYSTEM ── */
      --shadow-sm:0 2px 8px rgba(0,0,0,.3),0 1px 3px rgba(0,0,0,.2);
      --shadow-md:0 8px 32px rgba(0,0,0,.4),0 4px 12px rgba(0,0,0,.25);
      --shadow-lg:0 20px 60px rgba(0,0,0,.5),0 8px 24px rgba(0,0,0,.3);
      --shadow-xl:0 32px 80px rgba(0,0,0,.6),0 16px 40px rgba(0,0,0,.35);
      --shadow-gold:0 8px 32px rgba(0,0,0,.15),0 4px 12px rgba(0,0,0,.1);

      /* ── TYPOGRAPHY ── */
      --font-h:'Inter',sans-serif;
      --font-b:'Inter',sans-serif;
      --font-mono:'Inter',monospace;

      /* ── MOTION ── */
      --ease:cubic-bezier(.25,.46,.45,.94);
      --spring:cubic-bezier(.34,1.56,.64,1);
      --premium:cubic-bezier(.16,1,.3,1);
      --r:16px; --r-lg:24px; --r-xl:32px;
    }

    /* ── LIGHT THEME ── */
    [data-theme="light"] {
      --bg:#ffffff; --bg2:#ecebe6; --bg3:#e2e0da; --card:#f4f3ef;
      --border:rgba(0,0,0,.08); --border-accent:rgba(0,0,0,.06);
      --text:#1a1520; --sub:rgba(30,20,40,.65);
      --nav-bg:rgba(242,242,242,.9);
      --blue-glow:rgba(74,124,255,.12);
      --gold-glow:rgba(0,0,0,.06);
      --shadow-sm:0 2px 8px rgba(0,0,0,.06);
      --shadow-md:0 8px 32px rgba(0,0,0,.08);
      --shadow-lg:0 20px 60px rgba(0,0,0,.1);
      --shadow-xl:0 32px 80px rgba(0,0,0,.12);
    }

    *,*::before,*::after{margin:0;padding:0;box-sizing:border-box}
    html{scroll-behavior:smooth;font-size:16px}
    body{
      background:var(--bg);
      color:var(--text);
      font-family:var(--font-b);
      overflow-x:hidden;
      line-height:1.6;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      transition:background .6s var(--ease),color .6s var(--ease);
    }
    a{text-decoration:none;color:inherit}
    img,svg{display:block}
    button{border:none;background:none;cursor:pointer;font-family:inherit}

    /* ── AMBIENT NOISE TEXTURE ── */
    body::before{
      content:'';position:fixed;inset:0;z-index:1;pointer-events:none;
      background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.025'/%3E%3C/svg%3E");
      opacity:.4;
    }
    [data-theme="light"] body::before{opacity:.15}

    /* ── AMBIENT GRADIENT MESH ── */
    body::after{
      content:'';position:fixed;top:-50%;left:-50%;width:200%;height:200%;z-index:0;pointer-events:none;
      background:
        radial-gradient(ellipse 600px 600px at 20% 20%,rgba(255,255,255,.015),transparent),
        radial-gradient(ellipse 500px 500px at 80% 80%,rgba(255,255,255,.01),transparent);
      /* Removed ambientDrift animation - it was repainting a 200%x200% layer every frame */
    }
    @keyframes ambientDrift{0%{transform:translate(0,0) rotate(0deg)}100%{transform:translate(-3%,-2%) rotate(3deg)}}

    /* ── SCROLL PROGRESS ── */
    .scroll-progress{
      position:fixed;top:0;left:0;height:2px;z-index:9999;
      background:var(--blue);
      border-radius:0 2px 2px 0;
      transition:width .1s linear;
    }

    /* ── BACK TO TOP ── */
    .back-to-top{
      position:fixed;bottom:32px;right:32px;z-index:500;width:52px;height:52px;
      border-radius:16px;
      background:linear-gradient(135deg,var(--card),var(--bg3));
      border:1px solid var(--border);
      color:var(--blue);
      display:flex;align-items:center;justify-content:center;
      box-shadow:var(--shadow-md);
      opacity:0;transform:translateY(20px);
      transition:opacity .4s,transform .4s var(--spring);
      pointer-events:none;cursor:pointer;
      backdrop-filter:blur(20px);
    }
    .back-to-top.visible{opacity:1;transform:translateY(0);pointer-events:auto}

    /* ── CUSTOM CURSOR ── */
    @media(max-width:1024px){.cur,.cur-ring{display:none!important}}

    ::-webkit-scrollbar{width:4px}
    ::-webkit-scrollbar-track{background:var(--bg)}
    ::-webkit-scrollbar-thumb{background:var(--sub);border-radius:4px}

    /* ═══════════════════════════════════════════════════
       NAVIGATION
       ═══════════════════════════════════════════════════ */
    .nav{
      position:fixed;top:0;left:0;right:0;z-index:500;
      display:flex;align-items:center;justify-content:space-between;
      padding:0 64px;height:80px;
      transition:background .5s var(--ease),backdrop-filter .5s,box-shadow .5s,border-color .5s;
      border-bottom:1px solid transparent;
    }
    .nav.scrolled{
      background:var(--nav-bg);
      backdrop-filter:blur(32px) saturate(180%);
      -webkit-backdrop-filter:blur(32px) saturate(180%);
      box-shadow:0 1px 0 var(--border),var(--shadow-sm);
      border-bottom-color:var(--border-accent);
    }
    .nav-logo{
      display:flex;align-items:center;
      transition:transform .3s var(--spring);
    }
    .nav-logo:hover{transform:scale(1.05)}
    .nav-logo img{height:36px;width:auto}
    .nav-links{display:flex;align-items:center;gap:40px;list-style:none}
    .nav-links a{
      font-family:var(--font-b);font-size:13px;font-weight:500;
      color:var(--sub);transition:color .3s;letter-spacing:.4px;
      position:relative;padding:4px 0;
    }
    .nav-links a::after{
      content:'';position:absolute;bottom:-2px;left:0;width:0;height:1.5px;
      background:linear-gradient(90deg,var(--blue),var(--blue2));
      border-radius:1px;transition:width .35s var(--spring);
    }
    .nav-links a:hover,.nav-links a.active{color:var(--text)}
    .nav-links a:hover::after,.nav-links a.active::after{width:100%}
    .nav-cta{
      background:var(--blue)!important;
      color:#fff!important;
      padding:11px 28px;border-radius:100px;
      font-family:var(--font-b);font-size:13px;font-weight:600;
      transition:all .35s var(--spring)!important;
      box-shadow:0 4px 20px var(--blue-glow);
      position:relative;overflow:hidden;
    }
    .nav-cta::after{
      content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;
      background:linear-gradient(90deg,transparent,rgba(255,255,255,.15),transparent);
      transition:left .5s;
    }
    .nav-cta:hover{
      box-shadow:0 8px 32px rgba(21,101,255,.4)!important;
    }
    .nav-cta:hover::after{left:100%}
    .nav-right{display:flex;align-items:center;gap:12px}

    /* ── THEME TOGGLE ── */
    .theme-toggle{
      width:42px;height:42px;border-radius:14px;
      border:1px solid var(--border);
      display:flex;align-items:center;justify-content:center;
      color:var(--sub);transition:all .3s var(--spring);
      flex-shrink:0;cursor:pointer;
      background:var(--card);
    }
    .theme-toggle:hover{color:var(--text);transform:rotate(20deg) scale(1.1)}
    .icon-sun,.icon-moon{transition:opacity .3s,transform .3s}
    [data-theme="dark"] .icon-sun{display:none}
    [data-theme="dark"] .icon-moon{display:block}
    [data-theme="light"] .icon-sun{display:block}
    [data-theme="light"] .icon-moon{display:none}
    .logo-light{display:none}
    [data-theme="light"] .logo-dark{display:none}
    [data-theme="light"] .logo-light{display:block}

    /* ── MOBILE MENU ── */
    .hamburger{display:none;flex-direction:column;gap:6px;padding:8px;z-index:510}
    .hamburger span{display:block;width:24px;height:2px;background:var(--text);border-radius:2px;transition:all .3s var(--spring);transform-origin:center}
    .hamburger.active span:nth-child(1){transform:translateY(8px) rotate(45deg)}
    .hamburger.active span:nth-child(2){opacity:0;transform:scaleX(0)}
    .hamburger.active span:nth-child(3){transform:translateY(-8px) rotate(-45deg)}
    .mob-menu{
      display:none;position:fixed;inset:0;z-index:490;
      background:var(--bg);flex-direction:column;align-items:center;justify-content:center;gap:28px;
      opacity:0;transform:translateY(20px);transition:opacity .5s,transform .5s var(--ease);
    }
    .mob-menu.open{display:flex;opacity:1;transform:translateY(0)}
    .mob-menu a{
      font-family:var(--font-h);font-size:32px;font-weight:700;
      color:var(--text);transition:color .2s,transform .2s;transform:translateY(0);
    }
    .mob-menu a:hover{color:var(--text);transform:translateX(8px)}

    /* ═══════════════════════════════════════════════════
       SECTION COMMONS
       ═══════════════════════════════════════════════════ */
    .sec{position:relative;padding:110px 64px}
    .badge-dot{
      width:6px;height:6px;
      background:var(--sub);border-radius:50%;
      animation:pulse 1.4s infinite;display:inline-block;
    }
    .sec-label{
      display:inline-flex;align-items:center;gap:8px;
      padding:7px 18px;border-radius:100px;
      background:rgba(255,255,255,.04);border:1px solid var(--border);
      font-family:var(--font-b);font-size:10px;font-weight:600;
      color:var(--sub);letter-spacing:1.4px;text-transform:uppercase;
      margin-bottom:24px;
    }
    .sec-h{
      font-family:var(--font-h);font-weight:800;
      font-size:clamp(36px,4.8vw,68px);line-height:1.08;
      letter-spacing:-1.5px;color:var(--text);margin-bottom:20px;
    }
    .sec-h .em{
      font-weight:700;
      background:linear-gradient(135deg,var(--blue),var(--blue2));
      -webkit-background-clip:text;-webkit-text-fill-color:transparent;
      background-clip:text;
    }
    .sec-sub{font-size:16px;color:var(--sub);line-height:1.85;max-width:560px}
    .sec-center{text-align:center}
    .sec-center .sec-label{margin:0 auto 24px}
    .sec-center .sec-sub{margin:0 auto}

    /* ── REVEAL ANIMATIONS ── */
    .reveal{opacity:0;transform:translateY(50px);transition:opacity .9s var(--premium),transform .9s var(--premium)}
    .reveal.vis{opacity:1;transform:translateY(0)}
    .reveal-l{opacity:0;transform:translateX(-50px);transition:opacity .9s var(--premium),transform .9s var(--premium)}
    .reveal-l.vis{opacity:1;transform:translateX(0)}
    .reveal-r{opacity:0;transform:translateX(50px);transition:opacity .9s var(--premium),transform .9s var(--premium)}
    .reveal-r.vis{opacity:1;transform:translateX(0)}

    .sec-divider{width:100%;height:1px;background:var(--border);margin:0 auto}

    /* ═══════════════════════════════════════════════════
       BUTTONS
       ═══════════════════════════════════════════════════ */
    .btn-primary{
      display:inline-flex;align-items:center;gap:10px;
      background:var(--blue);
      color:#fff;
      padding:16px 36px;border-radius:100px;
      font-family:var(--font-b);font-size:14px;font-weight:600;
      box-shadow:0 6px 28px var(--blue-glow);
      transition:all .35s var(--spring);
      position:relative;overflow:hidden;
    }
    .btn-primary::before{
      content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;
      background:linear-gradient(90deg,transparent,rgba(255,255,255,.12),transparent);
      transition:left .5s;
    }
    .btn-primary:hover{
      box-shadow:0 12px 40px rgba(21,101,255,.45);
      color:#fff;
    }
    .btn-primary:hover::before{left:100%}

    .btn-outline{
      display:inline-flex;align-items:center;gap:10px;
      background:transparent;color:var(--sub);
      padding:15px 32px;border-radius:100px;
      border:1.5px solid var(--border);
      font-family:var(--font-b);font-size:14px;font-weight:500;
      transition:all .35s var(--spring);
    }
    .btn-outline:hover{
      border-color:var(--blue);color:var(--blue);
      box-shadow:0 8px 32px rgba(21,101,255,.08);
    }

    /* ═══════════════════════════════════════════════════
       PAGE HERO
       ═══════════════════════════════════════════════════ */
    .page-hero{position:relative;padding:170px 64px 110px;overflow:hidden;background:var(--bg)}
    .page-hero-bg{
      position:absolute;inset:0;
      background-image:linear-gradient(rgba(255,255,255,.025) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.025) 1px,transparent 1px);
      background-size:80px 80px;
      mask-image:radial-gradient(ellipse 80% 80% at 50% 40%,#000 30%,transparent 100%);
    }
    .page-hero-glow{
      position:absolute;width:700px;height:700px;
      background:radial-gradient(circle,rgba(255,255,255,.03) 0%,transparent 70%);
      top:-250px;right:-150px;
      animation:breathe 10s ease-in-out infinite;
    }
    .page-hero-content{position:relative;z-index:2;max-width:800px}
    .page-breadcrumb{display:flex;align-items:center;gap:8px;font-size:12px;color:var(--sub);margin-bottom:24px;font-family:var(--font-b)}
    .page-breadcrumb a{color:var(--sub);transition:color .2s}
    .page-breadcrumb a:hover{color:var(--blue2)}
    .page-breadcrumb span{color:rgba(100,100,120,.4)}
    .svc-card-icon{display:flex;align-items:center;justify-content:center;width:48px;height:48px;border-radius:16px;background:rgba(255,255,255,.03);border:1px solid var(--border);margin-bottom:16px;transition:all .35s var(--spring)}
    .svc-card-icon svg{width:24px;height:24px;color:var(--blue2)}
    .card:hover .svc-card-icon{background:rgba(255,255,255,.06);transform:scale(1.12) rotate(-4deg)}

    /* ═══════════════════════════════════════════════════
       FOOTER
       ═══════════════════════════════════════════════════ */
    footer{
      background:var(--bg2);border-top:1px solid var(--border-accent);
      padding:90px 64px 44px;position:relative;
    }
    footer::before{
      content:'';position:absolute;top:0;left:50%;transform:translateX(-50%);
      width:120px;height:1px;
      background:var(--border);
    }
    .footer-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:64px;margin-bottom:72px}
    .footer-logo{
      display:inline-block;
      margin-bottom:18px;
      transition:transform .3s var(--spring);
    }
    .footer-logo:hover{transform:scale(1.05)}
    .footer-logo img{height:36px;width:auto}
    .footer-desc{font-size:13.5px;color:var(--sub);line-height:1.85;max-width:280px}
    .footer-col h4{
      font-family:var(--font-b);font-size:10px;font-weight:700;
      color:var(--text);letter-spacing:1.4px;text-transform:uppercase;
      margin-bottom:22px;
    }
    .footer-col ul{list-style:none;display:flex;flex-direction:column;gap:14px}
    .footer-col a{font-size:13.5px;color:var(--sub);transition:all .25s;position:relative;padding-left:0}
    .footer-col a:hover{color:var(--text);padding-left:6px}
    .footer-bottom{border-top:1px solid var(--border);padding-top:32px;display:flex;justify-content:space-between;align-items:center}
    .footer-copy{font-size:12px;color:var(--sub)}
    .footer-soc{display:flex;gap:10px}
    .soc-btn{
      width:38px;height:38px;border-radius:12px;
      border:1px solid var(--border);
      display:flex;align-items:center;justify-content:center;
      color:var(--sub);transition:all .3s var(--spring);
      background:var(--card);
    }
    .soc-btn:hover{
      border-color:var(--text);color:var(--text);
    }

    /* ── FLASH ── */
    .flash{padding:14px 24px;border-radius:14px;font-size:14px;font-weight:500;margin-bottom:20px}
    .flash-success{background:rgba(16,185,129,.08);border:1px solid rgba(16,185,129,.2);color:#10b981}
    .flash-error{background:rgba(255,80,80,.06);border:1px solid rgba(255,80,80,.15);color:#ff5555}

    /* ═══════════════════════════════════════════════════
       KEYFRAMES
       ═══════════════════════════════════════════════════ */
    @keyframes fadeUp{from{opacity:0;transform:translateY(30px)}to{opacity:1;transform:translateY(0)}}
    @keyframes breathe{0%,100%{transform:scale(1);opacity:.6}50%{transform:scale(1.08);opacity:1}}
    @keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.4;transform:scale(.6)}}
    @keyframes slideInLeft{from{opacity:0;transform:translateX(-60px)}to{opacity:1;transform:translateX(0)}}
    @keyframes slideInRight{from{opacity:0;transform:translateX(60px)}to{opacity:1;transform:translateX(0)}}
    @keyframes scaleIn{from{opacity:0;transform:scale(.9)}to{opacity:1;transform:scale(1)}}
    @keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
    @keyframes shimmer{0%{background-position:-200% 0}100%{background-position:200% 0}}
    @keyframes glow-pulse{0%,100%{box-shadow:0 0 20px transparent}50%{box-shadow:0 0 40px rgba(255,255,255,.05)}}
    @keyframes border-glow{0%,100%{border-color:var(--border)}50%{border-color:var(--border)}}
    @keyframes rotate{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}
    @keyframes textShimmer{0%{background-position:0% 50%}50%{background-position:100% 50%}100%{background-position:0% 50%}}
    @keyframes heroReveal{0%{opacity:0;transform:translateY(40px) scale(.98);filter:blur(6px)}100%{opacity:1;transform:translateY(0) scale(1);filter:blur(0)}}
    @keyframes orbFloat{0%,100%{transform:translate(0,0) scale(1)}25%{transform:translate(15px,-20px) scale(1.05)}50%{transform:translate(-10px,15px) scale(.95)}75%{transform:translate(20px,10px) scale(1.03)}}
    @keyframes premiumPulse{0%,100%{opacity:.6;transform:scale(1)}50%{opacity:1;transform:scale(1.015)}}
    @keyframes slideUp{from{opacity:0;transform:translateY(80px)}to{opacity:1;transform:translateY(0)}}
    @keyframes fadeIn{from{opacity:0}to{opacity:1}}
    @keyframes scaleUp{from{opacity:0;transform:scale(.85)}to{opacity:1;transform:scale(1)}}
    @keyframes glowRotate{0%{filter:hue-rotate(0deg)}100%{filter:hue-rotate(360deg)}}
    @keyframes growHeight{0%{height:0}100%{height:var(--target-height)}}
    @keyframes dashFlow{0%{stroke-dashoffset:200}100%{stroke-dashoffset:0}}
    @keyframes drawLine{0%{stroke-dashoffset:350}to{stroke-dashoffset:0}}
    @keyframes slideIn{0%{opacity:0;transform:translateX(-30px)}to{opacity:1;transform:translateX(0)}}
    @keyframes bounce{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}

    /* ── PREMIUM PAGE LOAD ── */
    .page-loader{position:fixed;inset:0;z-index:99999;background:var(--bg);display:flex;align-items:center;justify-content:center;transition:opacity .3s,visibility .3s}
    .page-loader.loaded{opacity:0;visibility:hidden;pointer-events:none}
    .loader-logo{animation:premiumPulse 1.5s ease-in-out infinite}
    .loader-logo img{height:48px;width:auto}

    /* ── FLOATING ORBS ── */
    .floating-orbs{position:fixed;inset:0;z-index:0;pointer-events:none;overflow:hidden}
    .f-orb{position:absolute;border-radius:50%;filter:blur(80px);animation:orbFloat 20s ease-in-out infinite}
    .f-orb-1{width:400px;height:400px;background:rgba(255,255,255,.015);top:10%;left:5%;animation-delay:0s}
    .f-orb-2{width:300px;height:300px;background:rgba(255,255,255,.01);bottom:15%;right:10%;animation-delay:5s}

    /* ── PREMIUM CARD SHIMMER ── */
    .shimmer-card{position:relative;overflow:hidden}
    .shimmer-card::after{
      content:'';position:absolute;top:0;left:-150%;width:150%;height:100%;
      background:linear-gradient(90deg,transparent,rgba(255,255,255,.02),transparent);
      transition:left .8s;pointer-events:none;
    }
    .shimmer-card:hover::after{left:150%}

    /* ── GLOW BORDER EFFECT ── */
    .glow-border{
      position:relative;
      background:var(--card);
      border:1px solid var(--border);
      border-radius:var(--r-xl);
    }
    .glow-border::before{
      content:'';position:absolute;inset:-1px;
      border-radius:inherit;
      background:linear-gradient(135deg,transparent 30%,rgba(255,255,255,.05) 50%,transparent 70%);
      opacity:0;transition:opacity .5s;z-index:-1;
    }
    .glow-border:hover::before{opacity:1}

    /* ── TEXT GRADIENT ANIMATION ── */
    .text-shimmer{
      background:linear-gradient(90deg,var(--text),var(--border),var(--border),var(--text));
      background-size:300% 100%;
      -webkit-background-clip:text;-webkit-text-fill-color:transparent;
      background-clip:text;
      animation:textShimmer 6s ease-in-out infinite;
    }

    /* ── STAGGERED GRID REVEAL ── */
    .stagger-grid>.reveal:nth-child(1){transition-delay:.05s}
    .stagger-grid>.reveal:nth-child(2){transition-delay:.1s}
    .stagger-grid>.reveal:nth-child(3){transition-delay:.15s}
    .stagger-grid>.reveal:nth-child(4){transition-delay:.2s}
    .stagger-grid>.reveal:nth-child(5){transition-delay:.25s}
    .stagger-grid>.reveal:nth-child(6){transition-delay:.3s}
    .stagger-grid>.reveal:nth-child(7){transition-delay:.35s}
    .stagger-grid>.reveal:nth-child(8){transition-delay:.4s}
    .stagger-grid>.reveal:nth-child(9){transition-delay:.45s}

    /* ═══════════════════════════════════════════════════
       RESPONSIVE
       ═══════════════════════════════════════════════════ */
    @media(max-width:1024px){
      .nav{padding:0 28px}
      .sec{padding:76px 28px}
      .page-hero{padding:140px 28px 90px}
      .nav-links{display:none}
      .hamburger{display:flex}
      footer{padding:64px 28px 36px}
      .footer-grid{grid-template-columns:1fr 1fr;gap:44px}
    }
    @media(max-width:640px){
      .sec{padding:60px 20px}
      .page-hero{padding:120px 20px 70px}
      .footer-grid{grid-template-columns:1fr;gap:36px}
      .footer-bottom{flex-direction:column;gap:16px;text-align:center}
      .nav{padding:0 20px}
      .nav-logo img{height:28px}
      .back-to-top{bottom:20px;right:20px;width:46px;height:46px}
    }
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollToPlugin.min.js"></script>
</head>
<body>
  <!-- Page Loader -->
  <div class="page-loader" id="pageLoader">
    <div class="loader-logo">
      <img class="logo-dark" src="<?= site_img('logo', '/assets/images/logo.png') ?>" alt="Nexos">
      <img class="logo-light" src="<?= site_img('logo_light', '/assets/images/logo-light.png') ?>" alt="Nexos">
    </div>
  </div>

  <!-- Floating Ambient Orbs -->
  <div class="floating-orbs">
    <div class="f-orb f-orb-1"></div>
    <div class="f-orb f-orb-2"></div>
    <div class="f-orb f-orb-3"></div>
  </div>

  <div class="scroll-progress" id="scrollProgress"></div>
  <div class="back-to-top" id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 15l-6-6-6 6"/></svg>
  </div>
  <div class="cur" id="cur"></div>
  <div class="cur-ring" id="cur-ring"></div>

  <!-- Mobile Menu -->
  <div class="mob-menu" id="mob-menu">
    <a href="/" onclick="closeMob()" style="margin-bottom:16px">
      <img class="logo-dark" src="<?= site_img('logo', '/assets/images/logo.png') ?>" alt="Nexos" style="height:40px" loading="lazy">
      <img class="logo-light" src="<?= site_img('logo_light', '/assets/images/logo-light.png') ?>" alt="Nexos" style="height:40px" loading="lazy">
    </a>
    <a href="/" onclick="closeMob()">Home</a>
    <a href="/services.php" onclick="closeMob()">Services</a>
    <a href="/portfolio.php" onclick="closeMob()">Portfolio</a>
    <a href="/about.php" onclick="closeMob()">About</a>
    <a href="/blog.php" onclick="closeMob()">Blog</a>
    <a href="/contact.php" onclick="closeMob()" class="btn-primary" style="font-size:18px;padding:14px 32px;margin-top:16px">Get Started</a>
  </div>

  <!-- Nav -->
  <nav class="nav" id="nav">
    <a href="/" class="nav-logo">
      <img class="logo-dark" src="<?= site_img('logo', '/assets/images/logo.png') ?>" alt="Nexos" fetchpriority="high" width="auto" height="36">
      <img class="logo-light" src="<?= site_img('logo_light', '/assets/images/logo-light.png') ?>" alt="Nexos" fetchpriority="high" width="auto" height="36">
    </a>
    <ul class="nav-links">
      <li><a href="/" <?=$activePage==='home'?'class="active"':''?>>Home</a></li>
      <li><a href="/services.php" <?=$activePage==='services'?'class="active"':''?>>Services</a></li>
      <li><a href="/portfolio.php" <?=$activePage==='portfolio'?'class="active"':''?>>Portfolio</a></li>
      <li><a href="/about.php" <?=$activePage==='about'?'class="active"':''?>>About</a></li>
      <li><a href="/blog.php" <?=$activePage==='blog'?'class="active"':''?>>Blog</a></li>
    </ul>
    <div class="nav-right">
      <button class="theme-toggle" id="themeToggle" title="Toggle theme" aria-label="Toggle dark/light mode">
        <svg class="icon-sun" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
          <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
          <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
          <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
        </svg>
        <svg class="icon-moon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
        </svg>
      </button>
      <a href="/contact.php" class="nav-cta" style="font-family:var(--font-b)">Get Started &rarr;</a>
      <button class="hamburger" id="hamburger" onclick="toggleMob()"><span></span><span></span><span></span></button>
    </div>
  </nav>
