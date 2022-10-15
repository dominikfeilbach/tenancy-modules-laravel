<?php declare(strict_types=1);
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 13.10.22
 * Time: 23:59
 */

namespace Domeo\TenancyModulesLaravel\Exceptions;


class TenantCouldNotIdentified extends \Exception
{
    public function __construct($parameter)
    {
        parent::__construct("Tenant could not be identified by: $parameter");
    }
}
