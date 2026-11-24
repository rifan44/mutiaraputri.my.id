<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePortfolioTables extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 120],
            'email' => ['type' => 'VARCHAR', 'constraint' => 190, 'unique' => true],
            'password_hash' => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('admin_users', true, ['ENGINE' => 'InnoDB']);

        $this->forge->addField([
            'id' => ['type' => 'TINYINT', 'constraint' => 3, 'unsigned' => true],
            'full_name' => ['type' => 'VARCHAR', 'constraint' => 120, 'default' => 'Mutiara Putri'],
            'headline_id' => ['type' => 'VARCHAR', 'constraint' => 180, 'default' => 'Portofolio Pribadi'],
            'headline_en' => ['type' => 'VARCHAR', 'constraint' => 180, 'default' => 'Personal Portfolio'],
            'summary_id' => ['type' => 'TEXT', 'null' => true],
            'summary_en' => ['type' => 'TEXT', 'null' => true],
            'location' => ['type' => 'VARCHAR', 'constraint' => 160, 'null' => true],
            'email' => ['type' => 'VARCHAR', 'constraint' => 190, 'null' => true],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 40, 'null' => true],
            'website' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'linkedin_url' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'instagram_url' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'avatar_path' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('portfolio_profile', true, ['ENGINE' => 'InnoDB']);

        $this->createEntryTable('education', [
            'institution' => ['type' => 'VARCHAR', 'constraint' => 180],
            'program_id' => ['type' => 'VARCHAR', 'constraint' => 180],
            'program_en' => ['type' => 'VARCHAR', 'constraint' => 180, 'null' => true],
            'description_id' => ['type' => 'TEXT', 'null' => true],
            'description_en' => ['type' => 'TEXT', 'null' => true],
            'location' => ['type' => 'VARCHAR', 'constraint' => 160, 'null' => true],
            'start_date' => ['type' => 'DATE', 'null' => true],
            'end_date' => ['type' => 'DATE', 'null' => true],
            'is_current' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
        ]);
        $this->createEntryTable('experiences', [
            'organization' => ['type' => 'VARCHAR', 'constraint' => 180],
            'role_id' => ['type' => 'VARCHAR', 'constraint' => 180],
            'role_en' => ['type' => 'VARCHAR', 'constraint' => 180, 'null' => true],
            'description_id' => ['type' => 'TEXT', 'null' => true],
            'description_en' => ['type' => 'TEXT', 'null' => true],
            'location' => ['type' => 'VARCHAR', 'constraint' => 160, 'null' => true],
            'start_date' => ['type' => 'DATE', 'null' => true],
            'end_date' => ['type' => 'DATE', 'null' => true],
            'is_current' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
        ]);
        $this->createEntryTable('projects', [
            'title_id' => ['type' => 'VARCHAR', 'constraint' => 180],
            'title_en' => ['type' => 'VARCHAR', 'constraint' => 180, 'null' => true],
            'category_id' => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
            'category_en' => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
            'description_id' => ['type' => 'TEXT', 'null' => true],
            'description_en' => ['type' => 'TEXT', 'null' => true],
            'role_id' => ['type' => 'VARCHAR', 'constraint' => 160, 'null' => true],
            'role_en' => ['type' => 'VARCHAR', 'constraint' => 160, 'null' => true],
            'tools' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'project_url' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'image_path' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'start_date' => ['type' => 'DATE', 'null' => true],
            'end_date' => ['type' => 'DATE', 'null' => true],
            'is_featured' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
        ]);
        $this->createEntryTable('skills', [
            'name_id' => ['type' => 'VARCHAR', 'constraint' => 120],
            'name_en' => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
            'category_id' => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
            'category_en' => ['type' => 'VARCHAR', 'constraint' => 120, 'null' => true],
            'level_id' => ['type' => 'VARCHAR', 'constraint' => 80, 'null' => true],
            'level_en' => ['type' => 'VARCHAR', 'constraint' => 80, 'null' => true],
        ]);
        $this->createEntryTable('certificates', [
            'name_id' => ['type' => 'VARCHAR', 'constraint' => 180],
            'name_en' => ['type' => 'VARCHAR', 'constraint' => 180, 'null' => true],
            'issuer' => ['type' => 'VARCHAR', 'constraint' => 180, 'null' => true],
            'issue_date' => ['type' => 'DATE', 'null' => true],
            'credential_url' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'image_path' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
    }

    public function down(): void
    {
        foreach (['certificates', 'skills', 'projects', 'experiences', 'education', 'portfolio_profile', 'admin_users'] as $table) {
            $this->forge->dropTable($table, true);
        }
    }

    /** @param array<string, array<string, mixed>> $fields */
    private function createEntryTable(string $table, array $fields): void
    {
        $this->forge->addField(array_merge([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
        ], $fields, [
            'sort_order' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'is_visible' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]));
        $this->forge->addKey('id', true);
        $this->forge->addKey('sort_order');
        $this->forge->addKey('is_visible');
        $this->forge->createTable($table, true, ['ENGINE' => 'InnoDB']);
    }
}
