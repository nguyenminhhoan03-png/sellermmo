<?php

namespace Database\Seeders;

use App\Models\Slug;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlugSeeder extends Seeder
{
    public function run(): void
    {
        $seeded = 0;

        foreach (DB::table('tbl_list_code')->orderBy('id')->get() as $row) {
            Slug::sync('code', $row->id, $row->name);
            $seeded++;
        }
        foreach (DB::table('logos')->orderBy('id')->get() as $row) {
            Slug::sync('logo', $row->id, $row->name);
            $seeded++;
        }
        foreach (DB::table('web')->orderBy('id')->get() as $row) {
            Slug::sync('web', $row->id, $row->name);
            $seeded++;
        }
        foreach (DB::table('ai_accounts')->orderBy('id')->get() as $row) {
            Slug::sync('ai', $row->id, $row->name);
            $seeded++;
        }

        $this->command->info("Seeded {$seeded} slugs.");
        DB::table('slugs')->get()->each(
            fn ($r) => $this->command->line(" {$r->slug_type}:{$r->slug_id} → {$r->slug}")
        );
    }
}
