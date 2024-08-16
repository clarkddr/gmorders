<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\Image;
use App\Models\Supplier;
use App\Models\User;
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


        
    }
}
