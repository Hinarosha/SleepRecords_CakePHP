<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/**
 * CreateMenus migration
 *
 * Defines the structure of the `menus` table used by the application.
 */
class CreateMenus extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Creates the `menus` table with fields matching the existing
     * `Menu` entity and `MenusTable` validation logic.
     */
    public function change(): void
    {
        $table = $this->table('menus');

        $table
            ->addColumn('ordre', 'integer', [
                'null' => false,
            ])
            ->addColumn('required_permission', 'integer', [
                'null' => false,
                'default' => 0,
                'comment' => 'Minimum user permission level required to see this menu (0–2)',
            ])
            ->addColumn('intitule', 'string', [
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('lien', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'null' => true,
            ])
            ->addIndex(['ordre'], [
                'name' => 'idx_menus_ordre',
            ])
            ->create();
    }
}

