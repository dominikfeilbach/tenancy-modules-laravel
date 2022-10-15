<?php declare(strict_types=1);
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 13.10.22
 * Time: 23:12
 */

namespace Domeo\TenancyModulesLaravel\Middleware;

use App\Models\Tenant;
use Domeo\TenancyModulesLaravel\Database\DatabaseManager;
use Domeo\TenancyModulesLaravel\Exceptions\NotASubdomainException;
use Domeo\TenancyModulesLaravel\Exceptions\TenantCouldNotIdentified;
use Domeo\TenancyModulesLaravel\Tenancy;
use Domeo\TenancyModulesLaravel\Traits\ApiResponseHelper;
use Exception;
use Illuminate\Database\Eloquent\Model;

class IdentifyTenantBySubdomain extends IdentificationMiddleware
{
    use ApiResponseHelper;
    /**
     * demo.example.test => 0
     * www.demo.example.test => 1
     * @var int
     */
    public static $subdomainIndex = 0;
    public Tenancy $tenancy;

    public function __construct(Tenancy $tenancy) {
        $this->tenancy = $tenancy;
    }



    /**
     * Handles incoming requests
     * @param $request
     * @param \Closure $next
     * @return mixed
     * @throws TenantCouldNotIdentified
     */
    public function handle($request, \Closure $next)
    {
        $subdomain = $this->getSubdomain($request->getHost());
        if ($subdomain instanceof Exception) {
            throw $subdomain;
        }
        return $this->initializeTenancy($request, $next, $subdomain);
    }


    protected function getSubdomain(string $hostname)
    {
        $parts = explode('.', $hostname);
        $isLocalhost = count($parts) === 1;
        $isIpAddress = count(array_filter($parts, 'is_numeric')) === count($parts);
        $isBaseDomain = in_array($hostname, config('tenancy-modules.base_domains'));

        if ($isLocalhost || $isIpAddress || $isBaseDomain) {
            return new NotASubdomainException($hostname);
        }

        return $parts[static::$subdomainIndex];
    }


}
