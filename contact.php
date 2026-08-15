<?php
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/email.php';

$pageTitle  = 'Contact Us | Nexos Digital Growth Agency';
$activePage = 'contact';

$errors  = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrf()) { $errors[] = 'Security check failed. Please refresh and try again.'; }
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if (!$name) $errors[] = 'Your name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'A valid email address is required.';
    if (!$message) $errors[] = 'Please write your message.';

    if (empty($errors)) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO messages (name,email,phone,subject,message) VALUES (?,?,?,?,?)");
        $stmt->execute([$name, $email, $phone, $subject, $message]);

        sendContactThankYou($name, $email, $subject, $message);
        sendAdminNotification($name, $email, $phone, $subject, $message);

        $success = true;
    }
}

include __DIR__ . '/includes/header.php';
?>
<style>
/* CONTACT PAGE PREMIUM LUXURY 3D */
.contact-hero{position:relative;padding:160px 60px 100px;overflow:hidden;background:var(--bg)}
.contact-hero-bg{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.02) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.02) 1px,transparent 1px);background-size:72px 72px;mask-image:radial-gradient(ellipse 80% 80% at 50% 40%,#000 30%,transparent 100%)}
.contact-hero-glow{position:absolute;width:600px;height:600px;background:radial-gradient(circle,rgba(255,255,255,.03) 0%,transparent 70%);top:-200px;right:-100px;animation:breathe 8s ease-in-out infinite}
.contact-hero-glow2{position:absolute;width:400px;height:400px;background:radial-gradient(circle,rgba(255,255,255,.02) 0%,transparent 70%);bottom:-100px;left:-50px;animation:breathe 10s ease-in-out infinite 3s}
.contact-hero-content{position:relative;z-index:2;max-width:800px}
.contact-breadcrumb{display:flex;align-items:center;gap:8px;font-size:12px;color:var(--sub);margin-bottom:24px;font-family:var(--font-b)}
.contact-breadcrumb a{color:var(--sub);transition:color .2s}
.contact-breadcrumb a:hover{color:var(--blue2)}
.contact-breadcrumb span{color:rgba(100,120,200,.4)}
.contact-hero-badge{display:inline-flex;align-items:center;gap:8px;padding:7px 18px;border-radius:100px;background:rgba(255,255,255,.04);border:1px solid var(--border);font-family:var(--font-b);font-size:11px;font-weight:600;color:var(--sub);letter-spacing:1px;text-transform:uppercase;margin-bottom:28px;opacity:0;animation:fadeUp .7s .1s var(--ease) forwards}
.contact-hero-h1{font-family:var(--font-h);font-weight:800;font-size:clamp(42px,5.5vw,72px);line-height:1.08;letter-spacing:-3px;color:var(--text);margin-bottom:20px;opacity:0;animation:fadeUp .9s .2s var(--ease) forwards}
.contact-hero-h1 .em{background:linear-gradient(135deg,var(--blue),var(--blue2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;font-weight:700}
.contact-hero-desc{font-size:17px;color:var(--sub);line-height:1.85;max-width:620px;font-family:var(--font-b);opacity:0;animation:fadeUp .9s .38s var(--ease) forwards}

/* CONTACT GRID */
.contact-section{background:var(--bg);padding:100px 60px;position:relative}
.contact-section::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,var(--border-accent),transparent)}
.contact-grid{display:grid;grid-template-columns:1fr 1.6fr;gap:60px;align-items:start}

/* INFO CARD */
.contact-info-card{background:var(--card);border:1px solid var(--border);border-radius:var(--r-xl);padding:0;position:sticky;top:100px;overflow:hidden;transition:all .4s var(--spring);box-shadow:var(--shadow-lg)}
.contact-info-card:hover{box-shadow:var(--shadow-lg)}
.info-card-hero{height:180px;position:relative;overflow:hidden}
.info-card-hero img{width:100%;height:100%;object-fit:cover;transition:transform .6s var(--ease)}
.contact-info-card:hover .info-card-hero img{transform:scale(1.04)}
.info-card-hero::after{content:'';position:absolute;inset:0;background:linear-gradient(to bottom,transparent 30%,var(--card));pointer-events:none}
.info-card-body{padding:32px 36px 36px}
.info-card-title{font-family:var(--font-h);font-size:18px;font-weight:700;color:var(--text);margin-bottom:24px;display:flex;align-items:center;gap:10px}
.info-card-title::before{content:'';width:3px;height:20px;background:var(--border);border-radius:2px}
.cinfo-item{display:flex;align-items:flex-start;gap:16px;padding:18px 0;border-bottom:1px solid var(--border);transition:all .2s}
.cinfo-item:last-child{border-bottom:none}
.cinfo-item:hover{padding-left:4px}
.cinfo-ico{width:44px;height:44px;background:rgba(255,255,255,.03);border:1px solid var(--border);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:all .3s var(--spring)}
.cinfo-item:hover .cinfo-ico{background:rgba(255,255,255,.06);transform:scale(1.05)}
.cinfo-label{font-size:11px;font-weight:600;color:var(--sub);font-family:var(--font-b);letter-spacing:.5px;text-transform:uppercase;margin-bottom:4px}
.cinfo-value{font-size:14px;color:var(--text);font-weight:500;font-family:var(--font-b)}
.cinfo-value a{color:var(--text);transition:color .2s}
.cinfo-value a:hover{color:var(--blue2)}
.info-response{margin-top:24px;padding:18px;background:rgba(255,255,255,.02);border:1px solid var(--border);border-radius:14px;font-size:13px;color:var(--sub);line-height:1.7;font-family:var(--font-b);display:flex;align-items:flex-start;gap:10px}
.info-response strong{color:var(--text)}

/* TRUST BAR */
.trust-bar{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:24px}
.trust-item{background:var(--card);border:1px solid var(--border);border-radius:var(--r-lg);padding:18px 16px;text-align:center;transition:all .3s var(--spring);box-shadow:var(--shadow-sm)}
.trust-item:hover{border-color:var(--border)}
.trust-num{font-family:var(--font-h);font-size:22px;font-weight:800;line-height:1;color:var(--text)}
.trust-label{font-size:11px;color:var(--sub);margin-top:4px;font-family:var(--font-b)}

/* FORM CARD */
.form-card{background:var(--card);border:1px solid var(--border);border-radius:var(--r-xl);padding:48px;position:relative;overflow:hidden;transition:all .4s var(--spring);box-shadow:var(--shadow-lg)}
.form-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:var(--border);opacity:0;transition:opacity .4s}
.form-card:hover::before{opacity:1}
.form-header{margin-bottom:32px}
.form-title{font-family:var(--font-h);font-size:22px;font-weight:700;color:var(--text);margin-bottom:6px}
.form-subtitle{font-size:14px;color:var(--sub);font-family:var(--font-b)}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}
.form-group{margin-bottom:16px}
.form-label{display:block;font-size:12px;font-weight:600;color:var(--sub);margin-bottom:8px;font-family:var(--font-b);letter-spacing:.3px}
.form-label .req{color:var(--sub)}
.form-input,.form-textarea,.form-select{width:100%;padding:14px 18px;background:var(--bg3);border:1.5px solid var(--border);border-radius:14px;font-family:var(--font-b);font-size:14px;color:var(--text);outline:none;transition:all .25s var(--spring)}
.form-input:focus,.form-textarea:focus,.form-select:focus{border-color:var(--blue);box-shadow:0 0 0 4px rgba(21,101,255,.1);background:rgba(21,101,255,.02)}
.form-input::placeholder,.form-textarea::placeholder{color:var(--sub);opacity:.5}
.form-select option{background:var(--bg3);color:var(--text)}
.form-textarea{resize:vertical;min-height:160px;line-height:1.7}
.form-footer{display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap}
.form-note{font-size:12px;color:var(--sub);flex:1;font-family:var(--font-b)}
.form-submit{display:inline-flex;align-items:center;gap:10px;background:var(--blue);color:#fff;padding:16px 36px;border-radius:14px;font-family:var(--font-b);font-size:15px;font-weight:600;box-shadow:0 6px 32px var(--blue-glow);transition:all .3s var(--spring);position:relative;overflow:hidden;border:none;cursor:pointer}
.form-submit::before{content:'';position:absolute;top:0;left:-100%;width:100%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.12),transparent);transition:left .5s}
.form-submit:hover{box-shadow:0 12px 44px rgba(21,101,255,.45)}
.form-submit:hover::before{left:100%}

