<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\Image;
use App\Models\Projection;
use App\Models\ProjectionAmount;
use App\Models\Supplier;
use App\Models\User;
use Database\Factories\BranchProjectionFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $suppliers = Supplier::factory(4)->create();
        Gallery::factory(8)->create();
        Image::factory(100)->create();

        Projection::factory()->create([
            'name' => 'Invierno 24',
            'start' => '2024-09-01',
            'end' => '2024-12-31'
        ]);      
        
        ProjectionAmount::factory(28)->create();
        ProjectionAmount::insert([
        ['projection_id' => 1, 'branchid' => 6, 'familyid' => 7, 'new_sale' => 300000, 'old_sale' => 75523, 'purchase' => 375523],
        ['projection_id' => 1, 'branchid' => 22, 'familyid' => 7, 'new_sale' => 94040, 'old_sale' => 37792, 'purchase' => 131832],
        ['projection_id' => 1, 'branchid' => 3, 'familyid' => 7, 'new_sale' => 230939, 'old_sale' => 45837, 'purchase' => 276776],
        ['projection_id' => 1, 'branchid' => 12, 'familyid' => 7, 'new_sale' => 132655, 'old_sale' => 43389, 'purchase' => 176043],
        ['projection_id' => 1, 'branchid' => 13, 'familyid' => 7, 'new_sale' => 97817, 'old_sale' => 44397, 'purchase' => 142214],
        ['projection_id' => 1, 'branchid' => 23, 'familyid' => 7, 'new_sale' => 75000, 'old_sale' => 5000, 'purchase' => 80000],
        ['projection_id' => 1, 'branchid' => 24, 'familyid' => 7, 'new_sale' => 524284, 'old_sale' => 106267, 'purchase' => 630551],
        ['projection_id' => 1, 'branchid' => 2, 'familyid' => 7, 'new_sale' => 242300, 'old_sale' => 19182, 'purchase' => 261481],
        ['projection_id' => 1, 'branchid' => 11, 'familyid' => 7, 'new_sale' => 90000, 'old_sale' => 32851, 'purchase' => 122851],
        ['projection_id' => 1, 'branchid' => 15, 'familyid' => 7, 'new_sale' => 50000, 'old_sale' => 39543, 'purchase' => 89543],
        ['projection_id' => 1, 'branchid' => 7, 'familyid' => 7, 'new_sale' => 180176, 'old_sale' => 36904, 'purchase' => 217080],
        ['projection_id' => 1, 'branchid' => 8, 'familyid' => 7, 'new_sale' => 189590, 'old_sale' => 32959, 'purchase' => 222549],
        ['projection_id' => 1, 'branchid' => 9, 'familyid' => 7, 'new_sale' => 452280, 'old_sale' => 72253, 'purchase' => 524533],
        ['projection_id' => 1, 'branchid' => 1, 'familyid' => 7, 'new_sale' => 35000, 'old_sale' => 26868, 'purchase' => 61868],
        ]);
        
    }
}
