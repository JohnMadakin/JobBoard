<?php
use Illuminate\Hashing\BcryptHasher;
use App\Models\User;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bcrypt = new BcryptHasher();

        factory(App\Models\User::class, 10)->create();
        User::create([
            'password' => $bcrypt->make('password@1'),
            'email' => 'test@test.com',
        ])->roles()->attach(3);
    }
}