/* SUCCESS BOX */
.success-box{text-align:center;padding:60px 32px}
.success-icon{width:72px;height:72px;background:rgba(16,185,129,.08);border:2px solid rgba(16,185,129,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;animation:scaleIn .5s var(--ease)}
.success-title{font-family:var(--font-h);font-size:26px;font-weight:700;color:var(--text);margin-bottom:12px}
.success-desc{font-size:15px;color:var(--sub);max-width:380px;margin:0 auto;line-height:1.7;font-family:var(--font-b)}

/* FAQ */
.faq-sec{margin-top:100px}
.faq-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:40px}
.faq-card{background:var(--card);border:1px solid var(--border);border-radius:var(--r-lg);overflow:hidden;transition:all .4s var(--spring);transform-style:preserve-3d;box-shadow:var(--shadow-sm);position:relative}
.faq-card::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:var(--border);opacity:0;transition:opacity .4s}
.faq-card:hover{border-color:var(--border)}
.faq-card:hover::before{opacity:1}
.faq-card details{padding:24px 28px}
.faq-card details summary{font-family:var(--font-h);font-size:14px;font-weight:600;color:var(--sub);list-style:none;display:flex;justify-content:space-between;align-items:center;gap:12px;cursor:pointer;transition:color .2s}
.faq-card details summary::-webkit-details-marker{display:none}
.faq-card details[open] summary{color:var(--text)}
.faq-card details summary svg{transition:transform .3s var(--spring)}
.faq-card details[open] summary svg{transform:rotate(180deg)}
.faq-card details p{font-size:14px;color:var(--sub);line-height:1.8;margin-top:14px;font-family:var(--font-b)}

