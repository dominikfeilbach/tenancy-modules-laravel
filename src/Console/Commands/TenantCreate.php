<?php declare(strict_types=1);
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 14.10.22
 * Time: 10:22
 */

namespace Domeo\TenancyModulesLaravel\Console\Commands;


use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TenantCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:create {subdomain} {domain} {db_connection} {db_host} {db_database} {db_user} {db_password}';

    /**
     * The console command description.
     *  php artisan tenant:create demo https://demo.laravel-boilerplate.test mysql 127.0.0.1 demo root root
     * @var string
     */
    protected $description = 'Create tenant in table tenants';

    public function handle()
    {
        $this->comment('Creating tenant...');
        $subdomain = $this->argument('subdomain');
        $domain = $this->argument('domain');
        $db_connection = $this->argument('db_connection');
        $db_host = $this->argument('db_host');
        $db_database = $this->argument('db_database');
        $db_user = $this->argument('db_user');
        $db_password = $this->argument('db_password');

        //Only for testing
        $tenant = Tenant::query()->where('subdomain', $subdomain)->first();
        tenancy()->initialize($tenant);
        $tenant->createDatabase();
        dd('TESST');


        Tenant::create([
            'subdomain' => $subdomain,
            'domain' => $domain,
            'db_connection' => $db_connection,
            'db_host' => $db_host,
            'db_database' => $db_database,
            'db_user' => $db_user,
            'db_password' => $db_password
        ]);

        $this->comment('✨️ Tenant created successfully.');
    }
}
