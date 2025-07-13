
<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = DB::table('class_forms')->get();
        $months = [-3, -2, -1, 0, 1, 2, 3];

        foreach ($classes as $class) {
            foreach ($months as $month) {
                $date = Carbon::now()->addMonths($month);
                DB::table('fees')->updateOrInsert(
                    [
                        'class' => $class->class,
                        'section' => $class->section,
                        'month' => $date->format('F'),
                        'year' => $date->format('Y'),
                        'fee_type' => 'Tuition',
                    ],
                    [
                        'academic_year' => '2025-2026',
                        'fee_amount' => 1000,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
