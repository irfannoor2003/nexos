<?php
session_start();

// ── Auth ──
function isLoggedIn(): bool {
    return isset($_SESSION['admin_id']);
}
function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: /admin/login.php');
        exit;
    }
}
function requireGuest(): void {
    if (isLoggedIn()) {
        header('Location: /admin/index.php');
        exit;
    }
}

// ── Sanitize ──
function h(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// ── Slugify ──
function slugify(string $text): string {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

// ── Flash messages ──
function setFlash(string $type, string $msg): void {
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}
function getFlash(): ?array {
    if (isset($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $f;
    }
    return null;
}

// ── Excerpt ──
function excerpt(string $text, int $words = 30): string {
    $clean = strip_tags($text);
    $arr = explode(' ', $clean);
    if (count($arr) <= $words) return $clean;
    return implode(' ', array_slice($arr, 0, $words)) . '…';
}

// ── Time ago ──
function timeAgo(string $datetime): string {
    $diff = time() - strtotime($datetime);
    if ($diff < 60) return 'just now';
    if ($diff < 3600) return floor($diff/60) . 'm ago';
    if ($diff < 86400) return floor($diff/3600) . 'h ago';
    if ($diff < 604800) return floor($diff/86400) . 'd ago';
    return date('M j, Y', strtotime($datetime));
}

// ── CSRF ──
function csrfToken(): string {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}
function verifyCsrf(): bool {
    return isset($_POST['csrf']) && hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf']);
}

// ── Site Images (DB-managed) ──
function site_img(string $key, string $default = ''): string {
    static $cache = null;
    if ($cache === null) {
        $cache = [];
        if (function_exists('getDB')) {
            try {
                $db = getDB();
                $stmt = $db->query("SELECT image_key, COALESCE(custom_path, default_path) AS path FROM page_images");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $cache[$row['image_key']] = $row['path'];
                }
            } catch (Exception $e) {
                // DB not available — fall back to default
            }
        }
    }
    return $cache[$key] ?? $default;
}

// ── Pagination ──
function paginate(int $total, int $perPage, int $current): array {
    $pages = (int)ceil($total / $perPage);
    return ['total' => $total, 'pages' => $pages, 'current' => $current, 'perPage' => $perPage, 'offset' => ($current - 1) * $perPage];
}
