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
        'App\Pages' => 'App\Policies\PagesPolicy'
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
        Gate::define('createQRCode', 'App\Policies\CodesPolicy@create');
        Gate::define('masterUser', 'App\Policies\CodesPolicy@master');
        Gate::define('editCode', 'App\Policies\CodesPolicy@edit');
        Gate::define('viewPageFile', 'App\Policies\CodesPolicy@pageFile');

        // Security Profile Gates
        Gate::define('createSecurityProfile', 'App\Policies\SecurityProfilesPolicy@create');
        Gate::define('editSecurityProfile', 'App\Policies\SecurityProfilesPolicy@edit');
        Gate::define('deleteSecurityProfile', 'App\Policies\SecurityProfilesPolicy@delete');

        // Page Gates
        Gate::define('publicAccess', 'App\Policies\PagesPolicy@publicSP');
        Gate::define('privateAccess', 'App\Policies\PagesPolicy@privateSP');
        Gate::define('masterUserPage', 'App\Policies\PagesPolicy@master');
        
        // Security Profile User Gates
        Gate::define('checkDuplicateUser', 'App\Policies\SecurityProfileUsersPolicy@duplicateUser');
        Gate::define('viewAndUpdate', 'App\Policies\SecurityProfileUsersPolicy@viewAndUpdate');
        Gate::define('fullControl', 'App\Policies\SecurityProfileUsersPolicy@fullControl');
        Gate::define('viewOnly', 'App\Policies\SecurityProfileUsersPolicy@viewOnly');
    }
}
