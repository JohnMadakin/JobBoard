<?php

use Illuminate\Support\Carbon;

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profiles = Array();
        $now = Carbon::now();
        for ($x = 1; $x <= 11; $x++) {
            array_push($profiles, [
                'user_id' => $x,
                'updated_at' => $now,
                'created_at' => $now,
            ]);
        }
        Profile::insert($profiles);
    }
}