/* RESPONSIVE */
@media(max-width:1024px){
  .contact-hero,.contact-section{padding-left:28px;padding-right:28px}
  .contact-grid{grid-template-columns:1fr}
  .contact-info-card{position:static}
  .faq-grid{grid-template-columns:1fr}
  .trust-bar{grid-template-columns:repeat(3,1fr)}
}
@media(max-width:640px){
  .contact-hero{padding:130px 20px 60px}
  .contact-section{padding:60px 20px}
  .form-row{grid-template-columns:1fr}
  .form-card{padding:28px 24px}
  .info-card-body{padding:24px}
  .trust-bar{grid-template-columns:1fr}
  .form-footer{flex-direction:column;align-items:stretch}
}
</style>

<!-- HERO -->
<section class="contact-hero">
  <div class="contact-hero-bg"></div>
  <div class="contact-hero-glow"></div>
  <div class="contact-hero-glow2"></div>
  <div class="contact-hero-content">
    <div class="contact-breadcrumb"><a href="/">Home</a><span>/</span><span style="color:var(--text)">Contact</span></div>
    <div class="contact-hero-badge">Let's Talk</div>
    <h1 class="contact-hero-h1">
      Ready to Start <span class="em">Growing?</span>
    </h1>
    <p class="contact-hero-desc">Tell us about your business, your goals, and your current challenges. A member of the Nexos team will reply within 24 hours &mdash; usually much sooner.</p>
  </div>
</section>

