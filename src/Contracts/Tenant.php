<?php declare(strict_types=1);
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 13.10.22
 * Time: 23:53
 */
namespace Domeo\TenancyModulesLaravel\Contracts;

interface Tenant
{
    /** Get the name of the key used for identifying the tenant. */
    public function getTenantKeyName(): string;

    public function getTenantKey();
}
