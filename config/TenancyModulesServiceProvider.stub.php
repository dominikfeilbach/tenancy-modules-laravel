<?php declare(strict_types=1);
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 14.10.22
 * Time: 00:26
 */
namespace App\Providers;

use Domeo\TenancyModulesLaravel\Middleware\IdentifyTenantBySubdomain;
use Domeo\TenancyModulesLaravel\Middleware\PreventAccessFromBaseDomain;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TenancyModulesServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->mapRoutes();
        $this->makeTenancyMiddlewareHighestPriority();
    }

    protected function mapRoutes(): void
    {
        if (file_exists(base_path('routes/tenant.php'))) {
            Route::namespace('')
                ->group(base_path('routes/tenant.php'));
        }
    }

    protected function makeTenancyMiddlewareHighestPriority()
    {
        $tenancyMiddleware = [
            // Even higher priority than the initialization middleware
            PreventAccessFromBaseDomain::class,
            IdentifyTenantBySubdomain::class
        ];

        foreach (array_reverse($tenancyMiddleware) as $middleware) {
            $this->app[\Illuminate\Contracts\Http\Kernel::class]->prependToMiddlewarePriority($middleware);
        }
    }
}
