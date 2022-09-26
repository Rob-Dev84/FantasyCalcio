<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\League\LeagueType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LeagueTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();//added for foreign key contrained on leagues table

        LeagueType::truncate();

        Schema::enableForeignKeyConstraints();//added for foreign key contrained on leagues table
  
            $report = fopen(base_path("database/data/league_types.csv"), "r");
    
            $dataRow = true;
            while (($data = fgetcsv($report, 4000, ",")) !== FALSE) {
                if (!$dataRow) {
                    LeagueType::create([
                        "name" => $data['0'],
                    ]);    
                }
                $dataRow = false;
            }

        
   
        fclose($report);
    }
}
