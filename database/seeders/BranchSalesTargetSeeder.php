<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BranchSalesTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [2, 3, 6, 8, 9, 11, 13, 15, 22, 24];

        foreach ($branches as $branch) {
            DB::table('branch_sales_targets')->insert([
                'branch_id' => $branch,
                'slug' => Str::uuid(), // O Str::random(16) si prefieres más corto
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
