<?php

namespace Database\Seeders;

use App\Models\Family;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectionMonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $months = range(1,12);
        $summerFamilies = [
            Family::whereIn('Name',[
                'Basico', 'Bodysuit', 'Monoshort', 'Short','Brassier','Calceta',
                'Pantaleta','Bano','Sandalia','Teni','Zapatilla','Bolsa','Cinto','Lentes','Sombrero'])
                ->get()->pluck('FamilyId')->toArray()
        ];
        $winterFamilies = [
            Family::whereIn('Name',['Chamarra','Saco/Sueter','Invernal','Medias',
                'Bota','Botin','Pantufla'
                ])->get()->pluck('FamilyId')->toArray()
        ];
        $yearFamilies = [
            Family::whereIn('Name',['Blusa','Falda','Sets','Pantalon','Vestido','Mezclilla','Zapato','Generico'
            ])->get()->pluck('FamilyId')->toArray()
        ];

        function insertProjectionMonth($familyid,$month,$percentage)
        {
            DB::table('projection_months')->insert([
                'FamilyId' => $familyid,
                'projection_id' => 1,
                'month' => $month,
                'percentage' => $percentage,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach($months as $month) {

            if($month == 3) {
                foreach ($summerFamilies[0] as $familyid) {
                    insertProjectionMonth($familyid,$month,23);
                }
                foreach ($yearFamilies[0] as $familyid) {
                    insertProjectionMonth($familyid,$month,10);
                }
            }
            if($month == 4) {
                foreach ($summerFamilies[0] as $familyid) {
                    insertProjectionMonth($familyid,$month,22);
                }
                foreach ($yearFamilies[0] as $familyid) {
                    insertProjectionMonth($familyid,$month,10);
                }
            }
            if($month == 5 OR $month == 6) {
                foreach ($summerFamilies[0] as $familyid) {
                    insertProjectionMonth($familyid,$month,20);
                }
                foreach ($yearFamilies[0] as $familyid) {
                    insertProjectionMonth($familyid,$month,9);
                }
            }
            if($month == 7) {
                foreach ($summerFamilies[0] as $familyid) {
                    insertProjectionMonth($familyid,$month,15);
                }
                foreach ($yearFamilies[0] as $familyid) {
                    insertProjectionMonth($familyid,$month,7);
                }
            }
            if($month == 9) {
                foreach ($winterFamilies[0] as $familyid) {
                    insertProjectionMonth($familyid,$month,18);
                }
                foreach ($yearFamilies[0] as $familyid) {
                    insertProjectionMonth($familyid,$month,10);
                }
            }
            if($month == 10) {
                foreach ($winterFamilies[0] as $familyid) {
                    insertProjectionMonth($familyid,$month,24);
                }
                foreach ($yearFamilies[0] as $familyid) {
                    insertProjectionMonth($familyid,$month,13);
                }
            }
            if($month == 11) {
                foreach ($winterFamilies[0] as $familyid) {
                    insertProjectionMonth($familyid,$month,58);
                }
                foreach ($yearFamilies[0] as $familyid) {
                    insertProjectionMonth($familyid,$month,32);
                }
            }
        }


    }


}
