<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Artisan;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

  try {
        $databaseExists = DB::select(
            "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", 
            [config('database.connections.mysql.database')]
        );

        if (!empty($databaseExists)) {
            $this->runDatabaseDependentCode();
        }
    } catch (\Exception $e) {
        logger()->error('Database check failed: ' . $e->getMessage());
    }
    }
     protected function runDatabaseDependentCode()
    {
    $user = User::query()->first();
    if ($user) {
      View::share('userHeader',$user);
    }else{
   Artisan::call('db:seed', ['--class' => UserSeeder::class]);
   Artisan::call('serve');
    }
  }
}
