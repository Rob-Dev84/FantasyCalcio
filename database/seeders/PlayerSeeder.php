<?php

namespace Database\Seeders;

use App\Models\Market\Player;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();//added for foreign key contrained on leagues table
        Player::truncate();
        Schema::enableForeignKeyConstraints();//added for foreign key contrained on leagues table
  
            $report = fopen(base_path("database/data/players_serie_a_2022_23.csv"), "r");
    
            $dataRow = true;
            while (($data = fgetcsv($report, 4000, ",")) !== FALSE) {
                if (!$dataRow) {
                    Player::create([
                        "role" => $data['0'],
                        "surname" => $data['1'],
                        "team" => $data['2'],
                        "current_value" => $data['3'],
                        "initial_value" => $data['4'],
                        "league_type_id" => $data['5'],
                        "active" => $data['6'],
                    ]);    
                }
                $dataRow = false;
            }
   
        fclose($report);
    }


}
