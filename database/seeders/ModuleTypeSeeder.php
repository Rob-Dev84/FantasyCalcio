<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lineup\ModuleType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModuleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();//added for foreign key contrained on leagues table

        ModuleType::truncate();

        Schema::enableForeignKeyConstraints();//added for foreign key contrained on leagues table
  
        $report = fopen(base_path("database/data/module_types.csv"), "r");

        $dataRow = true;
        while (($data = fgetcsv($report, 4000, ",")) !== FALSE) {
            if (!$dataRow) {
                ModuleType::create([
                    "name" => $data['0'],
                ]);    
            }
            $dataRow = false;
        }

        fclose($report);
    }
}
