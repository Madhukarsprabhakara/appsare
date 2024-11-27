<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\TrackerType;
class TrackerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $count=TrackerType::count();
        if ($count==0)
        {
            DB::table('tracker_types')->insert([
                'name'=> 'HTTP / website tracking',
                'description' => 'Use HTTP(S) tracker to track website, API endpoint, or anything running on HTTP',
                'icon' => '',
                'is_active' => true,
                'sort_order' =>1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

    }
}
