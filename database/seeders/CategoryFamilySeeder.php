<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('category_family')->insert([
            ["CategoryId" => "1", "FamilyId" => "2"],
            ["CategoryId" => "1", "FamilyId" => "3"],
            ["CategoryId" => "1", "FamilyId" => "4"],
            ["CategoryId" => "1", "FamilyId" => "13"],
            ["CategoryId" => "1", "FamilyId" => "17"],
            ["CategoryId" => "1", "FamilyId" => "21"],
            ["CategoryId" => "1", "FamilyId" => "26"],
            ["CategoryId" => "1", "FamilyId" => "28"],
            ["CategoryId" => "1", "FamilyId" => "30"],
            ["CategoryId" => "1", "FamilyId" => "32"],
            ["CategoryId" => "1", "FamilyId" => "35"],
            ["CategoryId" => "4", "FamilyId" => "8"],
            ["CategoryId" => "4", "FamilyId" => "9"],
            ["CategoryId" => "4", "FamilyId" => "11"],
            ["CategoryId" => "4", "FamilyId" => "12"],
            ["CategoryId" => "4", "FamilyId" => "18"],
            ["CategoryId" => "4", "FamilyId" => "24"],
            ["CategoryId" => "4", "FamilyId" => "27"],
            ["CategoryId" => "12", "FamilyId" => "1"],
            ["CategoryId" => "12", "FamilyId" => "6"],
            ["CategoryId" => "12", "FamilyId" => "7"],
            ["CategoryId" => "12", "FamilyId" => "29"],
            ["CategoryId" => "12", "FamilyId" => "31"],
            ["CategoryId" => "12", "FamilyId" => "34"],
            ["CategoryId" => "12", "FamilyId" => "36"],
            ["CategoryId" => "12", "FamilyId" => "37"],

            ["CategoryId" => "2", "FamilyId" => "2"],
            ["CategoryId" => "2", "FamilyId" => "5"],
            ["CategoryId" => "2", "FamilyId" => "10"],
            ["CategoryId" => "2", "FamilyId" => "14"],
            ["CategoryId" => "2", "FamilyId" => "15"],
            ["CategoryId" => "2", "FamilyId" => "19"],
            ["CategoryId" => "2", "FamilyId" => "20"],
            ["CategoryId" => "2", "FamilyId" => "22"],
            ["CategoryId" => "2", "FamilyId" => "23"],
            ["CategoryId" => "2", "FamilyId" => "33"],            
        ]);
    }
}
