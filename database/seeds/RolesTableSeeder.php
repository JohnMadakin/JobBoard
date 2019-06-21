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
            'permissions' => [
                'apply-job' => true,
                'update-profile' => true
            ]
        ]);
        $employer = Role::create([
            'role' => 'Employer',
            'permissions' => [
                'update-job' => true,
                'publish-job' => true,
                'delete-job' => true,
                'update-profile' => true
            ]
        ]);
        $admin = Role::create([
            'role' => 'Admin',
            'permissions' => [
                'update-job' => true,
                'publish-job' => true,
                'delete-job' => true,
                'update-profile' => true
            ]
        ]);
    }
}
