<?php

if (!function_exists('csv_to_assoc')) {
    function csv_to_assoc(string $csv, string $divider = ';'): array
    {
        //$rows = array_map(static fn($row) => explode($divider, $row), preg_split('/\r\n|\r|\n/', preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $csv)));

        $rows = array_map(static function ($row) use ($divider) {
            return array_map(static function ($value) {
                return trim($value, '"');
            }, explode($divider, $row));
        }, preg_split('/\r\n|\r|\n/', preg_replace('/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $csv)));

        $header = array_shift($rows);
        $output = [];
        foreach ($rows as $row) {
            if ($row[0] === "") {
                continue;
            }
            $output[] = array_combine($header, $row);
        }
        return $output;
    }
}
