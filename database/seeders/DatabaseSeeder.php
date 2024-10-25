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
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'David Ruiz',
            'email' => 'clarkddr@gmail.com',
            'password' => 'ruiz123',
        ]);
        User::factory()->create([
            'name' => 'Eduardo Malo',
            'email' => 'jemomxl@hotmail.com',
            'password' => 'eduardo123',
        ]);
        User::factory()->create([
            'name' => 'Bayo Malo',
            'email' => 'jeduardomalo@gmail.com',
            'password' => 'bayo123',
        ]);
        User::factory()->create([
            'name' => 'Mayra Almaraz',
            'email' => 'mayriux2@hotmail.com',
            'password' => 'almaraz123',
        ]);

        $suppliers = Supplier::factory(4)->create();
        Gallery::factory(8)->create();
        Image::factory(100)->create();

        Projection::factory()->create([
            'name' => 'Invierno 24',
            'start' => '2024-09-01',
            'end' => '2024-12-31'
        ]);

        Projection::factory(25)->create();
        
        //ProjectionAmount::factory(28)->create();
        ProjectionAmount::insert([
            // Botin
            ['projection_id' => 1, 'branchid' => 6, 'familyid' => 7, 'new_sale' => 300000, 'old_sale' => 75523, 'purchase' => 150000],
            ['projection_id' => 1, 'branchid' => 22, 'familyid' => 7, 'new_sale' => 94040, 'old_sale' => 37792, 'purchase' => 47000],
            ['projection_id' => 1, 'branchid' => 3, 'familyid' => 7, 'new_sale' => 230939, 'old_sale' => 45837, 'purchase' => 115470],
            ['projection_id' => 1, 'branchid' => 12, 'familyid' => 7, 'new_sale' => 132655, 'old_sale' => 43389, 'purchase' => 66327],
            ['projection_id' => 1, 'branchid' => 13, 'familyid' => 7, 'new_sale' => 97817, 'old_sale' => 44397, 'purchase' => 48909],
            ['projection_id' => 1, 'branchid' => 23, 'familyid' => 7, 'new_sale' => 75000, 'old_sale' => 5000, 'purchase' => 37500],
            ['projection_id' => 1, 'branchid' => 24, 'familyid' => 7, 'new_sale' => 524284, 'old_sale' => 106267, 'purchase' => 262142],
            ['projection_id' => 1, 'branchid' => 2, 'familyid' => 7, 'new_sale' => 242300, 'old_sale' => 19182, 'purchase' => 121150],
            ['projection_id' => 1, 'branchid' => 11, 'familyid' => 7, 'new_sale' => 90000, 'old_sale' => 32851, 'purchase' => 56000],
            ['projection_id' => 1, 'branchid' => 15, 'familyid' => 7, 'new_sale' => 50000, 'old_sale' => 39543, 'purchase' => 30000],
            ['projection_id' => 1, 'branchid' => 7, 'familyid' => 7, 'new_sale' => 180176, 'old_sale' => 36904, 'purchase' => 90000],
            ['projection_id' => 1, 'branchid' => 8, 'familyid' => 7, 'new_sale' => 189590, 'old_sale' => 32959, 'purchase' => 95000],
            ['projection_id' => 1, 'branchid' => 9, 'familyid' => 7, 'new_sale' => 452280, 'old_sale' => 72253, 'purchase' => 226000],
            ['projection_id' => 1, 'branchid' => 1, 'familyid' => 7, 'new_sale' => 35000, 'old_sale' => 26868, 'purchase' => 22000],
            // Bota
            ['projection_id' => 1, 'branchid' => 6, 'familyid' => 6, 'new_sale' => 120000, 'old_sale' => 0, 'purchase' => 60000],
            ['projection_id' => 1, 'branchid' => 22, 'familyid' => 6, 'new_sale' => 55000, 'old_sale' => 0, 'purchase' => 27500],
            ['projection_id' => 1, 'branchid' => 3, 'familyid' => 6, 'new_sale' => 120000, 'old_sale' => 0, 'purchase' => 60000],
            ['projection_id' => 1, 'branchid' => 12, 'familyid' => 6, 'new_sale' => 45000, 'old_sale' => 0, 'purchase' => 22500],
            ['projection_id' => 1, 'branchid' => 13, 'familyid' => 6, 'new_sale' => 35000, 'old_sale' => 0, 'purchase' => 17500],
            ['projection_id' => 1, 'branchid' => 23, 'familyid' => 6, 'new_sale' => 20000, 'old_sale' => 0, 'purchase' => 10000],
            ['projection_id' => 1, 'branchid' => 24, 'familyid' => 6, 'new_sale' => 350000, 'old_sale' => 0, 'purchase' => 175000],
            ['projection_id' => 1, 'branchid' => 2, 'familyid' => 6, 'new_sale' => 100000, 'old_sale' => 0, 'purchase' => 50000],
            ['projection_id' => 1, 'branchid' => 11, 'familyid' => 6, 'new_sale' => 40000, 'old_sale' => 0, 'purchase' => 20000],
            ['projection_id' => 1, 'branchid' => 15, 'familyid' => 6, 'new_sale' => 30000, 'old_sale' => 0, 'purchase' => 15000],
            ['projection_id' => 1, 'branchid' => 7, 'familyid' => 6, 'new_sale' => 65000, 'old_sale' => 0, 'purchase' => 32500],
            ['projection_id' => 1, 'branchid' => 8, 'familyid' => 6, 'new_sale' => 80000, 'old_sale' => 0, 'purchase' => 40000],
            ['projection_id' => 1, 'branchid' => 9, 'familyid' => 6, 'new_sale' => 200000, 'old_sale' => 0, 'purchase' => 100000],
            ['projection_id' => 1, 'branchid' => 1, 'familyid' => 6, 'new_sale' => 30000, 'old_sale' => 0, 'purchase' => 15000],
            // Pantufla
            ['projection_id' => 1, 'branchid' => 6, 'familyid' => 29, 'new_sale' => 30000, 'old_sale' => 8300, 'purchase' => 13500],
            ['projection_id' => 1, 'branchid' => 22, 'familyid' => 29, 'new_sale' => 10000, 'old_sale' => 1500, 'purchase' => 4500],
            ['projection_id' => 1, 'branchid' => 3, 'familyid' => 29, 'new_sale' => 75000, 'old_sale' => 15000, 'purchase' => 33750],
            ['projection_id' => 1, 'branchid' => 12, 'familyid' => 29, 'new_sale' => 20000, 'old_sale' => 2000, 'purchase' => 9000],
            ['projection_id' => 1, 'branchid' => 13, 'familyid' => 29, 'new_sale' => 20000, 'old_sale' => 3000, 'purchase' => 9000],
            ['projection_id' => 1, 'branchid' => 23, 'familyid' => 29, 'new_sale' => 40000, 'old_sale' => 7300, 'purchase' => 18000],
            ['projection_id' => 1, 'branchid' => 24, 'familyid' => 29, 'new_sale' => 100000, 'old_sale' => 17000, 'purchase' => 45000],
            ['projection_id' => 1, 'branchid' => 2, 'familyid' => 29, 'new_sale' => 100000, 'old_sale' => 18000, 'purchase' => 45000],
            ['projection_id' => 1, 'branchid' => 11, 'familyid' => 29, 'new_sale' => 40000, 'old_sale' => 7300, 'purchase' => 18000],
            ['projection_id' => 1, 'branchid' => 15, 'familyid' => 29, 'new_sale' => 12000, 'old_sale' => 2000, 'purchase' => 5400],
            ['projection_id' => 1, 'branchid' => 7, 'familyid' => 29, 'new_sale' => 10000, 'old_sale' => 2400, 'purchase' => 4500],
            ['projection_id' => 1, 'branchid' => 8, 'familyid' => 29, 'new_sale' => 50000, 'old_sale' => 9000, 'purchase' => 22500],
            ['projection_id' => 1, 'branchid' => 9, 'familyid' => 29, 'new_sale' => 30000, 'old_sale' => 5600, 'purchase' => 13500],
            ['projection_id' => 1, 'branchid' => 1, 'familyid' => 29, 'new_sale' => 20000, 'old_sale' => 3000, 'purchase' => 9000],

            // Mallas
            ['projection_id' => 1, 'branchid' => 6, 'familyid' => 24, 'new_sale' => 11600, 'old_sale' => 0, 'purchase' => 43426],
            ['projection_id' => 1, 'branchid' => 22, 'familyid' => 24, 'new_sale' => 48700, 'old_sale' => 0, 'purchase' => 19273],
            ['projection_id' => 1, 'branchid' => 3, 'familyid' => 24, 'new_sale' => 76400, 'old_sale' => 0, 'purchase' => 17341],
            ['projection_id' => 1, 'branchid' => 12, 'familyid' => 24, 'new_sale' => 51500, 'old_sale' => 0, 'purchase' => 19547],
            ['projection_id' => 1, 'branchid' => 13, 'familyid' => 24, 'new_sale' => 47300, 'old_sale' => 0, 'purchase' => 19130],
            ['projection_id' => 1, 'branchid' => 23, 'familyid' => 24, 'new_sale' => 62500, 'old_sale' => 0, 'purchase' => 15311],
            ['projection_id' => 1, 'branchid' => 24, 'familyid' => 24, 'new_sale' => 103500, 'old_sale' => 0, 'purchase' => 54755],
            ['projection_id' => 1, 'branchid' => 2, 'familyid' => 24, 'new_sale' => 56000, 'old_sale' => 0, 'purchase' => 22711],
            ['projection_id' => 1, 'branchid' => 11, 'familyid' => 24, 'new_sale' => 48000, 'old_sale' => 0, 'purchase' => 17996],
            ['projection_id' => 1, 'branchid' => 15, 'familyid' => 24, 'new_sale' => 45000, 'old_sale' => 0, 'purchase' => 18498],
            ['projection_id' => 1, 'branchid' => 7, 'familyid' => 24, 'new_sale' => 40600, 'old_sale' => 0, 'purchase' => 17076],
            ['projection_id' => 1, 'branchid' => 8, 'familyid' => 24, 'new_sale' => 48000, 'old_sale' => 0, 'purchase' => 17320],
            ['projection_id' => 1, 'branchid' => 9, 'familyid' => 24, 'new_sale' => 93000, 'old_sale' => 0, 'purchase' => 49048],
            ['projection_id' => 1, 'branchid' => 1, 'familyid' => 24, 'new_sale' => 50000, 'old_sale' => 0, 'purchase' => 18048],
            ]);
            
        }
}
