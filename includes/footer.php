<!-- Footer -->
<footer>
  <div class="footer-grid">
    <div>
      <a href="/" class="footer-logo">
        <img class="logo-dark" src="<?= site_img('logo', '/assets/images/logo.png') ?>" alt="Nexos" loading="lazy" width="auto" height="36">
        <img class="logo-light" src="<?= site_img('logo_light', '/assets/images/logo-light.png') ?>" alt="Nexos" loading="lazy" width="auto" height="36">
      </a>
      <p class="footer-desc">Pakistan's results-driven digital agency — SEO, Google Ads, Meta Ads, Web Design, and AI Automation. We help businesses generate more leads, sales, and revenue.</p>
    </div>
    <div class="footer-col">
      <h4>Services</h4>
      <ul>
        <li><a href="/services.php#web">Web Design &amp; Dev</a></li>
        <li><a href="/services.php#seo">SEO Optimization</a></li>
        <li><a href="/services.php#ads">Digital Advertising</a></li>
        <li><a href="/services.php#ecom">E-Commerce</a></li>
        <li><a href="/services.php#ai">AI Automation</a></li>
        <li><a href="/services.php#brand">Brand Strategy</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Company</h4>
      <ul>
        <li><a href="/portfolio.php">Portfolio</a></li>
        <li><a href="/about.php">About Us</a></li>
        <li><a href="/blog.php">Blog</a></li>
        <li><a href="/contact.php">Contact</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Contact</h4>
      <ul>
        <li><a href="mailto:hello@nexosdigital.com">hello@nexosdigital.com</a></li>
        <li><a href="tel:+923001234567">+92 300 123 4567</a></li>
        <li>Mon&ndash;Fri, 9AM&ndash;6PM PKT</li>
        <li>Lahore, Pakistan</li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="footer-copy">&copy; <?=date('Y')?> Nexos Digital. All rights reserved.</div>
    <div class="footer-soc">
      <a href="#" class="soc-btn" title="LinkedIn" aria-label="LinkedIn">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="4"/><line x1="8" y1="11" x2="8" y2="17"/><line x1="8" y1="7" x2="8" y2="7.5"/><path d="M12 11v6M12 11a3 3 0 016 0v6"/></svg>
      </a>
      <a href="#" class="soc-btn" title="Instagram" aria-label="Instagram">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
      </a>
      <a href="#" class="soc-btn" title="Facebook" aria-label="Facebook">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
      </a>
    </div>
  </div>
</footer>

<script>
/* ═══════════════════════════════════════════════════
   NEXOS PREMIUM INTERACTIONS
   ═══════════════════════════════════════════════════ */

/* PAGE LOADER - hide immediately on DOMContentLoaded, no artificial delay */
(function(){
  var loader=document.getElementById('pageLoader');
  if(!loader)return;
  if(document.readyState==='loading'){
    document.addEventListener('DOMContentLoaded',function(){loader.classList.add('loaded');});
  } else {
    loader.classList.add('loaded');
  }
})();

/* SCROLL PROGRESS */
var scrollProgress=document.getElementById('scrollProgress');
var backToTop=document.getElementById('backToTop');
window.addEventListener('scroll',function(){
  var scrollTop=document.documentElement.scrollTop||document.body.scrollTop;
  var scrollHeight=document.documentElement.scrollHeight-document.documentElement.clientHeight;
  var progress=scrollTop/scrollHeight*100;
  if(scrollProgress)scrollProgress.style.width=progress+'%';
  if(backToTop){
    if(scrollTop>400){backToTop.classList.add('visible')}
    else{backToTop.classList.remove('visible')}
  }
},{passive:true});

/* CURSOR - Premium cursor with smooth ring */
var cur=document.getElementById('cur'),ring=document.getElementById('cur-ring');
if(cur&&ring&&window.innerWidth>1024){
  var mx=0,my=0,rx=0,ry=0;
  document.addEventListener('mousemove',function(e){mx=e.clientX;my=e.clientY;cur.style.left=mx+'px';cur.style.top=my+'px';});
  (function a(){rx+=(mx-rx)*.08;ry+=(my-ry)*.08;ring.style.left=rx+'px';ring.style.top=ry+'px';requestAnimationFrame(a)})();
  var allInteractive=document.querySelectorAll('a,button,.svc-card,.blog-card,.testi-card,.price-card,.team-card,.val-card,.ind-card,.process-card,.faq-card,.why-card,.stat-box,.mission-card,.tl-content,.port-grid-card');
  for(var i=0;i<allInteractive.length;i++){
    allInteractive[i].addEventListener('mouseenter',function(){document.body.classList.add('h-cur')});
    allInteractive[i].addEventListener('mouseleave',function(){document.body.classList.remove('h-cur')});
  }
}

/* NAV SCROLL - Premium glass effect */
var nav=document.getElementById('nav');
window.addEventListener('scroll',function(){
  if(nav)nav.classList.toggle('scrolled',window.scrollY>40);
});

