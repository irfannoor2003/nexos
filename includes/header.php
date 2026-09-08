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
    html{font-size:16px}
    html.lenis, html.lenis body {height: auto; width: 100%;}
    .lenis.lenis-smooth {scroll-behavior: auto !important;}
    .lenis.lenis-smooth [data-lenis-prevent] {overscroll-behavior: contain;}
    .lenis.lenis-stopped {overflow: hidden;}
    .lenis.lenis-scrolling iframe {pointer-events: none;}
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
      background:linear-gradient(90deg,var(--blue),var(--blue2));
      border-radius:0 2px 2px 0;
      transition:width .1s linear;
      pointer-events:none;
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
    .back-to-top:hover{background:var(--blue);color:#fff;box-shadow:0 8px 32px var(--blue-glow);transform:translateY(-3px);}

    /* ── CUSTOM CURSOR ── */
    .cur{
      position:fixed;top:0;left:0;width:6px;height:6px;
      background:var(--text);border-radius:50%;
      pointer-events:none;z-index:99999;
      transform:translate(-50%,-50%);
      transition:width .2s,height .2s,background .2s;
      mix-blend-mode:difference;
    }
    .cur-ring{
      position:fixed;top:0;left:0;width:36px;height:36px;
      border:1.5px solid rgba(255,255,255,.25);border-radius:50%;
      pointer-events:none;z-index:99998;
      transform:translate(-50%,-50%);
      transition:width .4s var(--spring),height .4s var(--spring),border-color .4s,opacity .4s;
    }
    body.h-cur .cur{width:12px;height:12px;background:var(--blue)}
    body.h-cur .cur-ring{width:52px;height:52px;border-color:rgba(21,101,255,.4)}
    @media(max-width:1024px){.cur,.cur-ring{display:none!important}}

    /* ── GLOBAL ICON COLOR FIX ── */
    .svc-ico,.ind-ico,.why-ico,.price-icon,.mission-ico,.stat-box-icon,.val-ico,
    .svc-ico-big,.process-card-icon,.svc-card-icon,.cinfo-ico,.detail-ico,
    .detail-card-icon,.feature-dot,.form-ico-wrap{color:var(--blue2)}
    .svc-ico svg,.ind-ico svg,.why-ico svg,.price-icon svg,.mission-ico svg,
    .stat-box-icon svg,.val-ico svg,.svc-ico-big svg,.process-card-icon svg,
    .svc-card-icon svg,.cinfo-ico svg,.detail-ico svg,.detail-card-icon svg,
    .feature-dot svg,.form-ico-wrap svg{color:var(--blue2)}
    .success-icon{color:#10b981}
    .success-icon svg{color:#10b981}

    ::-webkit-scrollbar{width:4px}
    ::-webkit-scrollbar-track{background:var(--bg)}
    ::-webkit-scrollbar-thumb{background:rgba(255,255,255,.12);border-radius:4px}
    ::-webkit-scrollbar-thumb:hover{background:var(--blue)}

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
    .hamburger{display:none;flex-direction:column;gap:5px;padding:10px 8px;z-index:510}
    .hamburger span{display:block;width:22px;height:2px;background:var(--text);border-radius:3px;transition:all .35s var(--spring);transform-origin:center}
    .hamburger.active span:nth-child(1){transform:translateY(7px) rotate(45deg)}
    .hamburger.active span:nth-child(2){width:14px;opacity:0;transform:scaleX(0)}
    .hamburger.active span:nth-child(3){transform:translateY(-7px) rotate(-45deg)}
    .mob-overlay{
      position:fixed;inset:0;z-index:504;
      background:rgba(0,0,0,.55);backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);
      opacity:0;pointer-events:none;transition:opacity .45s var(--ease);
    }
    .mob-overlay.open{opacity:1;pointer-events:auto}
    .mob-menu{
      position:fixed;top:0;right:0;bottom:0;z-index:505;
      width:min(400px,92vw);
      background:linear-gradient(180deg,var(--bg2) 0%,var(--bg) 100%);
      border-left:1px solid var(--border-accent);
      display:flex;flex-direction:column;
      padding:26px 30px 30px;
      overflow-y:auto;overflow-x:hidden;
      transform:translateX(105%);
      transition:transform .55s var(--premium);
      box-shadow:var(--shadow-xl);
      visibility:hidden;
    }
    .mob-menu.open{transform:translateX(0);visibility:visible}
    .mob-menu::before{
      content:'';position:absolute;inset:0;pointer-events:none;
      background:radial-gradient(ellipse 80% 50% at 100% 0%,rgba(21,101,255,.06),transparent 70%);
    }
    .mob-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:38px;position:relative;z-index:1}
    .mob-head-logo img{height:32px;width:auto;transition:transform .3s var(--spring)}
    .mob-head-logo:hover img{transform:scale(1.04)}
    .mob-close{
      width:42px;height:42px;border-radius:12px;border:1px solid var(--border);
      display:flex;align-items:center;justify-content:center;color:var(--sub);
      background:var(--card);transition:all .3s var(--spring);flex-shrink:0;
    }
    .mob-close:hover{color:var(--text);border-color:var(--text);transform:rotate(90deg)}
    .mob-links{display:flex;flex-direction:column;list-style:none;margin-bottom:auto;position:relative;z-index:1}
    .mob-link{
      display:flex;align-items:center;gap:18px;
      padding:17px 2px;border-bottom:1px solid var(--border);
      font-family:var(--font-h);font-size:clamp(22px,5.5vw,26px);font-weight:700;color:var(--sub);
      text-decoration:none;position:relative;
      transform:translateX(52px);opacity:0;transition:none;
    }
    .mob-menu.open .mob-link{transform:translateX(0);opacity:1}
    .mob-menu.open .mob-link:nth-child(1){transition:transform .55s var(--premium) .10s,opacity .45s .10s,color .3s,border-color .3s}
    .mob-menu.open .mob-link:nth-child(2){transition:transform .55s var(--premium) .16s,opacity .45s .16s,color .3s,border-color .3s}
    .mob-menu.open .mob-link:nth-child(3){transition:transform .55s var(--premium) .22s,opacity .45s .22s,color .3s,border-color .3s}
    .mob-menu.open .mob-link:nth-child(4){transition:transform .55s var(--premium) .28s,opacity .45s .28s,color .3s,border-color .3s}
    .mob-menu.open .mob-link:nth-child(5){transition:transform .55s var(--premium) .34s,opacity .45s .34s,color .3s,border-color .3s}
    .mob-menu.open .mob-link:nth-child(6){transition:transform .55s var(--premium) .40s,opacity .45s .40s,color .3s,border-color .3s}
    .mob-link:hover,.mob-link.active{color:var(--text);transform:translateX(4px)!important}
    .mob-link.active::after{
      content:'';position:absolute;left:-2px;top:50%;transform:translateY(-50%);
      width:3px;height:26px;border-radius:3px;
      background:linear-gradient(180deg,var(--blue),var(--blue2));
    }
    .mob-meta{font-size:10px;font-weight:600;letter-spacing:1.4px;color:var(--blue2);font-family:var(--font-b);min-width:22px}
    .mob-arrow{margin-left:auto;opacity:0;transform:translateX(-8px);transition:all .3s var(--spring);font-size:15px;color:var(--blue2)}
    .mob-link:hover .mob-arrow{opacity:1;transform:translateX(0)}
    .mob-foot{margin-top:34px;padding-top:26px;border-top:1px solid var(--border);position:relative;z-index:1}
    .mob-contact{display:flex;flex-direction:column;gap:10px;margin:22px 0}
    .mob-contact a{font-size:13px;color:var(--sub);font-family:var(--font-b);transition:color .3s;display:flex;align-items:center;gap:10px}
    .mob-contact a:hover{color:var(--blue2)}
    .mob-social{display:flex;gap:10px}
    .mob-social a{
      width:40px;height:40px;border-radius:11px;border:1px solid var(--border);
      display:flex;align-items:center;justify-content:center;color:var(--sub);
      background:var(--card);transition:all .3s var(--spring);
    }
    .mob-social a:hover{color:#fff;background:var(--blue);border-color:var(--blue);transform:translateY(-3px);box-shadow:0 8px 20px var(--blue-glow)}

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

    /* ── REVEAL ANIMATIONS (GSAP-controlled, no CSS transition to avoid jitter) ── */
    /* Content is visible by default; GSAP drives all reveal effects from JS. */
    .reveal,.reveal-l,.reveal-r{opacity:1;transform:none}
    .reveal.vis,.reveal-l.vis,.reveal-r.vis{opacity:1;transform:none}

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
      background:var(--bg3);
      border-top:1px solid var(--border-accent);
      padding:0;position:relative;overflow:hidden;
    }
    footer::before{
      content:'';position:absolute;top:0;left:0;right:0;height:1px;
      background:linear-gradient(90deg,transparent,var(--blue),transparent);
    }
    footer::after{
      content:'';position:absolute;width:700px;height:700px;border-radius:50%;
      bottom:-350px;left:50%;transform:translateX(-50%);
      background:radial-gradient(circle,rgba(21,101,255,.06),transparent 70%);
      pointer-events:none;
    }
    .footer-cta{
      position:relative;padding:56px 64px 44px;
      text-align:center;border-bottom:1px solid var(--border);
      background:linear-gradient(180deg,rgba(21,101,255,.04),transparent);
    }
    .footer-cta h3{
      font-family:var(--font-h);font-weight:800;
      font-size:clamp(28px,3.4vw,44px);letter-spacing:-1px;
      color:var(--text);margin-bottom:14px;
    }
    .footer-cta h3 span{
      background:linear-gradient(135deg,var(--blue),var(--blue2));
      -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
    }
    .footer-cta p{font-size:14px;color:var(--sub);margin-bottom:26px;max-width:520px;margin-left:auto;margin-right:auto}
    .footer-cta-btns{display:flex;gap:14px;justify-content:center;flex-wrap:wrap}
    .footer-main{
      position:relative;padding:56px 64px 40px;
      max-width:1400px;margin:0 auto;
      display:grid;grid-template-columns:1.6fr 1fr 1fr 1.4fr;gap:48px;
    }
    .footer-brand .footer-logo{display:inline-block;margin-bottom:20px;transition:transform .3s var(--spring)}
    .footer-brand .footer-logo:hover{transform:scale(1.05)}
    .footer-brand .footer-logo img{height:38px;width:auto}
    .footer-desc{font-size:13.5px;color:var(--sub);line-height:1.85;max-width:300px;margin-bottom:24px}
    .footer-tag{display:inline-flex;align-items:center;gap:8px;padding:6px 14px;border-radius:100px;background:rgba(21,101,255,.08);border:1px solid rgba(21,101,255,.18);font-size:10px;font-weight:600;letter-spacing:.8px;text-transform:uppercase;color:var(--blue2)}
    .footer-tag .dot{width:6px;height:6px;border-radius:50%;background:var(--blue2);animation:pulse 1.4s infinite}
    .footer-col h4{
      font-family:var(--font-b);font-size:10px;font-weight:700;
      color:var(--text);letter-spacing:1.6px;text-transform:uppercase;
      margin-bottom:24px;position:relative;padding-bottom:12px;
    }
    .footer-col h4::after{content:'';position:absolute;bottom:0;left:0;width:28px;height:2px;background:linear-gradient(90deg,var(--blue),transparent);border-radius:2px}
    .footer-col ul{list-style:none;display:flex;flex-direction:column;gap:12px}
    .footer-col a{font-size:13.5px;color:var(--sub);transition:all .25s;position:relative;display:inline-block}
    .footer-col a:hover{color:var(--blue2);transform:translateX(5px)}
    .footer-col .footer-more{
      margin-top:4px;font-weight:600;color:var(--blue2);
    }
    .footer-col .footer-more:hover{color:var(--text)}
    .footer-col .f-contact{
      display:flex;align-items:flex-start;gap:11px;
      font-size:13px;color:var(--sub);line-height:1.6;transition:color .25s;
    }
    .footer-col .f-contact a{color:var(--sub)}
    .footer-col .f-contact a:hover{color:var(--blue2);transform:none}
    .footer-col .f-contact:hover .f-c-text,.footer-col .f-contact:hover a{color:var(--blue2)}
    .f-c-ico{
      flex-shrink:0;width:32px;height:32px;border-radius:10px;
      display:flex;align-items:center;justify-content:center;
      background:rgba(21,101,255,.08);border:1px solid rgba(21,101,255,.16);
      color:var(--blue2);margin-top:1px;transition:all .3s var(--spring);
    }
    .footer-col .f-contact:hover .f-c-ico{background:rgba(21,101,255,.16);transform:scale(1.1) rotate(-6deg)}
    .f-c-ico svg{color:var(--blue2)}
    .footer-soc{display:flex;gap:10px;margin-top:18px}
    .soc-btn{
      width:38px;height:38px;border-radius:11px;
      border:1px solid var(--border);
      display:flex;align-items:center;justify-content:center;
      color:var(--sub);transition:all .3s var(--spring);
      background:var(--bg2);cursor:pointer;
    }
    .soc-btn:hover{
      border-color:var(--blue);color:#fff;background:var(--blue);
      transform:translateY(-3px);box-shadow:0 8px 20px var(--blue-glow);
    }
    .footer-bottom{
      position:relative;border-top:1px solid var(--border);
      padding:26px 64px;
      display:flex;justify-content:space-between;align-items:center;gap:20px;flex-wrap:wrap;
      background:var(--bg2);
    }
    .footer-copy{font-size:12px;color:var(--sub)}
    .footer-bottom-links{display:flex;gap:24px;flex-wrap:wrap}
    .footer-bottom-links a{font-size:12px;color:var(--sub);transition:color .25s}
    .footer-bottom-links a:hover{color:var(--blue2)}

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
      .nav-cta{display:none}
      .hamburger{display:flex}
      .footer-cta{padding:44px 28px 36px}
      .footer-main{padding:40px 28px 32px;grid-template-columns:1fr 1fr;gap:36px}
      .footer-bottom{padding:20px 28px}
    }
    @media(max-width:640px){
      .sec{padding:60px 20px}
      .page-hero{padding:120px 20px 70px}
      .footer-cta{padding:36px 20px 30px}
      .footer-main{padding:32px 20px 28px;grid-template-columns:1fr;gap:28px}
      .footer-bottom{flex-direction:column;gap:16px;text-align:center;justify-content:center}
      .footer-bottom-links{justify-content:center}
      .footer-soc{justify-content:center}
      .nav{padding:0 20px;height:68px}
      .nav-logo img{height:28px}
      .nav-right{gap:4px}
      .theme-toggle{width:38px;height:38px;border-radius:11px}
      .back-to-top{bottom:20px;right:20px;width:46px;height:46px}
    }
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollToPlugin.min.js"></script>
  <script src="https://unpkg.com/split-type"></script>
  <script src="https://unpkg.com/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>
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
  <div class="back-to-top" id="backToTop">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 15l-6-6-6 6"/></svg>
  </div>
  <div class="cur" id="cur"></div>
  <div class="cur-ring" id="cur-ring"></div>

  <!-- Mobile Overlay -->
  <div class="mob-overlay" id="mob-overlay" onclick="closeMob()"></div>

  <!-- Mobile Menu -->
  <div class="mob-menu" id="mob-menu">
    <div class="mob-head">
      <a href="/" class="mob-head-logo" onclick="closeMob()">
        <img class="logo-dark" src="<?= site_img('logo', '/assets/images/logo.png') ?>" alt="Nexos">
        <img class="logo-light" src="<?= site_img('logo_light', '/assets/images/logo-light.png') ?>" alt="Nexos">
      </a>
      <button class="mob-close" onclick="closeMob()" aria-label="Close menu">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
      </button>
    </div>

    <nav class="mob-links">
      <a href="/" class="mob-link<?= $activePage==='home' ? ' active' : '' ?>" onclick="closeMob()">
        <span class="mob-meta">01</span><span>Home</span><span class="mob-arrow">&rarr;</span>
      </a>
      <a href="/services.php" class="mob-link<?= $activePage==='services' ? ' active' : '' ?>" onclick="closeMob()">
        <span class="mob-meta">02</span><span>Services</span><span class="mob-arrow">&rarr;</span>
      </a>
      <a href="/portfolio.php" class="mob-link<?= $activePage==='portfolio' ? ' active' : '' ?>" onclick="closeMob()">
        <span class="mob-meta">03</span><span>Portfolio</span><span class="mob-arrow">&rarr;</span>
      </a>
      <a href="/about.php" class="mob-link<?= $activePage==='about' ? ' active' : '' ?>" onclick="closeMob()">
        <span class="mob-meta">04</span><span>About</span><span class="mob-arrow">&rarr;</span>
      </a>
      <a href="/blog.php" class="mob-link<?= $activePage==='blog' ? ' active' : '' ?>" onclick="closeMob()">
        <span class="mob-meta">05</span><span>Blog</span><span class="mob-arrow">&rarr;</span>
      </a>
      <a href="/contact.php" class="mob-link<?= $activePage==='contact' ? ' active' : '' ?>" onclick="closeMob()">
        <span class="mob-meta">06</span><span>Contact</span><span class="mob-arrow">&rarr;</span>
      </a>
    </nav>

    <div class="mob-foot">
      <a href="/contact.php" class="btn-primary" style="width:100%;justify-content:center" onclick="closeMob()">Get Started &rarr;</a>
      <div class="mob-contact">
        <a href="mailto:info@nexosdigitalagency.com">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 6l-10 7L2 6"/></svg>
          info@nexosdigitalagency.com
        </a>
        <a href="tel:+923224313775">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.79 19.79 0 012.08 4.18 2 2 0 014.06 2h3a2 2 0 012 1.72c.13.96.36 1.9.68 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.91.32 1.85.55 2.81.68A2 2 0 0122 16.92z"/></svg>
          +92 322 431 3775
        </a>
      </div>
      <div class="mob-social">
        <a href="https://www.linkedin.com/company/nexos-digital-agency/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5C4.98 4.88 3.87 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5zM.24 8.31h4.52V23H.24V8.31zM8.34 8.31h4.33v2h.06c.6-1.14 2.07-2.34 4.27-2.34 4.57 0 5.41 3.01 5.41 6.92V23h-4.51v-7.13c0-1.7-.03-3.89-2.37-3.89-2.37 0-2.73 1.85-2.73 3.76V23H8.34V8.31z"/></svg>
        </a>
        <a href="https://www.instagram.com/nexosdigitalagency" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><point cx="17.5" cy="6.5"/></svg>
        </a>
        <a href="https://www.facebook.com/share/19VJTk4up6/" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
        </a>
      </div>
    </div>
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
