<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

define('MAIL_FROM_ADDRESS', 'syedirfannoor996@gmail.com');
define('MAIL_FROM_NAME', 'Nexos');
define('MAIL_ADMIN', 'syedirfannoor996@gmail.com');

function createMailer(): PHPMailer {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'syedirfannoor996@gmail.com';
    $mail->Password   = 'ggddtorsogiswjut';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';
    $mail->setLanguage('en', dirname(__DIR__) . '/vendor/phpmailer/phpmailer/language');

    $mail->setFrom(MAIL_FROM_ADDRESS, MAIL_FROM_NAME);
    return $mail;
}

function sendEmail(string $to, string $subject, string $htmlBody, string $textContent = ''): bool {
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
        error_log("Email failed to {$to}: " . $mail->ErrorInfo);
        return false;
    }
}

function sendContactThankYou(string $name, string $email, string $subject, string $message): bool {
    $siteName = 'Nexos';
    $subjectLine = "Thank You for Contacting {$siteName}";

    $html = emailTemplate("
        <tr>
            <td style=\"padding:0 0 24px;font-family:'Inter',sans-serif;font-size:15px;color:#c8d2f0;line-height:1.8\">
                Hi <strong style=\"color:#ffffff\">{$name}</strong>,
            </td>
        </tr>
        <tr>
            <td style=\"padding:0 0 24px;font-family:'Inter',sans-serif;font-size:15px;color:#c8d2f0;line-height:1.8\">
                Thank you for reaching out to <strong style=\"color:#ffffff\">{$siteName}</strong>! We have received your message and our team will review it shortly.
            </td>
        </tr>
        <tr>
            <td style=\"padding:0 0 24px\">
                <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.1);border-radius:12px\">
                    <tr>
                        <td style=\"padding:20px 24px;font-family:'Inter',sans-serif;font-size:13px;color:#8892b0;line-height:1.8\">
                            <div style=\"margin-bottom:8px\"><strong style=\"color:#c8d2f0\">Service:</strong> " . htmlspecialchars($subject ?: 'General Inquiry') . "</div>
                            <div style=\"margin-bottom:8px\"><strong style=\"color:#c8d2f0\">Message:</strong></div>
                            <div style=\"color:#c8d2f0;font-style:italic\">\"" . htmlspecialchars($message) . "\"</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style=\"padding:0 0 24px;font-family:'Inter',sans-serif;font-size:15px;color:#c8d2f0;line-height:1.8\">
                A member of our team will get back to you within <strong style=\"color:#ffffff\">24 hours</strong> &mdash; usually much sooner. If your matter is urgent, feel free to call us directly at <a href=\"tel:+923001234567\" style=\"color:#4d8dff;text-decoration:none\">+92 300 123 4567</a>.
            </td>
        </tr>
        <tr>
            <td style=\"padding:0 0 8px;font-family:'Inter',sans-serif;font-size:15px;color:#c8d2f0;line-height:1.8\">
                Best regards,<br>
                <strong style=\"color:#ffffff\">The {$siteName} Team</strong>
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
            <td style=\"padding:0 0 24px;font-family:'Inter',sans-serif;font-size:15px;color:#c8d2f0;line-height:1.8\">
                You have received a new message through the contact form on <strong style=\"color:#ffffff\">{$siteName}</strong>.
            </td>
        </tr>
        <tr>
            <td style=\"padding:0 0 24px\">
                <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.1);border-radius:12px\">
                    <tr>
                        <td style=\"padding:24px;font-family:'Inter',sans-serif;font-size:14px;color:#c8d2f0;line-height:2\">
                            <div><strong style=\"color:#c8d2f0\">Name:</strong> " . htmlspecialchars($name) . "</div>
                            <div><strong style=\"color:#c8d2f0\">Email:</strong> <a href=\"mailto:" . htmlspecialchars($email) . "\" style=\"color:#c8d2f0;text-decoration:none\">" . htmlspecialchars($email) . "</a></div>
                            <div><strong style=\"color:#c8d2f0\">Phone:</strong> {$phoneDisplay}</div>
                            <div><strong style=\"color:#c8d2f0\">Service:</strong> {$subjectDisplay}</div>
                            <div style=\"margin-top:12px\"><strong style=\"color:#c8d2f0\">Message:</strong></div>
                            <div style=\"margin-top:6px;padding:16px;background:rgba(6,8,16,.5);border-radius:8px;color:#c8d2f0;font-style:italic;line-height:1.7\">" . nl2br(htmlspecialchars($message)) . "</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style=\"padding:0 0 24px\">
                <table cellpadding=\"0\" cellspacing=\"0\">
                    <tr>
                        <td style=\"background:#1565FF;border-radius:100px\">
                            <a href=\"mailto:" . htmlspecialchars($email) . "?subject=Re: " . urlencode($subject ?: 'Your inquiry') . "\" style=\"display:inline-block;padding:14px 32px;font-family:'Inter',sans-serif;font-size:14px;font-weight:600;color:#ffffff;text-decoration:none\">Reply via Email &rarr;</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    ");

    return sendEmail(MAIL_ADMIN, $subjectLine, $html);
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
<body style=\"margin:0;padding:0;background:#060810;font-family:'Inter',sans-serif;-webkit-font-smoothing:antialiased\">
    <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#060810;padding:40px 20px\">
        <tr>
            <td align=\"center\">
                <table width=\"600\" cellpadding=\"0\" cellspacing=\"0\" style=\"max-width:600px;width:100%\">
                    <tr>
                        <td style=\"padding:0 0 40px;text-align:center\">
                            <div style=\"font-family:'Inter',sans-serif;font-size:28px;font-weight:800;color:#f0f2ff;letter-spacing:-1px\">Nex<span style=\"color:#1565FF\">os</span></div>
                            <div style=\"font-size:11px;color:rgba(200,210,240,.45);letter-spacing:2px;text-transform:uppercase;margin-top:4px\">Digital Growth Agency</div>
                        </td>
                    </tr>
                    <tr>
                        <td style=\"padding:0 0 40px\">
                            <div style=\"height:1px;background:rgba(255,255,255,.07)\"></div>
                        </td>
                    </tr>
                    <tr>
                        <td style=\"padding:0 0 40px\">
                            <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" style=\"background:#0e1220;border:1px solid rgba(255,255,255,.07);border-radius:20px\">
                                <tr>
                                    <td style=\"padding:40px 48px\">
                                        {$content}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style=\"padding:0 0 20px\">
                            <div style=\"height:1px;background:rgba(255,255,255,.07)\"></div>
                        </td>
                    </tr>
                    <tr>
                        <td style=\"text-align:center;padding:0 0 16px\">
                            <table cellpadding=\"0\" cellspacing=\"0\" style=\"margin:0 auto\">
                                <tr>
                                    <td style=\"padding:0 8px\"><a href=\"#\" style=\"font-size:12px;color:rgba(200,210,240,.45);text-decoration:none;font-family:'Inter',sans-serif\">LinkedIn</a></td>
                                    <td style=\"color:rgba(200,210,240,.2)\">|</td>
                                    <td style=\"padding:0 8px\"><a href=\"#\" style=\"font-size:12px;color:rgba(200,210,240,.45);text-decoration:none;font-family:'Inter',sans-serif\">Instagram</a></td>
                                    <td style=\"color:rgba(200,210,240,.2)\">|</td>
                                    <td style=\"padding:0 8px\"><a href=\"#\" style=\"font-size:12px;color:rgba(200,210,240,.45);text-decoration:none;font-family:'Inter',sans-serif\">Facebook</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style=\"text-align:center;padding:0 0 8px\">
                            <div style=\"font-size:11px;color:rgba(200,210,240,.3);line-height:1.6;font-family:'Inter',sans-serif\">
                                {$siteName} &bull; Lahore, Pakistan<br>
                                <a href=\"mailto:syedirfannoor996@gmail.com\" style=\"color:rgba(200,210,240,.45);text-decoration:none\">syedirfannoor996@gmail.com</a> &bull; <a href=\"tel:+923001234567\" style=\"color:rgba(200,210,240,.45);text-decoration:none\">+92 300 123 4567</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style=\"text-align:center;padding:16px 0 0\">
                            <div style=\"font-size:10px;color:rgba(200,210,240,.25);font-family:'Inter',sans-serif\">
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