/* MOBILE */
function toggleMob(){
  var mob=document.getElementById('mob-menu');
  var ham=document.getElementById('hamburger');
  mob.classList.toggle('open');
  ham.classList.toggle('active');
  document.body.style.overflow=mob.classList.contains('open')?'hidden':'';
}
function closeMob(){
  var mob=document.getElementById('mob-menu');
  var ham=document.getElementById('hamburger');
  mob.classList.remove('open');
  ham.classList.remove('active');
  document.body.style.overflow='';
}

/* REVEAL ON SCROLL - GSAP ScrollTrigger */
gsap.registerPlugin(ScrollTrigger);
var revealEls=document.querySelectorAll('.reveal,.reveal-l,.reveal-r');
revealEls.forEach(function(el,idx){
  var dir=el.classList.contains('reveal-l')?-1:el.classList.contains('reveal-r')?1:0;
  /* Cap stagger at 300ms max - prevents elements deep in page having absurd delays */
  var delay=+(el.dataset.delay)||Math.min(idx*60,300);
  gsap.fromTo(el,{opacity:0,y:dir===0?30:0,x:dir?dir*40:0},{opacity:1,y:0,x:0,duration:.75,delay:delay/1000,ease:'power3.out',scrollTrigger:{trigger:el,start:'top 92%',toggleActions:'play none none none'},onUpdate:function(){el.dataset.gsap=el.style.transform||''}});
});

/* MAGNETIC BUTTONS - Premium smooth follow */
var magBtns=document.querySelectorAll('.btn-primary,.nav-cta,.btn-white,.btn-ghost,.form-submit');
for(var m=0;m<magBtns.length;m++){
  (function(btn){
    btn.style.transition='transform .2s cubic-bezier(.25,.46,.45,.94)';
    btn.addEventListener('mousemove',function(e){
      if(!btn.dataset.gsap){btn.dataset.gsap=btn.style.transform||''}
      var r=btn.getBoundingClientRect();
      var x=e.clientX-r.left-r.width/2;
      var y=e.clientY-r.top-r.height/2;
      btn.style.transform='translate('+(x*.15)+'px,'+(y*.15)+'px) scale(1.02)';
    });
    btn.addEventListener('mouseleave',function(){
      btn.style.transform=btn.dataset.gsap||'';
      btn.dataset.gsap='';
    });
  })(magBtns[m]);
}

/* 3D TILT EFFECT - pauses while scrolling to prevent jitter */
var tiltCards=document.querySelectorAll('.svc-card,.testi-card,.price-card,.team-card,.val-card,.ind-card,.process-card,.blog-card,.stat-box,.mission-card,.why-card,.faq-card,.port-grid-card');
var tiltScrolling=false, tiltTimer;
window.addEventListener('scroll',function(){
  tiltScrolling=true;
  clearTimeout(tiltTimer);
  tiltTimer=setTimeout(function(){tiltScrolling=false},150);
},{passive:true});
for(var t=0;t<tiltCards.length;t++){
  (function(card){
    card.style.transition='transform .08s cubic-bezier(.25,.46,.45,.94)';
    card.addEventListener('mousemove',function(e){
      if(tiltScrolling)return;
      if(!card.dataset.gsap){card.dataset.gsap=card.style.transform||''}
      var r=card.getBoundingClientRect();
      var x=(e.clientX-r.left)/r.width-.5;
      var y=(e.clientY-r.top)/r.height-.5;
      card.style.transform='perspective(1000px) rotateY('+(x*8)+'deg) rotateX('+(-y*8)+'deg)';
      card.style.setProperty('--mx',((e.clientX-r.left)/r.width*100)+'%');
      card.style.setProperty('--my',((e.clientY-r.top)/r.height*100)+'%');
    });
    card.addEventListener('mouseleave',function(){
      if(tiltScrolling)return;
      card.style.transition='transform .5s cubic-bezier(.25,.46,.45,.94)';
      card.style.transform=card.dataset.gsap||'';
      card.dataset.gsap='';
      setTimeout(function(){card.style.transition=''},600);
    });
  })(tiltCards[t]);
}

/* SMOOTH PARALLAX ON HERO GLOW */
var heroGlow=document.querySelector('.hero-glow');
if(heroGlow){
  window.addEventListener('scroll',function(){
    var s=window.scrollY;
    heroGlow.style.transform='translate('+(s*.025)+'px,'+(-250+s*.05)+'px)';
  },{passive:true});
}

/* COUNTER ANIMATION - GSAP ScrollTrigger */
var counters=document.querySelectorAll('.counter');
counters.forEach(function(el){
  if(el.dataset.done)return;
  el.dataset.done='1';
  ScrollTrigger.create({
    trigger:el,start:'top 80%',
    onEnter:function(){
      var target=+el.dataset.t;
      var obj={v:0};
      gsap.to(obj,{v:target,duration:2,ease:'power4.out',onUpdate:function(){el.textContent=Math.floor(obj.v)+'+'},onComplete:function(){el.textContent=target+'+'}});
    }
  });
});

/* THEME TOGGLE */
(function(){
  var root=document.documentElement;
  var btn=document.getElementById('themeToggle');
  var saved=localStorage.getItem('nexos-theme')||'dark';
  root.setAttribute('data-theme',saved);
  if(btn){
    btn.addEventListener('click',function(){
      var next=root.getAttribute('data-theme')==='dark'?'light':'dark';
      root.setAttribute('data-theme',next);
      localStorage.setItem('nexos-theme',next);
    });
  }
})();

