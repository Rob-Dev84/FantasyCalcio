<?php

namespace Database\Seeders;

use App\Models\Lineup\Fixture;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FixtureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Fixture::truncate();
  
        $report = fopen(base_path("database/data/fixtures.csv"), "r");
    
            $dataRow = true;
            while (($data = fgetcsv($report, 4000, ",")) !== FALSE) {
                if (!$dataRow) {
                    Fixture::create([
                        "fixture" => $data['0'],
                        "league_type_id" => $data['1'],
                        "start" => NULL,
                        "end" => NULL,
                    ]);    
                }
                $dataRow = false;
            }
   
        fclose($report);
        
    }
}
