# Quickstart Tenancy

## Installation
### 1. Package
Only if package is published
```
composer require domeo/tenancy-modules-laravel
```

### 2. Install command
This will create a few files: migrations, config file, route file and a service provider.
```
php artisan tenancy-modules:install
```

### 3. Run migration
This will create the tenants table in landlord database
```
php artisan migrate
```

### 4. Add Provider
Register the service provider in config/app.php.
```
...
App\Providers\RouteServiceProvider::class,
-> App\Providers\TenancyModulesServiceProvider::class
...
```

### 5. Add route protection
Make sure that base routes are registered on base domains only.
```
app/Providers/RouteServiceProvider.php
```
```
public function boot()
{
    $this->configureRateLimiting();

    $this->routes(function () {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    });
}
```
```
protected function mapWebRoutes()
{
foreach ($this->baseDomains() as $domain) {
Route::middleware('web')
->domain($domain)
->namespace($this->namespace)
->group(base_path('routes/web.php'));
}
}

protected function mapApiRoutes()
{
foreach ($this->baseDomains() as $domain) {
Route::prefix('api')
->domain($domain)
->middleware('api')
->namespace($this->namespace)
->group(base_path('routes/api.php'));
}
}

protected function baseDomains(): array
{
return config('tenancy-modules.base_domains');
}
```

### 6. Add base domain
```
.env
```
```
BASE_DOMAIN=example.test
```

***
***
***
