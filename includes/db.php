<?php
// ── Database Configuration ──
define('DB_HOST', 'localhost');
define('DB_NAME', 'nexos');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

/*
// ── Live (Hostinger) ──
define('DB_HOST', 'localhost');
define('DB_NAME', 'u211813870_nexos_digital');
define('DB_USER', 'u211813870_nexos_digital');
define('DB_PASS', 'U211813870_nexo1');
define('DB_CHARSET', 'utf8mb4');
*/

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die('<div style="font-family:sans-serif;padding:40px;background:#060810;color:#ff5555;min-height:100vh">
                <h2>Database Connection Failed</h2>
                <p>' . htmlspecialchars($e->getMessage()) . '</p>
                <p style="color:#888;margin-top:20px">Please check your database config in <code>includes/db.php</code> and run <code>install.php</code> to set up the database.</p>
            </div>');
        }
    }
    return $pdo;
}