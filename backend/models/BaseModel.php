<?php
namespace App\models;

use App\core\Database;
use PDO;

/* START: BaseModel — base active record database model */
abstract class BaseModel
{
    protected static string $table = '';
    protected static string $primaryKey = 'id';

    /* START: find — finds record by primary key */
    public static function find(int $id): ?array
    {
        $table = static::$table;
        $pk = static::$primaryKey;
        $pdo = Database::pdo();

        $stmt = $pdo->prepare("SELECT * FROM {$table} WHERE {$pk} = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }
    /* END: find */

    /* START: all — returns all records from table */
    public static function all(string $orderBy = 'id ASC'): array
    {
        $table = static::$table;
        $pdo = Database::pdo();

        $stmt = $pdo->query("SELECT * FROM {$table} ORDER BY {$orderBy}");
        return $stmt->fetchAll();
    }
    /* END: all */

    /* START: where — searches records matching conditions */
    public static function where(string $column, mixed $value): array
    {
        $table = static::$table;
        $pdo = Database::pdo();

        $stmt = $pdo->prepare("SELECT * FROM {$table} WHERE {$column} = :val");
        $stmt->execute([':val' => $value]);
        return $stmt->fetchAll();
    }
    /* END: where */

    /* START: firstWhere — returns first record matching condition */
    public static function firstWhere(string $column, mixed $value): ?array
    {
        $table = static::$table;
        $pdo = Database::pdo();

        $stmt = $pdo->prepare("SELECT * FROM {$table} WHERE {$column} = :val LIMIT 1");
        $stmt->execute([':val' => $value]);
        $row = $stmt->fetch();

        return $row ?: null;
    }
    /* END: firstWhere */
}
/* END: BaseModel */