<!-- CONTACT SECTION -->
<section class="contact-section">
  <div class="contact-grid">
    <!-- Info -->
    <div class="reveal-l">
      <div class="contact-info-card">
        <div class="info-card-hero">
          <img src="<?= site_img('contact_office', '/assets/images/contact-office.jpg') ?>" alt="Contact Nexos">
        </div>
        <div class="info-card-body">
          <div class="info-card-title">Get in Touch</div>
          <div class="cinfo-item">
            <div class="cinfo-ico"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M17 13.9v2A1.5 1.5 0 0115.5 17a14.5 14.5 0 01-6.3-2.2A14.3 14.3 0 014.7 10 14.5 14.5 0 012.5 3.7 1.5 1.5 0 014 2.2h2a1.5 1.5 0 011.5 1.3c.1.8.3 1.5.5 2.2a1.5 1.5 0 01-.3 1.5L6.7 8.2A12 12 0 0010.7 12l1-.9a1.5 1.5 0 011.6-.4c.7.2 1.4.4 2.2.5A1.5 1.5 0 0117 13.9Z" stroke="currentColor" stroke-width="1.5"/></svg></div>
            <div><div class="cinfo-label">Phone</div><div class="cinfo-value"><a href="tel:+923001234567">+92 300 123 4567</a></div></div>
          </div>
          <div class="cinfo-item">
            <div class="cinfo-ico"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M3 5h14a1 1 0 011 1v8a1 1 0 01-1 1H3a1 1 0 01-1-1V6a1 1 0 011-1Z" stroke="currentColor" stroke-width="1.5"/><path d="M2 6l8 5.5L18 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg></div>
            <div><div class="cinfo-label">Email</div><div class="cinfo-value"><a href="mailto:hello@nexosdigital.com">hello@nexosdigital.com</a></div></div>
          </div>
          <div class="cinfo-item">
            <div class="cinfo-ico"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 2a7 7 0 100 14A7 7 0 0010 2Z" stroke="currentColor" stroke-width="1.5"/><path d="M10 5v5l3 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg></div>
            <div><div class="cinfo-label">Hours</div><div class="cinfo-value">Mon&ndash;Fri, 9AM&ndash;6PM PKT</div></div>
          </div>
          <div class="cinfo-item">
            <div class="cinfo-ico"><svg width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M10 2a6 6 0 016 6c0 4-6 10-6 10S4 12 4 8a6 6 0 016-6Z" stroke="currentColor" stroke-width="1.5"/><circle cx="10" cy="8" r="2" stroke="currentColor" stroke-width="1.5"/></svg></div>
            <div><div class="cinfo-label">Location</div><div class="cinfo-value">Lahore, Pakistan</div></div>
          </div>
          <div class="info-response">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="flex-shrink:0;margin-top:1px"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>We reply to all inquiries within <strong>24 hours</strong>. Average response time is under 4 hours on weekdays.</span>
          </div>
          <div class="trust-bar">
            <div class="trust-item reveal">
              <div class="trust-num">250+</div>
              <div class="trust-label">Projects Done</div>
            </div>
            <div class="trust-item reveal">
              <div class="trust-num">98%</div>
              <div class="trust-label">Client Satisfaction</div>
            </div>
            <div class="trust-item reveal">
              <div class="trust-num">4hr</div>
              <div class="trust-label">Avg Response</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="reveal-r">
      <?php if($success): ?>
      <div class="form-card">
        <div class="success-box">
          <div class="success-icon">
            <svg width="36" height="36" viewBox="0 0 36 36" fill="none"><path d="M8 18l8 8L28 10" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
          <h3 class="success-title">Message Received!</h3>
          <p class="success-desc">We aim to reply to all inquiries within 24 hours. A confirmation email has been sent to your inbox &mdash; we'll be in touch soon.</p>
          <a href="/contact.php" class="btn-outline" style="margin-top:36px">Send Another Message</a>
        </div>
      </div>
      <?php else: ?>
      <div class="form-card">
        <div class="form-header">
          <div class="form-title">Tell Us About Your Project</div>
          <div class="form-subtitle">Don't worry about sounding technical &mdash; just tell us your goals.</div>
        </div>

        <?php if(!empty($errors)): ?>
        <div class="flash flash-error"><?= implode('<br>', array_map('h', $errors)) ?></div>
        <?php endif; ?>

        <form method="POST" action="/contact.php">
          <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
          <div class="form-row">
            <div class="form-group" style="margin-bottom:0">
              <label class="form-label">Your Name <span class="req">*</span></label>
              <input name="name" type="text" placeholder="Full name" class="form-input" value="<?= h($_POST['name'] ?? '') ?>">
            </div>
            <div class="form-group" style="margin-bottom:0">
              <label class="form-label">Email Address <span class="req">*</span></label>
              <input name="email" type="email" placeholder="your@email.com" class="form-input" value="<?= h($_POST['email'] ?? '') ?>">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group" style="margin-bottom:0">
              <label class="form-label">Phone <span style="color:var(--sub);opacity:.5;font-weight:400">(Optional)</span></label>
              <input name="phone" type="tel" placeholder="+92 3XX XXX XXXX" class="form-input" value="<?= h($_POST['phone'] ?? '') ?>">
            </div>
            <div class="form-group" style="margin-bottom:0">
              <label class="form-label">Service Interested In</label>
              <select name="subject" class="form-select">
                <option value="">Select a service...</option>
                <?php foreach(['SEO Optimization','Google Ads','Meta Ads','E-Commerce Solutions','Web Design & Development','Performance Marketing','Brand Strategy & Identity','AI Automation','Multiple Services','Not Sure Yet'] as $opt): ?>
                <option value="<?= h($opt) ?>" <?= ($_POST['subject'] ?? '') === $opt ? 'selected' : '' ?>><?= h($opt) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">Your Message <span class="req">*</span></label>
            <textarea name="message" placeholder="Tell us about your business, your current struggles, and what you're looking to achieve..." class="form-textarea"><?= h($_POST['message'] ?? '') ?></textarea>
          </div>
          <div class="form-footer">
            <div class="form-note">Your information is secure. We will never share your data with third parties.</div>
            <button type="submit" class="form-submit">
              Send Message
              <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M1 8h14M8 1l7 7-7 7" stroke="#0a0a10" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
          </div>
        </form>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- FAQ -->
  <div class="faq-sec">
    <div class="sec-center">
      <div class="sec-label reveal">FAQs</div>
      <h2 class="sec-h reveal">Common <span class="em">Questions</span></h2>
      <p class="sec-sub reveal">Everything you need to know before getting started.</p>
    </div>
    <div class="faq-grid">
      <?php $faqs = [
        ['Do I need to understand technical marketing terms?','Not at all. That is our job. We handle all the heavy lifting and technical execution, and explain everything to you in plain, simple English.'],
        ['How soon can I expect to see results?','It depends on the service. Advertising campaigns can generate leads almost immediately, while sustainable SEO growth typically takes 3-6 months to show significant results. We\'ll give you a clear, realistic timeline during our first conversation.'],
        ['Do you work with businesses in my industry?','We partner with ambitious brands across 17+ industries &mdash; from local service providers to global e-commerce retailers. If you have a great product or service and you\'re ready to grow, we\'re ready to build the engine.'],
        ['What is your pricing structure?','We don\'t believe in one-size-fits-all pricing. Every project gets a custom quote based on your goals, timeline, and budget. Get in touch and we\'ll put together a clear, transparent proposal.'],
        ['Do you require long-term contracts?','We offer flexible engagement models. While we recommend a minimum 3-month commitment for SEO (results take time), our advertising and design services can be project-based with no lock-in.'],
        ['What information do you need to get started?','Just your business name, website (if you have one), what you\'re trying to achieve, and your rough budget range. We\'ll take it from there and guide you through the rest.'],
      ]; foreach($faqs as $faq): ?>
      <div class="faq-card reveal">
        <details>
          <summary><?= h($faq[0]) ?><svg width="14" height="14" viewBox="0 0 14 14" fill="none" style="flex-shrink:0"><path d="M3 5l4 4 4-4" stroke="var(--sub)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></summary>
          <p><?= h($faq[1]) ?></p>
        </details>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
