<?php declare(strict_types=1);
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 15.10.22
 * Time: 11:48
 */

namespace Domeo\TenancyModulesLaravel;


use Domeo\TenancyModulesLaravel\Contracts\Tenant;
use Domeo\TenancyModulesLaravel\Database\DatabaseManager;
use Domeo\TenancyModulesLaravel\Exceptions\TenantCouldNotIdentified;
use Illuminate\Database\Eloquent\Model;

class Tenancy
{
    /** @var Tenant|Model|null */
    public $tenant;

    /** @var bool */
    public $initialized = false;


    public DatabaseManager $databaseManager;

    public function __construct(DatabaseManager $databaseManager) {
        $this->databaseManager = $databaseManager;
    }

    /**
     * Initializes the tenant.
     * @param Tenant|int|string $tenant
     * @return void
     */
    public function initialize($tenant)
    {
        if (!is_object($tenant)) {
            $tenant = $this->find($tenant);

            if (! $tenant) {
                throw new TenantCouldNotIdentified($tenant);
            }
        }

        // Performance: tenant is same
        if ($this->initialized && $this->tenant->getTenantKey() === $tenant->getTenantKey()) {
            return;
        }

        if ($this->initialized) {
           $this->cleanUp();
        }

        $this->tenant = $tenant;
        $this->initialized = true;
        $this->databaseManager->connectToTenant($this->tenant);

    }

    public function cleanUp(): void
    {
        $this->initialized = false;
        $this->tenant = null;
    }

    public function find($id): ?Tenant
    {
        return $this->model()::query()->where($this->model()->getTenantKeyName(), $id)->first();
    }

    /**
     * @return Tenant|Model
     */
    public function model()
    {
        $class = config('tenancy-modules.tenant_model');
        return new $class;
    }





}
