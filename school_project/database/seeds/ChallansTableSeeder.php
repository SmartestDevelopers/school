
<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\Carbon;

class ChallansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $students = DB::table('admission_forms')->get();

        foreach ($students as $student) {
            DB::table('challans')->updateOrInsert(
                [
                    'full_name' => $student->full_name,
                    'class' => $student->class,
                    'section' => $student->section,
                    'from_month' => Carbon\Carbon::now()->format('F'),
                    'from_year' => Carbon\Carbon::now()->format('Y'),
                ],
                [
                    'school_name' => 'My School',
                    'father_name' => $student->parent_name,
                    'academic_year' => '2025-2026',
                    'year' => Carbon\Carbon::now()->format('Y'),
                    'total_fee' => 1000,
                    'status' => 'unpaid',
                    'due_date' => Carbon\Carbon::now()->addDays(15)->format('Y-m-d'),
                    'amount_in_words' => 'One Thousand',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
