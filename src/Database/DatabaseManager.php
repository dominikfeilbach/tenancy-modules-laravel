<?php declare(strict_types=1);
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 13.10.22
 * Time: 23:04
 */

namespace Domeo\TenancyModulesLaravel\Database;

use Domeo\TenancyModulesLaravel\Models\Tenant;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\DatabaseManager as LaravelDatabaseManager;
use Illuminate\Database\Eloquent\Model;

class DatabaseManager
{
    /** @var Application */
    protected $app;

    /** @var LaravelDatabaseManager */
    protected $database;

    /** @var Repository */
    protected $config;

    public function __construct(Application $app, LaravelDatabaseManager $database, Repository $config)
    {
        $this->app = $app;
        $this->database = $database;
        $this->config = $config;
    }

    /**
     * @param Model|Tenant $tenant
     * @return void
     */
    public function connectToTenant($tenant)
    {
        $this->purgeTenantConnection();
        $this->createTenantConnection($tenant);
        $this->setDefaultConnection('tenant');
    }

    /**
     * Create the tenant database connection.
     */
    public function createTenantConnection(Tenant $tenant): void
    {
        $this->config['database.connections.tenant'] = $tenant->databaseConnection();
    }

    /**
     * Change the default database connection config.
     */
    public function setDefaultConnection(string $connection): void
    {
        $this->config['database.default'] = $connection;
        $this->database->setDefaultConnection($connection);
    }


    /**
     * Purge the tenant database connection.
     */
    public function purgeTenantConnection(): void
    {
        if (array_key_exists('tenant', $this->database->getConnections())) {
            $this->database->purge('tenant');
        }

        unset($this->config['database.connections.tenant']);
    }







}
