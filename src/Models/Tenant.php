<?php declare(strict_types=1);
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 13.10.22
 * Time: 22:34
 */

namespace Domeo\TenancyModulesLaravel\Models;

use Domeo\TenancyModulesLaravel\Traits\HasDatabase;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model implements \Domeo\TenancyModulesLaravel\Contracts\Tenant
{
    use HasDatabase;
    protected $table = 'tenants';
    protected $guarded = [];

    public function getTenantKeyName(): string
    {
        return 'subdomain';
    }

    public function getTenantKey()
    {
        return $this->getAttribute($this->getTenantKeyName());
    }

}
