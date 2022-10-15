<?php declare(strict_types=1);
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 14.10.22
 * Time: 09:16
 */
namespace App\Models;

use Domeo\TenancyModulesLaravel\Models\Tenant as BaseTenant;
use Domeo\TenancyModulesLaravel\Traits\HasDatabase;


class Tenant extends BaseTenant
{
    use HasDatabase;
}
