<?php
namespace App\services;

use App\core\Database;
use App\core\Request;
use Exception;

/* START: ActivityLogger — records user authentication and activity logs */
class ActivityLogger
{
    /* START: log — inserts audit entry with IP, browser, OS, and device info */
    public static function log(
        string $action,
        ?int $userId = null,
        ?string $details = null,
        array $meta = []
    ): void {
        try {
            $pdo = Database::pdo();
            $ip = Request::ip();
            $ua = Request::userAgent();

            $browser = self::detectBrowser($ua);
            $os = self::detectOS($ua);
            $deviceType = self::detectDevice($ua);

            $screen = $meta['screen'] ?? null;
            $timezone = $meta['timezone'] ?? null;
            $metaJson = !empty($meta) ? json_encode($meta) : null;

            $stmt = $pdo->prepare("
                INSERT INTO activity_logs (
                    user_id, action, ip_address, user_agent, browser, os,
                    device_type, screen, timezone, mac_address, meta, created_at
                ) VALUES (
                    :user_id, :action, :ip_address, :user_agent, :browser, :os,
                    :device_type, :screen, :timezone, NULL, :meta, NOW()
                )
            ");

            $stmt->execute([
                ':user_id'     => $userId,
                ':action'      => $action,
                ':ip_address'  => $ip,
                ':user_agent'  => substr($ua, 0, 255),
                ':browser'     => $browser,
                ':os'          => $os,
                ':device_type' => $deviceType,
                ':screen'      => $screen,
                ':timezone'    => $timezone,
                ':meta'        => $metaJson,
            ]);
        } catch (Exception $e) {
            // Fail silently on logging error to prevent interrupting user actions
            error_log('ActivityLogger error: ' . $e->getMessage());
        }
    }
    /* END: log */

    /* START: detectBrowser — extracts browser name from user agent */
    private static function detectBrowser(string $ua): string
    {
        if (str_contains($ua, 'Edg')) return 'Edge';
        if (str_contains($ua, 'Chrome')) return 'Chrome';
        if (str_contains($ua, 'Firefox')) return 'Firefox';
        if (str_contains($ua, 'Safari')) return 'Safari';
        if (str_contains($ua, 'Opera') || str_contains($ua, 'OPR')) return 'Opera';
        return 'Other';
    }
    /* END: detectBrowser */

    /* START: detectOS — extracts operating system from user agent */
    private static function detectOS(string $ua): string
    {
        if (str_contains($ua, 'Windows NT 10.0')) return 'Windows 10/11';
        if (str_contains($ua, 'Windows NT')) return 'Windows';
        if (str_contains($ua, 'Mac OS X')) return 'macOS';
        if (str_contains($ua, 'Android')) return 'Android';
        if (str_contains($ua, 'iPhone') || str_contains($ua, 'iPad')) return 'iOS';
        if (str_contains($ua, 'Linux')) return 'Linux';
        return 'Other';
    }
    /* END: detectOS */

    /* START: detectDevice — classifies device as mobile, tablet, or desktop */
    private static function detectDevice(string $ua): string
    {
        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i', $ua)) {
            return 'tablet';
        }
        if (preg_match('/(mobile|iphone|ipod|blackberry|opera mini|iemobile|wpdesktop)/i', $ua)) {
            return 'mobile';
        }
        return 'desktop';
    }
    /* END: detectDevice */
}
/* END: ActivityLogger */
