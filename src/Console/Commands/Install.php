<?php declare(strict_types=1);
/**
 * Created by mister bk! GmbH.
 * User: Dominik Feilbach
 * Date: 14.10.22
 * Time: 00:20
 */
namespace Domeo\TenancyModulesLaravel\Console\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenancy-modules:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install domeo/tenancy-modules-laravel.';

    public function handle()
    {
        $this->comment('Installing domeo/tenancy-modules-laravel...');
        $this->callSilent('vendor:publish', [
            '--provider' => 'Domeo\TenancyModulesLaravel\TenancyModulesServiceProvider',
            '--tag' => 'config',
        ]);
        $this->info('✔️  Created config/tenancy-modules.php');

        if (! file_exists(base_path('routes/tenant.php'))) {
            $this->callSilent('vendor:publish', [
                '--provider' => 'Domeo\TenancyModulesLaravel\TenancyModulesServiceProvider',
                '--tag' => 'routes',
            ]);
            $this->info('✔️  Created routes/tenant.php');
        } else {
            $this->info('Found routes/tenant.php.');
        }

        $this->callSilent('vendor:publish', [
            '--provider' => 'Domeo\TenancyModulesLaravel\TenancyModulesServiceProvider',
            '--tag' => 'providers',
        ]);
        $this->info('✔️  Created TenancyModulesServiceProvider.php');

        $this->callSilent('vendor:publish', [
            '--provider' => 'Domeo\TenancyModulesLaravel\TenancyModulesServiceProvider',
            '--tag' => 'migrations',
        ]);
        $this->info('✔️  Created migrations. Remember to run [php artisan migrate]!');

        $this->callSilent('vendor:publish', [
            '--provider' => 'Domeo\TenancyModulesLaravel\TenancyModulesServiceProvider',
            '--tag' => 'models',
        ]);
        $this->info('✔️  Created app/Models/Tenant.php!');

        if (! is_dir(database_path('migrations/tenant'))) {
            if (!mkdir($concurrentDirectory = database_path('migrations/tenant')) && !is_dir($concurrentDirectory))
            {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
            $this->info('✔️  Created database/migrations/tenant folder.');
        }

        $this->comment('✨️ domeo/tenancy-modules-laravel installed successfully.');
    }

}
