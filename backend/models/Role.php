<?php
namespace App\models;

/* START: Role — roles table model */
class Role extends BaseModel
{
    protected static string $table = 'roles';

    /* START: findBySlug — locates role record by its unique slug */
    public static function findBySlug(string $slug): ?array
    {
        return self::firstWhere('slug', $slug);
    }
    /* END: findBySlug */
}
/* END: Role */
