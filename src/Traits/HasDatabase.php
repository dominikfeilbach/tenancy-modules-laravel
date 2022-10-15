<?php declare(strict_types=1);
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 14.10.22
 * Time: 09:09
 */

namespace Domeo\TenancyModulesLaravel\Traits;


use Domeo\TenancyModulesLaravel\Database\DatabaseConfig;
use Domeo\TenancyModulesLaravel\Models\Tenant;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;

trait HasDatabase
{
    /**
     * Tenant's own database connection config.
     */
    public function databaseConnection(): array
    {
        $tenantDriver = $this->db_connection();
        $defaultDatabaseConfig = config("database.connections.{$tenantDriver}");
        return array_merge($defaultDatabaseConfig, $this->tenantDatabaseConfig());
    }


    public function tenantDatabaseConfig()
    {
        return [
            'driver' => $this->db_connection(),
            'host' => $this->db_host(),
            'database' => $this->db_database(),
            'username' => $this->db_user(),
            'password' => $this->db_password()
        ];
    }


    /**
     * Laravel connections like mysql
     * @return string
     */
    public function db_connection(): string
    {
        return $this->getAttribute('db_connection');
    }

    /**
     * Hostname
     * @return string
     */
    public function db_host(): string
    {
        return $this->getAttribute('db_host');
    }

    /**
     * Database name
     * @return string
     */
    public function db_database(): string
    {
        return $this->getAttribute('db_database');
    }

    /**
     * Database user
     * @return string
     */
    public function db_user(): string
    {
        return $this->getAttribute('db_user');
    }

    /**
     * Database password
     * @return string
     */
    public function db_password(): string
    {
        return $this->getAttribute('db_password');
    }

    public function createDatabase()
    {
        $schemaName = $this->db_database();
        $charset = $this->database()->getConfig('charset');
        $collation = $this->database()->getConfig('collation');
        return $this->database()->statement("CREATE DATABASE `{$schemaName}` CHARACTER SET `$charset` COLLATE `$collation`");
    }

    protected function database($connection = 'tenant'): ConnectionInterface
    {
        return DB::connection($connection);
    }




}
