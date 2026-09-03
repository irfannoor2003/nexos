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
        ('contact_email', 'hello@nexosdigital.com'),
        ('contact_phone', '+92 300 123 4567'),
        ('address', 'Lahore, Pakistan')
    ");

    // Seed site images
    $pdo->exec("INSERT INTO `page_images` (`image_key`, `label`, `default_path`, `page_section`) VALUES
        ('logo', 'Site Logo (Dark Mode)', '/assets/images/logo.png', 'Global'),
        ('logo_light', 'Site Logo (Light Mode)', '/assets/images/logo-light.png', 'Global'),
        ('favicon', 'Favicon / Browser Icon', '/assets/images/favicon.ico', 'Global'),
        ('svc_brand_detail', 'Brand Detail Hero Image', '/assets/images/svc-brand.jpg', 'Services'),
        ('svc_marketing_detail', 'Digital Marketing Detail Hero Image', '/assets/images/svc-social.jpg', 'Services'),
        ('svc_web_detail', 'Web Design Detail Hero Image', '/assets/images/svc-web.jpg', 'Services'),
        ('svc_seo_detail', 'SEO Detail Hero Image', '/assets/images/svc-seo.jpg', 'Services'),
        ('svc_ads_detail', 'Ads Detail Hero Image', '/assets/images/svc-ads.jpg', 'Services'),
        ('svc_ecom_detail', 'E-Commerce Detail Hero Image', '/assets/images/svc-ecom.jpg', 'Services'),
        ('svc_perf_detail', 'Performance Marketing Detail Hero Image', '/assets/images/svc-perf.jpg', 'Services'),
        ('svc_ai_detail', 'AI Automation Detail Hero Image', '/assets/images/svc-ai.jpg', 'Services'),
        ('home_cta', 'CTA Background', '/assets/images/cta-work.jpg', 'Homepage'),
        ('home_portfolio_1', 'Portfolio Card 1', '/assets/images/svc-seo.jpg', 'Homepage'),
        ('home_portfolio_2', 'Portfolio Card 2', '/assets/images/svc-web.jpg', 'Homepage'),
        ('home_portfolio_3', 'Portfolio Card 3', '/assets/images/svc-ads.jpg', 'Homepage'),
        ('home_testimonial_1', 'Testimonial Avatar 1', '/assets/images/client-bilal.jpg', 'Homepage'),
        ('home_testimonial_2', 'Testimonial Avatar 2', '/assets/images/client-aisha.jpg', 'Homepage'),
        ('home_testimonial_3', 'Testimonial Avatar 3', '/assets/images/client-hamza.jpg', 'Homepage'),
        ('about_teamwork', 'Teamwork Image', '/assets/images/about-teamwork.jpg', 'About'),
        ('about_team_1', 'Team Member 1', '/assets/images/team-usman.jpg', 'About'),
        ('about_team_2', 'Team Member 2', '/assets/images/team-irfan.jpg', 'About'),
        ('about_team_3', 'Team Member 3', '/assets/images/team-saad.jpg', 'About'),
        ('svc_seo', 'SEO Service Image', '/assets/images/svc-seo.jpg', 'Services'),
        ('svc_ads', 'Digital Ads Service Image', '/assets/images/svc-ads.jpg', 'Services'),
        ('svc_ecom', 'E-Commerce Service Image', '/assets/images/svc-ecom.jpg', 'Services'),
        ('svc_web', 'Web Design Service Image', '/assets/images/svc-web.jpg', 'Services'),
        ('svc_perf', 'Performance Marketing Image', '/assets/images/svc-perf.jpg', 'Services'),
        ('svc_ai', 'AI Automation Service Image', '/assets/images/svc-ai.jpg', 'Services'),
        ('svc_brand', 'Brand Strategy Service Image', '/assets/images/svc-brand.jpg', 'Services'),
        ('port_showcase_1', 'Showcase Project 1', '/assets/images/svc-seo.jpg', 'Portfolio'),
        ('port_showcase_2', 'Showcase Project 2', '/assets/images/svc-ads.jpg', 'Portfolio'),
        ('port_showcase_3', 'Showcase Project 3', '/assets/images/svc-web.jpg', 'Portfolio'),
        ('port_showcase_4', 'Showcase Project 4', '/assets/images/svc-social.jpg', 'Portfolio'),
        ('port_showcase_5', 'Showcase Project 5', '/assets/images/svc-brand.jpg', 'Portfolio'),
        ('port_showcase_6', 'Showcase Project 6', '/assets/images/svc-ai.jpg', 'Portfolio'),
        ('port_grid_1', 'Portfolio Grid 1', '/assets/images/svc-design.jpg', 'Portfolio'),
        ('port_grid_2', 'Portfolio Grid 2', '/assets/images/svc-dashboard.jpg', 'Portfolio'),
        ('port_grid_3', 'Portfolio Grid 3', '/assets/images/svc-brand.jpg', 'Portfolio'),
        ('port_grid_4', 'Portfolio Grid 4', '/assets/images/svc-perf.jpg', 'Portfolio'),
        ('port_grid_5', 'Portfolio Grid 5', '/assets/images/svc-ai.jpg', 'Portfolio'),
        ('port_grid_6', 'Portfolio Grid 6', '/assets/images/svc-social.jpg', 'Portfolio'),
        ('contact_office', 'Office Image', '/assets/images/contact-office.jpg', 'Contact')
    ");

    // Seed a sample post
    $adminId = $pdo->query("SELECT id FROM admins LIMIT 1")->fetchColumn();
    $catId   = $pdo->query("SELECT id FROM categories WHERE slug='seo' LIMIT 1")->fetchColumn();
    $sampleContent = "<p>Search Engine Optimisation (SEO) remains one of the most powerful, cost-effective channels for sustainable business growth in 2025. Unlike paid advertising that stops the moment you pause your budget, SEO compounds over time.</p><h2>Why SEO Still Dominates</h2><p>Over 68% of online experiences begin with a search engine. If your business isn't appearing at the top of those results, you're essentially invisible to a massive pool of potential customers who are actively looking for exactly what you offer.</p><h2>The Core Pillars of Modern SEO</h2><p>Modern SEO isn't just about stuffing keywords into your pages. It revolves around three core pillars: Technical health (fast load times, clean architecture, mobile-first), Content authority (in-depth, original content that genuinely answers user intent), and Backlink quality (earning links from trusted, relevant websites).</p><h2>How Long Does It Take?</h2><p>Realistic SEO results typically begin appearing between 3 to 6 months, with major gains compounding after 12 months. The businesses that invest early gain a significant competitive moat that is very hard for latecomers to overcome.</p><p>If you're ready to build a long-term SEO strategy for your business, <a href='/contact'>get in touch with our team</a> today.</p>";
    $stmt = $pdo->prepare("INSERT INTO `posts` (`admin_id`,`category_id`,`title`,`slug`,`excerpt`,`content`,`status`) VALUES (?,?,?,?,?,?,'published')");
    $stmt->execute([$adminId, $catId, 'Why SEO is Still the Most Powerful Growth Channel in 2025', 'why-seo-is-still-most-powerful-growth-channel-2025', 'SEO remains one of the most cost-effective channels for sustainable growth. Here is everything you need to know about ranking higher and converting more visitors.', $sampleContent]);

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