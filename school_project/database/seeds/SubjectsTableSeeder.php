
<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = [
            ['subject_name' => 'Mathematics', 'subject_type' => 'Core', 'class' => '1', 'code' => 'M1'],
            ['subject_name' => 'Science', 'subject_type' => 'Core', 'class' => '1', 'code' => 'S1'],
            ['subject_name' => 'English', 'subject_type' => 'Core', 'class' => '1', 'code' => 'E1'],
            ['subject_name' => 'Urdu', 'subject_type' => 'Core', 'class' => '1', 'code' => 'U1'],
            ['subject_name' => 'Islamiat', 'subject_type' => 'Core', 'class' => '1', 'code' => 'I1'],
        ];

        foreach ($subjects as $subject) {
            DB::table('subjects')->updateOrInsert(
                ['subject_name' => $subject['subject_name'], 'class' => $subject['class']],
                $subject
            );
        }
    }
}
