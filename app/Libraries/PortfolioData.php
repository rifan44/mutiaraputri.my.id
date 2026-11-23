<?php

namespace App\Libraries;

class PortfolioData
{
    private const COLLECTIONS = ['education', 'experiences', 'projects', 'skills', 'certificates'];

    /** @return array{profile: array<string, mixed>, education: list<array<string, mixed>>, experiences: list<array<string, mixed>>, projects: list<array<string, mixed>>, skills: list<array<string, mixed>>, certificates: list<array<string, mixed>>} */
    public static function load(bool $includeHidden = false): array
    {
        $db = db_connect();
        $profile = $db->table('portfolio_profile')->where('id', 1)->get()->getRowArray() ?? [];
        $collections = [];

        foreach (self::COLLECTIONS as $table) {
            $builder = $db->table($table);

            if (! $includeHidden) {
                $builder->where('is_visible', 1);
            }

            if ($table === 'projects') {
                $builder->orderBy('is_featured', 'DESC');
            }

            $collections[$table] = $builder->orderBy('sort_order', 'ASC')->orderBy('id', 'DESC')->get()->getResultArray();
        }

        return ['profile' => $profile] + $collections;
    }
}
