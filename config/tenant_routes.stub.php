<?php
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 14.10.22
 * Time: 00:13
 */

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

use Domeo\TenancyModulesLaravel\Middleware\IdentifyTenantBySubdomain;
use Domeo\TenancyModulesLaravel\Middleware\PreventAccessFromBaseDomain;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'web',
    IdentifyTenantBySubdomain::class,
    PreventAccessFromBaseDomain::class
])->group(function () {
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });
});
