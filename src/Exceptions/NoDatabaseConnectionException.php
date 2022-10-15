<?php declare(strict_types=1);
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 13.10.22
 * Time: 22:44
 */
namespace Domeo\TenancyModulesLaravel\Exceptions;

class NoDatabaseConnectionException extends \Exception
{
    public function __construct()
    {
        parent::__construct("No database connection set!");
    }
}
