<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $now = date('Y-m-d H:i:s');

        if (! $this->db->table('portfolio_profile')->where('id', 1)->countAllResults()) {
            $this->db->table('portfolio_profile')->insert([
                'id' => 1,
                'full_name' => 'Mutiara Putri',
                'headline_id' => 'Portofolio Pribadi',
                'headline_en' => 'Personal Portfolio',
                'summary_id' => 'Mahasiswa Agribisnis semester 5 di Universitas Muhammadiyah Sukabumi.',
                'summary_en' => 'A fifth-semester Agribusiness student at Universitas Muhammadiyah Sukabumi.',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        if (! $this->db->table('education')->countAllResults()) {
            $this->db->table('education')->insert([
                'institution' => 'Universitas Muhammadiyah Sukabumi',
                'program_id' => 'Agribisnis',
                'program_en' => 'Agribusiness',
                'is_current' => 1,
                'sort_order' => 1,
                'is_visible' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
