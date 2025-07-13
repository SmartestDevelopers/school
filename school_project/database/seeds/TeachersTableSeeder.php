
<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            DB::table('teachers')->updateOrInsert(
                ['email' => $faker->unique()->safeEmail],
                [
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'gender' => $faker->randomElement(['male', 'female']),
                    'dob' => $faker->date($format = 'Y-m-d', $max = 'now'),
                    'blood_group' => $faker->randomElement(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']),
                    'religion' => 'Islam',
                    'class' => $faker->randomElement(['1', '2', '3', '4', '5']),
                    'section' => $faker->randomElement(['A', 'B']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
