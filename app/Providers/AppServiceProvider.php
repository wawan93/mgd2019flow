<?php

namespace App\Providers;

use App\Collector;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register('Appzcoder\CrudGenerator\CrudGeneratorServiceProvider');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment() === 'production') {
            URL::forceScheme("https");
        }

        $collectors = Collector::selectRaw("COUNT(*) as cnt, status")->groupBy('status')->get();
        $counts = $collectors->pluck("cnt", "status")->toArray();
        View::share("counts", $counts);
    }
}
