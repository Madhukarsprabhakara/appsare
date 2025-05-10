<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\NotificationType;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $count=NotificationType::count();
        if ($count==0)
        {
            DB::table('notification_types')->insert([
                'type'=> 'Email',
                'is_active' => true,
                'is_archived' => false,
                'is_default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            DB::table('notification_types')->insert([
                'type'=> 'Basecamp',
                'is_active' => true,
                'is_archived' => false,
                'is_default' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            DB::table('notification_types')->insert([
                'type'=> 'Slack',
                'is_active' => true,
                'is_archived' => false,
                'is_default' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            DB::table('notification_types')->insert([
                'type'=> 'Pushover',
                'is_active' => true,
                'is_archived' => false,
                'is_default' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
