<?php

if (! function_exists('portfolio_t')) {
    /** @param array<string, string> $values */
    function portfolio_t(string $locale, array $values): string
    {
        return $values[$locale] ?? $values['id'] ?? '';
    }
}

if (! function_exists('portfolio_localized')) {
    /** @param array<string, mixed>|object|null $row */
    function portfolio_localized($row, string $field, string $locale = 'id', string $fallback = ''): string
    {
        if (is_object($row)) {
            $row = (array) $row;
        }

        if (! is_array($row)) {
            return $fallback;
        }

        $value = $row[$field . '_' . $locale] ?? $row[$field . '_id'] ?? $fallback;

        return is_scalar($value) ? (string) $value : $fallback;
    }
}

if (! function_exists('portfolio_period')) {
    function portfolio_period(?string $start, ?string $end, bool $current, string $locale = 'id'): string
    {
        $months = [
            'id' => [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'en' => [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
        $monthNames = $months[$locale] ?? $months['id'];
        $format = static function (?string $value) use ($monthNames): string {
            if (! $value || strtotime($value) === false) {
                return '';
            }
            $timestamp = strtotime($value);
            return $monthNames[(int) date('n', $timestamp)] . ' ' . date('Y', $timestamp);
        };

        $first = $format($start);
        $last = $current ? ($locale === 'en' ? 'Present' : 'Sekarang') : $format($end);

        if ($first === '') {
            return $last;
        }
        if ($last === '') {
            return $first;
        }

        return $first . ' — ' . $last;
    }
}
