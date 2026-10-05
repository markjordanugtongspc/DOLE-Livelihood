<?php
namespace App\models;

use App\core\Database;

/* START: User — users table model */
class User extends BaseModel
{
    protected static string $table = 'users';

    /* START: findByPhone — locates user by normalized phone number */
    public static function findByPhone(string $phone): ?array
    {
        return self::firstWhere('phone', $phone);
    }
    /* END: findByPhone */

    /* START: findWithRole — retrieves user and joins role details */
    public static function findWithRole(int $id): ?array
    {
        $pdo = Database::pdo();
        $stmt = $pdo->prepare("
            SELECT u.*, r.name as role_name, r.slug as role_slug, r.redirect_path
            FROM users u
            LEFT JOIN roles r ON u.role_id = r.id
            WHERE u.id = :id
            LIMIT 1
        ");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }
    /* END: findWithRole */

    /* START: updateLastLogin — updates user's last login timestamp and resets failures */
    public static function updateLastLogin(int $id): void
    {
        $pdo = Database::pdo();
        $stmt = $pdo->prepare("
            UPDATE users
            SET last_login_at = NOW(), failed_pin_attempts = 0, locked_until = NULL
            WHERE id = :id
        ");
        $stmt->execute([':id' => $id]);
    }
    /* END: updateLastLogin */

    /* START: recordFailedAttempt — increments failure count and optionally locks account */
    public static function recordFailedAttempt(int $id, int $currentFailures, int $maxAttempts = 5, int $lockMinutes = 15): int
    {
        $newCount = $currentFailures + 1;
        $lockedUntil = null;

        if ($newCount >= $maxAttempts) {
            $lockedUntil = date('Y-m-d H:i:s', strtotime("+{$lockMinutes} minutes"));
        }

        $pdo = Database::pdo();
        $stmt = $pdo->prepare("
            UPDATE users
            SET failed_pin_attempts = :attempts, locked_until = :locked
            WHERE id = :id
        ");
        $stmt->execute([
            ':attempts' => $newCount,
            ':locked'   => $lockedUntil,
            ':id'       => $id
        ]);

        return $newCount;
    }
    /* END: recordFailedAttempt */
}
/* END: User */
