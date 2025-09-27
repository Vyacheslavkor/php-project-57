<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_statuses')->insert([
            [
                'name' => 'новый',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'в работе',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'на тестировании',
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'завершен',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
