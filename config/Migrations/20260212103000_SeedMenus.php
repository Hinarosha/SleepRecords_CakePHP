<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

/**
 * SeedMenus migration
 *
 * Inserts initial menu items into the `menus` table.
 * These items are used by the layout to display navigation links.
 */
class SeedMenus extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Inserts default menu items for visitors and logged-in users.
     */
    public function up(): void
    {
        $now = date('Y-m-d H:i:s');
        
        // Menu items for visitors (shown when not logged in)
        // and logged-in users (shown when authenticated)
        $menus = [
            // Visitors (no identity) – permission 0
            ['ordre' => 1, 'required_permission' => 0, 'intitule' => 'Connexion', 'lien' => '/login', 'created' => $now, 'modified' => $now],
            ['ordre' => 2, 'required_permission' => 0, 'intitule' => 'Inscription', 'lien' => '/register', 'created' => $now, 'modified' => $now],

            // Logged-in normal users (permission 0 or 1)
            ['ordre' => 3, 'required_permission' => 0, 'intitule' => 'Accueil', 'lien' => '/', 'created' => $now, 'modified' => $now],
            ['ordre' => 4, 'required_permission' => 0, 'intitule' => 'Mes enregistrements', 'lien' => '/sleep-records', 'created' => $now, 'modified' => $now],

            // Admin-only items (permission >= 2)
            ['ordre' => 5, 'required_permission' => 2, 'intitule' => 'Administration', 'lien' => '/admin', 'created' => $now, 'modified' => $now],
            ['ordre' => 6, 'required_permission' => 2, 'intitule' => 'Utilisateurs', 'lien' => '/users', 'created' => $now, 'modified' => $now],
            ['ordre' => 7, 'required_permission' => 2, 'intitule' => 'Menus', 'lien' => '/menus', 'created' => $now, 'modified' => $now],

            // Logout – visible to any logged-in user
            ['ordre' => 8, 'required_permission' => 0, 'intitule' => 'Déconnexion', 'lien' => '/logout', 'created' => $now, 'modified' => $now],
        ];
        
        // Insert all menu items using table insert method
        $table = $this->table('menus');
        $table->insert($menus)->save();
    }
    
    /**
     * Down Method.
     *
     * Removes all menu items inserted by this migration.
     */
    public function down(): void
    {
        // Delete menu items by their links
        $this->execute("DELETE FROM menus WHERE lien IN ('/login', '/register', '/', '/sleep-records', '/admin', '/users', '/menus', '/logout')");
    }
}
