<?php

namespace App\Providers;

use Spatie\Permission\Models\Role;
use Illuminate\Support\ServiceProvider;

class RolesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $this->createRoles();
    }

    protected function createRoles()
    {
        // Create the 'user' role if it doesn't exist
        if (!Role::where('name', 'user')->exists()) {
            Role::create(['name' => 'user']);
        }

        // Create the 'admin' role if it doesn't exist
        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }
    }
}
