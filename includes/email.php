<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

define('MAIL_FROM_ADDRESS', 'info@nexosdigitalagency.com');
define('MAIL_FROM_NAME', 'Nexos');
define('MAIL_ADMIN', 'info@nexosdigitalagency.com');

function createMailer(): PHPMailer {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp.hostinger.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@nexosdigitalagency.com';
    $mail->Password   = 'Usman@0204i';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;
    $mail->CharSet    = 'UTF-8';
    $mail->SMTPDebug  = 0;
    $mail->Timeout    = 30;
    $mail->setLanguage('en', dirname(__DIR__) . '/vendor/phpmailer/phpmailer/language');

    $mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
    $mail->addReplyTo(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
    return $mail;
}

function sendEmail(string $to, string $subject, string $htmlBody, string $textContent = ''): bool {
    $mail = null;
    try {
        $mail = createMailer();
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body    = $htmlBody;
        $mail->AltBody = $textContent ?: strip_tags(str_replace(['<br>','<br/>','<br />'], "\n", $htmlBody));
        $mail->send();
        return true;
    } catch (Exception $e) {
        $log = "[" . date('Y-m-d H:i:s') . "] Email FAILED to {$to} | Subject: {$subject}\n" .
               "Error: " . ($mail ? $mail->ErrorInfo : $e->getMessage()) . "\n";
        error_log($log);
        $logDir = dirname(__DIR__) . '/logs';
        if (!is_dir($logDir)) @mkdir($logDir, 0755, true);
        @file_put_contents($logDir . '/email.log', $log, FILE_APPEND);
        return false;
    }
}

function sendContactThankYou(string $name, string $email, string $subject, string $message): bool {
    $siteName = 'Nexos';
    $subjectLine = "Thank You for Contacting {$siteName}";

    $html = emailTemplate("
        <tr>
            <td style=\"padding:0 0 16px\">
                <span style=\"display:inline-block;background:#EAF1FF;color:#1565FF;font-size:12px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;padding:7px 16px;border-radius:100px\">We Received Your Message</span>
            </td>
        </tr>
        <tr>
            <td style=\"padding:0 0 18px;font-family:'Inter',sans-serif;font-size:22px;font-weight:800;color:#16162a;line-height:1.3\">
                Hi {$name}, thanks for reaching out!
            </td>
        </tr>
        <tr>
            <td style=\"padding:0 0 24px;font-family:'Inter',sans-serif;font-size:15px;color:#4a4a66;line-height:1.8\">
                We've received your message and our team is already on it. Here's a quick copy of what you sent us:
            </td>
        </tr>
        <tr>
            <td style=\"padding:0 0 26px\">
                <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#f6f8fc;border:1px solid #e4e8f2;border-left:3px solid #1565FF;border-radius:12px\">
                    <tr>
                        <td style=\"padding:20px 24px;font-family:'Inter',sans-serif;font-size:14px;color:#4a4a66;line-height:1.8\">
                            <div style=\"margin-bottom:6px\"><strong style=\"color:#16162a\">Service:</strong> " . htmlspecialchars($subject ?: 'General Inquiry') . "</div>
                            <div style=\"margin-bottom:6px\"><strong style=\"color:#16162a\">Message:</strong></div>
                            <div style=\"color:#16162a;font-style:italic\">\"" . htmlspecialchars($message) . "\"</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style=\"padding:0 0 12px;font-family:'Inter',sans-serif;font-size:15px;color:#4a4a66;line-height:1.8\">
                A member of our team will get back to you within <strong style=\"color:#16162a\">24 hours</strong> — usually much sooner. If your matter is urgent, call us directly at <a href=\"tel:+923224313775\" style=\"color:#1565FF;text-decoration:none;font-weight:600\">+92 322 431 3775</a>.
            </td>
        </tr>
        <tr>
            <td style=\"padding:0 0 8px;font-family:'Inter',sans-serif;font-size:15px;color:#4a4a66;line-height:1.8\">
                Best regards,<br>
                <strong style=\"color:#16162a\">The {$siteName} Team</strong>
            </td>
        </tr>
    ");

    return sendEmail($email, $subjectLine, $html);
}

function sendAdminNotification(string $name, string $email, string $phone, string $subject, string $message): bool {
    $siteName = 'Nexos';
    $subjectLine = "New Contact Form Submission from {$name}";

    $phoneDisplay = $phone ? htmlspecialchars($phone) : 'Not provided';
    $subjectDisplay = htmlspecialchars($subject ?: 'General Inquiry');

    $html = emailTemplate("
        <tr>
            <td style=\"padding:0 0 16px\">
                <span style=\"display:inline-block;background:#EAF1FF;color:#1565FF;font-size:12px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;padding:7px 16px;border-radius:100px\">New Contact Form Submission</span>
            </td>
        </tr>
        <tr>
            <td style=\"padding:0 0 18px;font-family:'Inter',sans-serif;font-size:22px;font-weight:800;color:#16162a;line-height:1.3\">
                {$name} just sent a message via the {$siteName} website.
            </td>
        </tr>
        <tr>
            <td style=\"padding:0 0 26px\">
                <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#f6f8fc;border:1px solid #e4e8f2;border-radius:12px\">
                    <tr>
                        <td style=\"padding:24px;font-family:'Inter',sans-serif;font-size:14px;color:#4a4a66;line-height:2\">
                            <div><strong style=\"color:#16162a\">Name:</strong> " . htmlspecialchars($name) . "</div>
                            <div><strong style=\"color:#16162a\">Email:</strong> <a href=\"mailto:" . htmlspecialchars($email) . "\" style=\"color:#1565FF;text-decoration:none\">" . htmlspecialchars($email) . "</a></div>
                            <div><strong style=\"color:#16162a\">Phone:</strong> {$phoneDisplay}</div>
                            <div><strong style=\"color:#16162a\">Service:</strong> {$subjectDisplay}</div>
                            <div style=\"margin-top:14px\"><strong style=\"color:#16162a\">Message:</strong></div>
                            <div style=\"margin-top:6px;padding:16px 18px;background:#ffffff;border:1px solid #e4e8f2;border-radius:8px;color:#16162a;font-style:italic;line-height:1.7\">" . nl2br(htmlspecialchars($message)) . "</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style=\"padding:0 0 26px\">
                <table cellpadding=\"0\" cellspacing=\"0\">
                    <tr>
                        <td style=\"background:#1565FF;border-radius:100px\">
                            <a href=\"mailto:" . htmlspecialchars($email) . "?subject=Re: " . urlencode($subject ?: 'Your inquiry') . "\" style=\"display:inline-block;padding:14px 32px;font-family:'Inter',sans-serif;font-size:14px;font-weight:600;color:#ffffff;text-decoration:none\">Reply to {$name} &rarr;</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    ");

    $mail = null;
    try {
        $mail = createMailer();
        $mail->addAddress(MAIL_ADMIN);
        $mail->addReplyTo($email, $name);
        $mail->Subject = $subjectLine;
        $mail->isHTML(true);
        $mail->Body    = $html;
        $mail->AltBody = "New form submission from {$name}\nEmail: {$email}\nPhone: {$phoneDisplay}\nService: {$subjectDisplay}\n\n{$message}";
        $mail->send();
        return true;
    } catch (Exception $e) {
        $log = "[" . date('Y-m-d H:i:s') . "] Admin notification FAILED | Error: " . ($mail ? $mail->ErrorInfo : $e->getMessage()) . "\n";
        error_log($log);
        $logDir = dirname(__DIR__) . '/logs';
        if (!is_dir($logDir)) @mkdir($logDir, 0755, true);
        @file_put_contents($logDir . '/email.log', $log, FILE_APPEND);
        return false;
    }
}

function emailTemplate(string $content): string {
    $siteName = 'Nexos';
    $year = date('Y');

    return "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>{$siteName}</title>
</head>
<body style=\"margin:0;padding:0;background:#eef1f7;font-family:'Inter',Arial,sans-serif;-webkit-font-smoothing:antialiased\">
    <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#eef1f7;padding:40px 16px\">
        <tr>
            <td align=\"center\">
                <table width=\"600\" cellpadding=\"0\" cellspacing=\"0\" style=\"max-width:600px;width:100%\">
                    <tr>
                        <td style=\"padding:0 0 28px;text-align:center\">
                            <div style=\"font-family:'Inter',Arial,sans-serif;font-size:30px;font-weight:800;color:#16162a;letter-spacing:-1px\">Nex<span style=\"color:#1565FF\">os</span></div>
                            <div style=\"font-size:11px;color:#8a8aa0;letter-spacing:2px;text-transform:uppercase;margin-top:4px\">Digital Growth Agency</div>
                        </td>
                    </tr>
                    <tr>
                        <td style=\"padding:0 0 28px;text-align:center\">
                            <a href=\"https://nexosdigitalagency.com\" style=\"display:inline-block;background:#1565FF;color:#ffffff;text-decoration:none;font-family:'Inter',Arial,sans-serif;font-size:13px;font-weight:600;padding:10px 26px;border-radius:100px\">Visit Our Website</a>
                        </td>
                    </tr>
                    <tr>
                        <td style=\"padding:0 0 32px\">
                            <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#ffffff;border:1px solid #e4e8f2;border-radius:20px;box-shadow:0 8px 32px rgba(22,22,42,.06)\">
                                <tr>
                                    <td style=\"padding:40px 44px\">
                                        <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
                                            {$content}
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style=\"text-align:center;padding:0 0 16px\">
                            <table cellpadding=\"0\" cellspacing=\"0\" style=\"margin:0 auto\">
                                <tr>
                                    <td style=\"padding:0 10px\"><a href=\"https://www.linkedin.com/company/nexos-digital-agency/\" style=\"font-size:12px;color:#8a8aa0;text-decoration:none;font-family:'Inter',Arial,sans-serif\">LinkedIn</a></td>
                                    <td style=\"color:#d0d4e4\">|</td>
                                    <td style=\"padding:0 10px\"><a href=\"https://www.instagram.com/nexosdigitalagency\" style=\"font-size:12px;color:#8a8aa0;text-decoration:none;font-family:'Inter',Arial,sans-serif\">Instagram</a></td>
                                    <td style=\"color:#d0d4e4\">|</td>
                                    <td style=\"padding:0 10px\"><a href=\"https://www.facebook.com/share/19VJTk4up6/\" style=\"font-size:12px;color:#8a8aa0;text-decoration:none;font-family:'Inter',Arial,sans-serif\">Facebook</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style=\"text-align:center;padding:0 0 8px\">
                            <div style=\"font-size:11px;color:#8a8aa0;line-height:1.6;font-family:'Inter',Arial,sans-serif\">
                                {$siteName} &bull; Lahore, Pakistan<br>
                                <a href=\"mailto:info@nexosdigitalagency.com\" style=\"color:#1565FF;text-decoration:none\">info@nexosdigitalagency.com</a> &bull; <a href=\"tel:+923224313775\" style=\"color:#1565FF;text-decoration:none\">+92 322 431 3775</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style=\"text-align:center;padding:16px 0 0\">
                            <div style=\"font-size:10px;color:#b0b4c8;font-family:'Inter',Arial,sans-serif\">
                                &copy; {$year} {$siteName}. All rights reserved.
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>";
}