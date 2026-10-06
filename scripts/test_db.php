<?php
/* START OF FILE: scripts/test_db.php */
require_once __DIR__ . '/../backend/bootstrap.php';

use App\models\User;
use App\models\Role;
use App\core\Database;
use App\services\AuthService;

echo "--- CHECKING DATABASE CONNECTION ---\n";
try {
    $pdo = Database::pdo();
    echo "Connected to DB successfully.\n";
} catch (\Throwable $e) {
    echo "DB Connection Error: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n--- USERS LIST ---\n";
$users = User::all();
foreach ($users as $u) {
    echo "ID: {$u['id']} | Name: {$u['full_name']} | Phone: {$u['phone']} | Status: {$u['status']} | Failed Attempts: {$u['failed_pin_attempts']} | Locked Until: {$u['locked_until']}\n";
    $matches1234 = password_verify('1234', $u['pin_hash']);
    echo "   -> PIN '1234' matches: " . ($matches1234 ? "YES" : "NO") . "\n";
}

echo "\n--- TESTING AuthService::loginWithPin('', '1234') ---\n";
$res = AuthService::loginWithPin('', '1234');
echo "Result: " . json_encode($res, JSON_PRETTY_PRINT) . "\n";
/* END OF FILE: scripts/test_db.php */

