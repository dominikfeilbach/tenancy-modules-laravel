<?php declare(strict_types=1);
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 10.10.22
 * Time: 23:28
 */

namespace Domeo\TenancyModulesLaravel;

use Domeo\TenancyModulesLaravel\Console\Commands\Install;
use Domeo\TenancyModulesLaravel\Console\Commands\TenantCreate;
use Domeo\TenancyModulesLaravel\Contracts\Tenant;
use Domeo\TenancyModulesLaravel\Database\DatabaseManager;
use Illuminate\Support\ServiceProvider;

class TenancyModulesServiceProvider extends ServiceProvider
{
    /**
     * Register services to container.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'tenancy-modules');

        $this->app->singleton(DatabaseManager::class);
    }


    public function boot(): void
    {
        $this->commands([
            Install::class,
            TenantCreate::class
        ]);

        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('tenancy-modules.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../config/migrations/' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../config/tenant_routes.stub.php' => base_path('routes/tenant.php'),
        ], 'routes');

        $this->publishes([
            __DIR__ . '/../config/TenancyModulesServiceProvider.stub.php' => app_path('Providers/TenancyModulesServiceProvider.php'),
        ], 'providers');

        $this->publishes([
            __DIR__ . '/../config/Tenant.stub.php' => app_path('Models/Tenant.php'),
        ], 'models');

    }







}
