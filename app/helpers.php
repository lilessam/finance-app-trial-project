<?php

if (!function_exists('get_csv_rows_count')) {
    /**
     * Get rows count of a CSV file.
     *
     * @param string $file
     * @return int
     */
    function get_csv_rows_count($file) {
        $file = new SplFileObject($file, 'r');
        $file->seek(PHP_INT_MAX);
        return $file->key();
    }
}
