<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RemainingTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sqlPath = base_path('bammanguon.sql');
        if (!file_exists($sqlPath)) {
            return;
        }

        $sql = file_get_contents($sqlPath);
        $segments = explode('INSERT INTO ', $sql);
        array_shift($segments);

        foreach ($segments as $segment) {
            $pos = strpos($segment, ");\n");
            if ($pos === false) {
                $pos = strpos($segment, ");\r\n");
            }
            if ($pos === false) {
                $pos = strrpos($segment, ');');
            }

            if ($pos !== false) {
                $query = 'INSERT IGNORE INTO ' . substr($segment, 0, $pos + 2);
                DB::unprepared($query);
            }
        }
    }
}