/* PREMIUM SMOOTH SCROLL for anchor links - GSAP */
document.querySelectorAll('a[href^="#"]').forEach(function(anchor){
  anchor.addEventListener('click',function(e){
    var target=document.querySelector(this.getAttribute('href'));
    if(target){
      e.preventDefault();
      gsap.to(window,{duration:1.4,scrollTo:{y:target,offsetY:80},ease:'power4.inOut'});
    }
  });
});

/* PARALLAX SCROLL on multiple elements */
var parallaxEls=document.querySelectorAll('.hero-glow,.hero-glow2,.page-hero-glow,.cta-orb');
window.addEventListener('scroll',function(){
  var s=window.scrollY;
  for(var i=0;i<parallaxEls.length;i++){
    var speed=.02+(i*.01);
    parallaxEls[i].style.transform='translateY('+(-s*speed)+'px)';
  }
},{passive:true});

/* TILT MAGNETISM - cards subtly attract toward cursor */
var magnetCards=document.querySelectorAll('.svc-card,.testi-card,.price-card,.blog-card,.port-grid-card');
for(var mc=0;mc<magnetCards.length;mc++){
  (function(card){
    card.style.transition='box-shadow .3s cubic-bezier(.25,.46,.45,.94)';
    card.addEventListener('mousemove',function(e){
      if(tiltScrolling)return;
      var r=card.getBoundingClientRect();
      var cx=r.left+r.width/2;
      var cy=r.top+r.height/2;
      var dx=(e.clientX-cx)*.01;
      var dy=(e.clientY-cy)*.01;
      card.style.boxShadow=dx+'px '+dy+'px 40px rgba(255,255,255,.03)';
    });
    card.addEventListener('mouseleave',function(){
      card.style.boxShadow='';
    });
  })(magnetCards[mc]);
}

/* SMOOTH SECTION TRANSITIONS - only animate sections below the fold */
var sections=document.querySelectorAll('.sec:not([data-no-fade]),.cta-sec,.page-hero,.about-hero,.svc-hero,.contact-hero,.post-hero');
sections.forEach(function(sec){
  var rect=sec.getBoundingClientRect();
  if(rect.top<window.innerHeight){
    /* Already visible on load — show immediately */
    sec.style.opacity='1';sec.style.transform='none';
    return;
  }
  gsap.fromTo(sec,{opacity:0,y:24},{opacity:1,y:0,duration:.9,ease:'power3.out',scrollTrigger:{trigger:sec,start:'top 88%',toggleActions:'play none none none'}});
});

/* TEXT REVEAL - split text into words, animate immediately */
function splitTextToChars(el){
  var text=el.textContent.trim();
  el.innerHTML='';
  var words=text.split(' ');
  for(var w=0;w<words.length;w++){
    if(w>0){el.appendChild(document.createTextNode(' '));}
    var wordSpan=document.createElement('span');
    wordSpan.style.display='inline-block';
    wordSpan.style.opacity='0';
    wordSpan.style.transform='translateY(14px)';
    wordSpan.style.transition='opacity .3s '+(w*.04)+'s ease,transform .3s '+(w*.04)+'s ease';
    wordSpan.textContent=words[w];
    el.appendChild(wordSpan);
  }
}
var heroH1=document.querySelector('.hero-h1');
if(heroH1){
  splitTextToChars(heroH1);
  requestAnimationFrame(function(){requestAnimationFrame(function(){
    var chars=heroH1.querySelectorAll('span');
    for(var c=0;c<chars.length;c++){chars[c].style.opacity='1';chars[c].style.transform='translateY(0)';}
  });});
}

/* GLOW TRAIL - cursor leaves a subtle glow trail */
if(window.innerWidth>1024){
  var trail=document.createElement('div');
  trail.style.cssText='position:fixed;width:200px;height:200px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,.015),transparent 70%);pointer-events:none;z-index:0;transition:transform .3s cubic-bezier(.25,.46,.45,.94),opacity .3s';
  document.body.appendChild(trail);
  document.addEventListener('mousemove',function(e){
    trail.style.transform='translate('+(e.clientX-100)+'px,'+(e.clientY-100)+'px)';
  });
}

/* NUMBER COUNT UP - GSAP ScrollTrigger */
var numContainers=document.querySelectorAll('[data-count-group]');
numContainers.forEach(function(container){
  ScrollTrigger.create({
    trigger:container,start:'top 80%',
    onEnter:function(){
      var nums=container.querySelectorAll('[data-count]');
      nums.forEach(function(num,idx){
        var target=parseInt(num.dataset.count);
        var obj={v:0};
        gsap.to(obj,{v:target,duration:1.8,delay:idx*0.12,ease:'power4.out',onUpdate:function(){num.textContent=Math.floor(obj.v)},onComplete:function(){num.textContent=target}});
      });
    }
  });
});
ScrollTrigger.refresh();
</script>
</body>
</html>
