<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        'App\Codes' => 'App\Policies\CodesPolicy',
        'App\SecurityProfiles' => 'App\Policies\SecurityProfilesPolicy',
        'App\SecurityProfileUsers' => 'App\Policies\SecurityProfileUsersPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Code Gates
        Gate::define('editPage', 'App\Policies\CodesPolicy@edit');
        Gate::define('viewPageFile', 'App\Policies\CodesPolicy@pageFile');

        // Security Profile Gates
        Gate::define('editSecurityProfile', 'App\Policies\SecurityProfilesPolicy@edit');
        
        // Security Profile User Gates
        Gate::define('checkDuplicateUser', 'App\Policies\SecurityProfileUsersPolicy@duplicateUser');
    }
}
