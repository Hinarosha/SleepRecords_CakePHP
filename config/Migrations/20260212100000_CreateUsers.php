<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/**
 * CreateUsers migration
 *
 * Defines the structure of the `users` table used by the application.
 */
class CreateUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Creates the `users` table with fields matching the existing
     * `User` entity and `UsersTable` validation logic.
     */
    public function change(): void
    {
        $table = $this->table('users');

        $table
            ->addColumn('firstname', 'string', [
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('lastname', 'string', [
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('email', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('permission', 'integer', [
                'default' => 0,
                'null' => false,
                'comment' => 'Permission level: 0–2 (2 = admin)',
            ])
            ->addColumn('created', 'datetime', [
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'null' => true,
            ])
            ->addIndex(['email'], [
                'unique' => true,
                'name' => 'idx_users_email_unique',
            ])
            ->addIndex(['username'], [
                'unique' => true,
                'name' => 'idx_users_username_unique',
            ])
            ->create();
    }
}

