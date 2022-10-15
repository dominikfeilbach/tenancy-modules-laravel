<?php declare(strict_types=1);
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 15.10.22
 * Time: 11:45
 */

namespace Domeo\TenancyModulesLaravel\Middleware;


use Domeo\TenancyModulesLaravel\Exceptions\TenantCouldNotIdentified;
use Domeo\TenancyModulesLaravel\Tenancy;
use Domeo\TenancyModulesLaravel\Traits\ApiResponseHelper;

abstract class IdentificationMiddleware
{
    use ApiResponseHelper;
    protected Tenancy $tenancy;

    public function initializeTenancy($request, $next, $argument) {
        try {
            $this->tenancy->initialize($argument);
        } catch (TenantCouldNotIdentified $e) {
            return $this->respondError($e->getMessage());
        }
        return $next($request);
    }
}
