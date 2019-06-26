<?php
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

use App\Models\Spec;

class SpecsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        Spec::insert([
            [
                'name' => 'Edcation',
                'updated_at' => $now,
                'created_at' => $now,
            ],
            [
                'name' => 'Software Development',
                'updated_at' => $now,
                'created_at' => $now,
            ],
            [
                'name' => 'Banking',
                'updated_at' => $now,
                'created_at' => $now,
            ],
            [
                'name' => 'Agriculture',
                'updated_at' => $now,
                'created_at' => $now,
            ],[
                'name' => 'Accounting',
                'updated_at' => $now,
                'created_at' => $now,
            ],
            [
                'name' => 'Insurance',
                'updated_at' => $now,
                'created_at' => $now,
            ],
            [
                'name' => 'Aviation',
                'updated_at' => $now,
                'created_at' => $now,
            ],
            [
                'name' => 'Oil & Gas',
                'updated_at' => $now,
                'created_at' => $now,
            ],

        ]);
    }
}
