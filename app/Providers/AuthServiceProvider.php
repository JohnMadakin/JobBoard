<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Job;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerJobPolicies();
    }

    public function registerJobPolicies()
    {
        Gate::define( 'apply-job', function ($user) {
            return $user->hasAccess([ 'apply-job']);
        });
        Gate::define('update-job', function ($user, Job $job) {
            return $user->hasAccess([ 'update-job']) or $user->id == $job->user_id;
        });
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
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->input('api_token')) {
                return User::where('api_token', $request->input('api_token'))->first();
            }
        });
    }
}
