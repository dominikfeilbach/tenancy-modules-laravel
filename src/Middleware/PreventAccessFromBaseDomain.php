<?php declare(strict_types=1);
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 14.10.22
 * Time: 00:06
 */

namespace Domeo\TenancyModulesLaravel\Middleware;


use Domeo\TenancyModulesLaravel\Exceptions\NoTenantDomainException;
use Domeo\TenancyModulesLaravel\Traits\ApiResponseHelper;
use Illuminate\Http\Request;

class PreventAccessFromBaseDomain
{
    use ApiResponseHelper;
    public function handle(Request $request, \Closure $next)
    {
        if (in_array($request->getHost(), config('tenancy-modules.base_domains'), true)) {
            $exception = new NoTenantDomainException();
            return $this->respondError($exception->getMessage());
        }

        return $next($request);
    }
}
