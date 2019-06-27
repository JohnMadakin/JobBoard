<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Job;
use App\Models\Profile;
use App\Policies\ProfilePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Profile::class => ProfilePolicy::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->registerPolicies();
    }
    

    public function registerJobPolicies()
    {
        Gate::define( 'apply-job', function ($user) {
            return $user->hasAccess([ 'apply-job']);
        });
        Gate::define('update-job', function ($user, Job $job) {
            return $user->hasAccess(['update-job']) or $user->id == $job->user_id;
        });
        Gate::define('update-profile', 'App\Policies\ProfilePolicy@update');
        // Gate::define('update-profile', function ($user, Profile $profile) {
        //     var_dump('i was here');
        //     var_dump( $user->id);
        //     var_dump($profile->userId);
        //     return $user->hasAccess(['update-profile']) or $user->id == $profile->userId;
        // });

        Gate::define('publish-job', function ($user) {
            return $user->hasAccess(['publish-job']);
        });
        Gate::define('delete-job', function ($user) {
            return $user->hasAccess(['delete-job']);
        });
        Gate::define('see-all-jobs', function ($user) {
            return $user->inRole('employer');
        });
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerJobPolicies();

        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        // $this->registerPolicies();
        Passport::tokensCan([
            'create-jobs' => 'Create Jobs',
            'update-jobs' => 'Update Jobs',
            'apply-jobs' => 'Apply for Jobs',
            'admin-privileges' => 'Admin Privileges'
        ]);
    }
}
