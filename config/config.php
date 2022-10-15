<?php
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 11.10.22
 * Time: 12:55
 */

use Domeo\TenancyModulesLaravel\Database\MySQLDatabaseManager;
use App\Models\Tenant;
return [
    'tenant_model' => Tenant::class,
    'base_domains' => [
        '127.0.0.1',
        'localhost',
        env('BASE_DOMAIN', 'localhost')
    ],

    'database' => [
        'base_connection' => env('DB_CONNECTION', 'central'),
        'prefix' => 'tenant',
        'suffix' => '',
        'managers' => [
            'mysql' => MySQLDatabaseManager::class,
        ]
    ]

];
