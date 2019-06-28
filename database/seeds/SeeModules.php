<?php

use App\Models\WebsiteModules;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SeeModules extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WebsiteModules::insert([
            [
                'module_name' => 'Celebrities',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'module_name' => 'Groups',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'module_name' => 'Multi Source',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
