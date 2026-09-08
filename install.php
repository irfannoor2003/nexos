<?php
// ── Database Configuration ──
define('DB_HOST', 'localhost');
define('DB_NAME', 'nexos');
define('DB_USER', 'root');
define('DB_PASS', '');

/*
// ── Live (Hostinger) ──
define('DB_HOST', 'localhost');
define('DB_NAME', 'u211813870_nexos_digital');
define('DB_USER', 'u211813870_nexos_digital');
define('DB_PASS', 'U211813870_nexo1');
*/

$errors = [];
$success = false;

require_once __DIR__ . '/includes/image_slots.php';

try {
    // 1. Connect without DB selected first
    $pdo = new PDO("mysql:host=" . DB_HOST . ";charset=utf8mb4", DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // 2. Create database container if it doesn't exist, then select it
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `" . DB_NAME . "`");

    // 3. WIPE EXISTING TABLES (Resetting from Zero)
    // Disable foreign key constraints temporarily to avoid drop conflicts
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    $pdo->exec("DROP TABLE IF EXISTS `page_images` cascade");
    $pdo->exec("DROP TABLE IF EXISTS `settings` cascade");
    $pdo->exec("DROP TABLE IF EXISTS `messages` cascade");
    $pdo->exec("DROP TABLE IF EXISTS `posts` cascade");
    $pdo->exec("DROP TABLE IF EXISTS `categories` cascade");
    $pdo->exec("DROP TABLE IF EXISTS `admins` cascade");
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

    // 4. MIGRATIONS: Create fresh structural tables

    // Admins table
    $pdo->exec("CREATE TABLE `admins` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `email` VARCHAR(255) NOT NULL UNIQUE,
        `password` VARCHAR(255) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Blog categories
    $pdo->exec("CREATE TABLE `categories` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `slug` VARCHAR(100) NOT NULL UNIQUE,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Blog posts
    $pdo->exec("CREATE TABLE `posts` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `admin_id` INT NOT NULL,
        `category_id` INT DEFAULT NULL,
        `title` VARCHAR(255) NOT NULL,
        `slug` VARCHAR(255) NOT NULL UNIQUE,
        `excerpt` TEXT DEFAULT NULL,
        `content` LONGTEXT NOT NULL,
        `cover_image` VARCHAR(255) DEFAULT NULL,
        `status` ENUM('draft','published') DEFAULT 'draft',
        `views` INT DEFAULT 0,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`admin_id`) REFERENCES `admins`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Contact messages
    $pdo->exec("CREATE TABLE `messages` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `email` VARCHAR(255) NOT NULL,
        `phone` VARCHAR(30) DEFAULT NULL,
        `subject` VARCHAR(255) DEFAULT NULL,
        `message` TEXT NOT NULL,
        `read_at` TIMESTAMP NULL DEFAULT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Site settings
    $pdo->exec("CREATE TABLE `settings` (
        `key` VARCHAR(100) PRIMARY KEY,
        `value` TEXT DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // Site images (manageable from admin)
    $pdo->exec("CREATE TABLE `page_images` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `image_key` VARCHAR(80) NOT NULL UNIQUE,
        `label` VARCHAR(200) NOT NULL,
        `default_path` VARCHAR(255) NOT NULL,
        `custom_path` VARCHAR(255) DEFAULT NULL,
        `page_section` VARCHAR(80) NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    // 5. DATABASE SEEDING

    // Seed default admin (password: admin123)
    $hash = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->exec("INSERT INTO `admins` (`name`, `email`, `password`) VALUES ('Admin', 'admin@nexosdigital.com', '$hash')");

    // Seed categories
    $pdo->exec("INSERT INTO `categories` (`name`, `slug`) VALUES
        ('Digital Marketing', 'digital-marketing'),
        ('SEO', 'seo'),
        ('Web Design', 'web-design'),
        ('E-Commerce', 'e-commerce'),
        ('Case Studies', 'case-studies')
    ");

    // Seed settings
    $pdo->exec("INSERT INTO `settings` (`key`, `value`) VALUES
        ('site_name', 'Nexos'),
        ('site_tagline', 'Premium Digital Growth Agency'),
        ('contact_email', 'info@nexosdigitalagency.com'),
        ('contact_phone', '+92 322 431 3775'),
        ('address', 'Salamat Pura Station - Orange Line Metro Train Lahore')
    ");

    // Seed site images (single source of truth from image catalog)
    $imgStmt = $pdo->prepare("INSERT INTO `page_images` (`image_key`, `label`, `default_path`, `page_section`) VALUES (?, ?, ?, ?)");
    foreach (nexus_image_slots() as $slot) {
        $imgStmt->execute($slot);
    }

    // Seed blog posts
    $adminId = $pdo->query("SELECT id FROM admins LIMIT 1")->fetchColumn();
    $posts = [
        [
            'category'=>'seo', 'title'=>'Why SEO is Still the Most Powerful Growth Channel in 2026',
            'slug'=>'why-seo-is-still-most-powerful-growth-channel-2026',
            'excerpt'=>'SEO remains one of the most cost-effective channels for sustainable growth. Here is everything you need to know about ranking higher and converting more visitors.',
            'content'=>"<p>Search Engine Optimisation (SEO) remains one of the most powerful, cost-effective channels for sustainable business growth in 2026. Unlike paid advertising that stops the moment you pause your budget, SEO compounds over time.</p><h2>Why SEO Still Dominates</h2><p>Over 68% of online experiences begin with a search engine. If your business isn't appearing at the top of those results, you're essentially invisible to a massive pool of potential customers who are actively looking for exactly what you offer.</p><h2>The Core Pillars of Modern SEO</h2><p>Modern SEO isn't just about stuffing keywords into your pages. It revolves around three core pillars: Technical health (fast load times, clean architecture, mobile-first), Content authority (in-depth, original content that genuinely answers user intent), and Backlink quality (earning links from trusted, relevant websites).</p><h2>How Long Does It Take?</h2><p>Realistic SEO results typically begin appearing between 3 to 6 months, with major gains compounding after 12 months. The businesses that invest early gain a significant competitive moat that is very hard for latecomers to overcome.</p><p>If you're ready to build a long-term SEO strategy for your business, <a href='/contact.php'>get in touch with our team</a> today.</p>"
        ],
        [
            'category'=>'digital-marketing', 'title'=>'Meta Ads in 2026: What Actually Works for Lead Generation',
            'slug'=>'meta-ads-2026-what-works-lead-generation',
            'excerpt'=>'Most businesses are still running Meta Ads the 2019 way. Here are the five changes we make on every account that cut cost-per-lead in half.',
            'content'=>"<p>The Meta Ads landscape in 2026 looks nothing like it did five years ago. The algorithm now needs far more than a single conversion event to learn from, and the businesses that adapt are winning at a fraction of the ad cost.</p><h2>One Campaign, One Objective</h2><p>The single biggest mistake we see is cramming every ad into one broad campaign. Winners now structure accounts around a single business objective per campaign, letting the algorithm optimise for exactly one action at a time.</p><h2>Creative Is the New Targeting</h2><p>With signal loss reducing the accuracy of interest targeting, creative has become the primary lever. Native, vertical, hook-first creatives consistently outperform polished studio ads in every vertical we run.</p><h2>Lead CRM Integration</h2><p>Feeding offline conversions back into Meta through your CRM unlocks the machine learning that most advertisers ignore. It is the difference between paying for clicks and paying for qualified leads.</p><p>Want us to audit your current Meta Ads structure? <a href='/contact.php'>Book a free 30-minute call</a>.</p>"
        ],
        [
            'category'=>'web-design', 'title'=>'Why Brand-Driven Web Design Beats Template Sites Every Time',
            'slug'=>'brand-driven-web-design-beats-template-sites',
            'excerpt'=>'A template site saves you a week but costs you years. Here is what separation from the 99% actually does to your conversion rates.',
            'content'=>"<p>There has never been a cheaper time to build a website. Template builders promise a beautiful site in an afternoon — and a million other businesses are building the exact same one. That is precisely the problem.</p><h2>First Impressions Are Conversion Drivers</h2><p>Visitors form a judgement about your company in under a second. A distinct, brand-driven design tells that visitor you are established, credible and worth their budget. A template site tells them you are a commodity.</p><h2>Speed and Story Go Hand in Hand</h2><p>Brand-driven design is not just about looking different. It pairs a strong narrative with a fast, accessible build — because design that does not convert is just decoration. Every section earns its place.</p><h2>The ROI of Differentiation</h2><p>When your competitors all look the same, standing out is not vanity — it is strategy. We consistently see 30-60% higher enquiry rates on custom-branded builds versus templated alternatives.</p><p>See how we approach bespoke builds on our <a href='/portfolio.php'>portfolio</a>.</p>"
        ],
        [
            'category'=>'e-commerce', 'title'=>'CRO for E-Commerce: 7 Changes That Lift Conversion Rate Immediately',
            'slug'=>'cro-for-ecommerce-7-changes',
            'excerpt'=>'More traffic is not the answer. These seven on-site changes — from checkout flow to social proof — produce the fastest conversion wins for Shopify and WooCommerce stores.',
            'content'=>"<p>Every e-commerce owner dreams of more traffic, but most stores are losing over 97% of the visitors they already have. Before spending another rupee on ads, fix the conversion leaks that are quietly costing you sales.</p><h2>1. Kill Friction at Checkout</h2><p>Every extra field in your checkout is a silent customer loss. Guest checkout, autofill, and clear trust badges near the payment button can lift completed purchases by double digits.</p><h2>2. Make Product Pages Decisive</h2><p>A product page should answer the three questions every buyer has: Will it solve my problem? Is it worth the price? Can I trust this store? Use comparison tables, video, and honest reviews.</p><h2>3. Social Proof Above the Fold</h2><p>Trust badges, review counts, and 'recently bought' notifications placed near the Add to Cart button directly reduce the anxiety that kills conversions.</p><h2>4. Fix Mobile Speed</h2><p>Half of your mobile traffic will leave if the page takes over 3 seconds to load. Compress images, defer scripts, and keep the fold light.</p><p>These seven levers, applied systematically, routinely double e-commerce conversion rates within 90 days. Let's <a href='/contact.php'>talk about your store</a>.</p>"
        ],
        [
            'category'=>'case-studies', 'title'=>'From Page 5 to Page 1: A 5x Organic Traffic Case Study',
            'slug'=>'case-study-5x-organic-traffic',
            'excerpt'=>'How a Lahore-based manufacturing brand went from invisible to category leader in 9 months using our SEO system — with full numbers and the exact strategy.',
            'content'=>"<p>When a B2B manufacturer approached us, their website received barely 600 organic visitors a month and ranked on page five for their primary keyword. Nine months later they are at 3,200 monthly users and the #1 spot for their money term.</p><h2>The Starting Point</h2><p>Technical issues were holding back an otherwise decent site: slow server responses, broken internal link structure, and no content targeting commercial intent whatsoever.</p><h2>The Strategy</h2><p>We rebuilt the site architecture around buyer journeys, launched a pillar-content programme targeting long-tail commercial questions, and earned links from their own industry suppliers and directories.</p><h2>The Results at 9 Months</h2><p>Organic traffic grew 5.2x, keyword rankings on page one went from 4 to 38, and — critically — qualified enquiry form fills grew 4x. The cost per acquisition dropped to nearly a third of their paid bench.</p><p><a href='/contact.php'>Want the full breakdown for your niche?</a></p>"
        ],
        [
            'category'=>'digital-marketing', 'title'=>'AI in Digital Marketing: Where to Automate and Where to Stay Human',
            'slug'=>'ai-in-digital-marketing-automate-stay-human',
            'excerpt'=>'AI is now a non-negotiable part of every growth stack. Here is the honest map of what to automate, what to keep human, and how to avoid common trap.',
            'content'=>"<p>Every week a new AI tool promises to replace your marketing team. In practice, the agencies winning with AI are not the ones that automate everything — they are the ones that automate the right 80% and keep humans on the remaining 20%.</p><h2>Automate the Repetitive Layers</h2><p>Research briefs, ad copy variations, reporting, audience segmentation and A/B test analysis all scale beautifully with AI. These are speed tasks, not judgement tasks.</p><h2>Keep Humans on Strategy and Voice</h2><p>Brand voice, positioning, empathy on social, and big strategic bets still need human judgement. Audiences can smell deck-generated content instantly, and it erodes the trust your brand depends on.</p><h2>Workshop a Clear Workflow First</h2><p>Automating a broken process just gives you a faster mess. Map the workflow, digitise it, then layer AI on top. That ordering is what separates transformation from chaos.</p><p>We build AI-assisted workflows for clients at Nexos — <a href='/ai-automation.php'>see how</a>.</p>"
        ],
    ];
    $postStmt = $pdo->prepare("INSERT INTO `posts` (`admin_id`,`category_id`,`title`,`slug`,`excerpt`,`content`,`status`) VALUES (?,?,?,?,?,?,'published')");
    foreach ($posts as $p) {
        $postCatId = $pdo->query("SELECT id FROM categories WHERE slug='" . $p['category'] . "' LIMIT 1")->fetchColumn();
        $postStmt->execute([$adminId, $postCatId, $p['title'], $p['slug'], $p['excerpt'], $p['content']]);
    }

    $success = true;

} catch (PDOException $e) {
    $errors[] = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Nexos Installer</title>
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{background:#060810;color:#f0f2ff;font-family:'Inter',sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;padding:24px}
.box{background:#0e1220;border:1px solid rgba(255,255,255,.07);border-radius:20px;padding:48px;max-width:540px;width:100%;text-align:center}
h1{font-size:28px;font-weight:800;margin-bottom:8px}h1 span{color:#f0f2ff}
.sub{color:rgba(200,210,240,.55);font-size:14px;margin-bottom:32px}
.success{background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.25);border-radius:12px;padding:20px;color:#10b981;margin-bottom:24px}
.error{background:rgba(255,80,80,.08);border:1px solid rgba(255,80,80,.2);border-radius:12px;padding:20px;color:#ff5555;margin-bottom:24px;text-align:left}
.info{background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.1);border-radius:12px;padding:20px;font-size:13px;color:rgba(200,210,240,.7);text-align:left;line-height:1.7;margin-bottom:24px}
.info strong{color:#f0f2ff}
a.btn{display:inline-block;background:#1565FF;color:#fff;padding:12px 28px;border-radius:100px;text-decoration:none;font-weight:600;font-size:14px;margin-top:8px}
</style>
</head>
<body>
<div class="box">
  <h1>Nex<span>os</span> Installer</h1>
  <p class="sub">Fresh Database Remigration (From Zero)</p>
  <?php if ($success): ?>
    <div class="success">✅ Schema reset & migration completed successfully!</div>
    <div class="info">
      <strong>Default Admin Credentials:</strong><br>
      Email: <strong>admin@nexosdigital.com</strong><br>
      Password: <strong>admin123</strong><br><br>
      ⚠️ <strong>Important:</strong> Change your password after first login.<br>
      🗑️ <strong>Delete this file (install.php)</strong> from your server immediately.
    </div>
    <a href="/admin/login.php" class="btn">Go to Admin Panel →</a>
  <?php else: ?>
    <div class="error">❌ Installation failed:<br><br><?= implode('<br>', array_map('htmlspecialchars', $errors)) ?></div>
    <div class="info">Check your database credentials or user permissions and try again.</div>
  <?php endif; ?>
</div>
</body>
</html>