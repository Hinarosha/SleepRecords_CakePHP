<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/**
 * CreateSleepRecords migration
 *
 * Defines the structure of the `sleep_records` table used by the application.
 */
class CreateSleepRecords extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Creates the `sleep_records` table with fields matching the existing
     * `SleepRecord` entity and `SleepRecordsTable` validation logic.
     */
    public function change(): void
    {
        $table = $this->table('sleep_records');

        $table
            ->addColumn('user_id', 'integer', [
                'null' => false,
            ])
            ->addColumn('date', 'date', [
                'null' => false,
            ])
            ->addColumn('bedtime', 'time', [
                'null' => false,
            ])
            ->addColumn('waketime', 'time', [
                'null' => false,
            ])
            ->addColumn('afternoon_nap', 'boolean', [
                'null' => true,
            ])
            ->addColumn('evening_nap', 'boolean', [
                'null' => true,
            ])
            ->addColumn('energy_level', 'integer', [
                'null' => false,
                'comment' => 'Energy level between 0 and 10',
            ])
            ->addColumn('sport', 'boolean', [
                'null' => true,
            ])
            ->addColumn('comments', 'text', [
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'null' => true,
            ])
            ->addIndex(['user_id'], [
                'name' => 'idx_sleep_records_user_id',
            ])
            ->create();

        // Add foreign key to users.id
        $table
            ->addForeignKey('user_id', 'users', 'id', [
                'update' => 'NO_ACTION',
                'delete' => 'CASCADE',
                'constraint' => 'fk_sleep_records_users',
            ])
            ->update();
    }
}

