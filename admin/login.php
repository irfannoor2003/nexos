<?php
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/db.php';
requireGuest();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrf()) { $error = 'Security error. Please try again.'; }
    else {
        $email = trim($_POST['email'] ?? '');
        $pass  = $_POST['password'] ?? '';
        $db    = getDB();
        $stmt  = $db->prepare("SELECT * FROM admins WHERE email=? LIMIT 1");
        $stmt->execute([$email]);
        $admin = $stmt->fetch();
        if ($admin && password_verify($pass, $admin['password'])) {
            $_SESSION['admin_id']   = $admin['id'];
            $_SESSION['admin_name'] = $admin['name'];
            header('Location: /admin/index.php');
            exit;
        }
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | Nexos</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--blue:#1565FF;--blue2:#3B82F6;--bg:#f4f6fb;--bg2:#ffffff;--bg3:#eef1f7;--card:#ffffff;--border:rgba(15,23,42,.09);--text:#0f172a;--sub:rgba(15,23,42,.58);--green:#0e9f6e;--red:#e5484d;--font-h:'Inter',sans-serif;--font-b:'Inter',sans-serif;--spring:cubic-bezier(.34,1.56,.64,1)}
*{margin:0;padding:0;box-sizing:border-box}
body{background:var(--bg);color:var(--text);font-family:var(--font-b);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px;overflow:hidden}
body::before{content:'';position:fixed;inset:0;background-image:linear-gradient(rgba(15,23,42,.04) 1px,transparent 1px),linear-gradient(90deg,rgba(15,23,42,.04) 1px,transparent 1px);background-size:60px 60px;pointer-events:none}
.glow{position:fixed;width:600px;height:600px;background:radial-gradient(circle,rgba(21,101,255,.08) 0%,transparent 70%);top:-200px;left:50%;transform:translateX(-50%);pointer-events:none}
.box{background:var(--card);border:1px solid var(--border);border-radius:24px;width:100%;max-width:460px;padding:48px;position:relative;z-index:1;box-shadow:0 24px 80px rgba(15,23,42,.12)}
.logo{font-family:var(--font-h);font-size:24px;font-weight:800;letter-spacing:-1px;margin-bottom:32px;display:block;color:#0f172a}
.logo span{color:var(--blue)}
.sup{font-size:11px;font-weight:700;color:var(--blue2);letter-spacing:1px;text-transform:uppercase;margin-bottom:10px;font-family:var(--font-h)}
h1{font-family:var(--font-h);font-size:26px;font-weight:800;color:var(--text);letter-spacing:-1px;margin-bottom:32px;color:#0f172a}
.form-group{margin-bottom:18px}
label{display:block;font-size:12px;font-weight:600;color:var(--sub);margin-bottom:8px;font-family:var(--font-h);letter-spacing:.3px}
input{width:100%;padding:13px 16px;background:var(--bg3);border:1.5px solid var(--border);border-radius:10px;font-family:var(--font-b);font-size:14px;color:var(--text);outline:none;transition:border-color .25s}
input:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(21,101,255,.12)}
input::placeholder{color:rgba(15,23,42,.32)}
.error{background:rgba(229,72,77,.08);border:1px solid rgba(229,72,77,.2);border-radius:10px;padding:12px 16px;font-size:13px;color:var(--red);margin-bottom:20px}
.btn{width:100%;padding:15px;background:var(--blue);color:#fff;border:none;border-radius:12px;font-family:var(--font-h);font-size:15px;font-weight:600;cursor:pointer}
.hint{font-size:12px;color:var(--sub);text-align:center;margin-top:20px}
.hint strong{color:var(--text)}
a{color:var(--sub);text-decoration:none}
@media(max-width:480px){.box{padding:32px 24px}}
</style>
</head>
<body>
<div class="glow"></div>
<div class="box">
  <span class="logo">Nex<span>os</span></span>
  <div class="sup">Admin Panel</div>
  <h1>Welcome Back</h1>
  <?php if($error): ?><div class="error"><?= h($error) ?></div><?php endif; ?>
  <?php $f = getFlash(); if($f): ?><div class="error" style="<?= $f['type']==='success' ? 'background:rgba(14,159,110,.1);border-color:rgba(14,159,110,.25);color:var(--green)' : '' ?>"><?= h($f['msg']) ?></div><?php endif; ?>
  <form method="POST">
    <input type="hidden" name="csrf" value="<?= csrfToken() ?>">
    <div class="form-group">
      <label>Email Address</label>
      <input name="email" type="email" placeholder="admin@nexosdigital.com" value="<?= h($_POST['email'] ?? '') ?>" required>
    </div>
    <div class="form-group">
      <label>Password</label>
      <input name="password" type="password" placeholder="••••••••" required>
    </div>
    <button type="submit" class="btn">Sign In →</button>
  </form>
  <p class="hint">Default: <strong>admin@nexosdigital.com</strong> / <strong>admin123</strong></p>
</div>
</body>
</html>
