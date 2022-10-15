<?php declare(strict_types=1);
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 14.10.22
 * Time: 00:09
 */

namespace Domeo\TenancyModulesLaravel\Exceptions;


class NoTenantDomainException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Access for base domain requests denied!");
    }
}
