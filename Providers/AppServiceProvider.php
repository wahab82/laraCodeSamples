<?php

namespace App\Providers;

use App\Builder\QueryBuilder;
use App\Models\Management\Company;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191); // for migration errors
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

}
