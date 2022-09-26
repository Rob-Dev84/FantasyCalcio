<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\League\MarketType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MarketTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Schema::disableForeignKeyConstraints();//added for foreign key contrained on leagues table
        
        MarketType::truncate();
        
        Schema::enableForeignKeyConstraints();//added for foreign key contrained on leagues table
  
            $report = fopen(base_path("database/data/market_types.csv"), "r");
    
            $dataRow = true;
            while (($data = fgetcsv($report, 4000, ",")) !== FALSE) {
                if (!$dataRow) {
                    MarketType::create([
                        "name" => $data['0'],
                    ]);    
                }
                $dataRow = false;
            }
   
        fclose($report);
    }
}
