<?php declare(strict_types=1);
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 13.10.22
 * Time: 23:20
 */

namespace Domeo\TenancyModulesLaravel\Exceptions;


class NotASubdomainException extends \Exception
{
    public function __construct(string $hostname)
    {
        parent::__construct("Hostname $hostname does not include a subdomain.");
    }
}
