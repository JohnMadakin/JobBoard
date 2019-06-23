<?php
use App\Models\JobType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;


class JobTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        JobType::insert([
            [
                'name' => 'Full-Time',
                'updated_at' => $now,
                'created_at' => $now,
            ],
            [
                'name' => 'Part-Time',
                'updated_at' => $now,
                'created_at' => $now,
            ],
            [
                'name' => 'Remote',
                'updated_at' => $now,
                'created_at' => $now,
            ],
            [
                'name' => 'Contract',
                'updated_at' => $now,
                'created_at' => $now,
            ],

        ]);
    }
}
