<?php
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $applicant = Role::create([
            'role' => 'Applicant',
        ]);
        $employer = Role::create([
            'role' => 'Employer',
        ]);
        $admin = Role::create([
            'role' => 'Admin',
        ]);
    }
}
