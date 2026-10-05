<?php
namespace App\core;

use PDO;
use PDOException;

/* START: Database — PDO connection singleton */
class Database
{
    private static ?PDO $instance = null;

    /* START: getInstance — retrieves or creates the PDO database connection */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $configFile = dirname(__DIR__, 2) . '/config/database.php';
            $config = file_exists($configFile) ? require $configFile : [];

            $host     = $config['host'] ?? '127.0.0.1';
            $port     = $config['port'] ?? 3306;
            $database = $config['database'] ?? 'livelihood_db';
            $username = $config['username'] ?? 'root';
            $password = $config['password'] ?? '';
            $charset  = $config['charset'] ?? 'utf8mb4';
            $options  = $config['options'] ?? [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $dsn = "mysql:host={$host};port={$port};dbname={$database};charset={$charset}";

            try {
                self::$instance = new PDO($dsn, $username, $password, $options);
            } catch (PDOException $e) {
                // If database does not exist yet during migration, allow connection to host only
                if ($e->getCode() === 1049) {
                    $dsnWithoutDb = "mysql:host={$host};port={$port};charset={$charset}";
                    self::$instance = new PDO($dsnWithoutDb, $username, $password, $options);
                } else {
                    throw $e;
                }
            }
        }

        return self::$instance;
    }
    /* END: getInstance */

    /* START: pdo — alias for getInstance */
    public static function pdo(): PDO
    {
        return self::getInstance();
    }
    /* END: pdo */
}
/* END: Database */
