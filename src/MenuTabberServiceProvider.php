<?php

namespace Typesaucer\MenuTabber;

use Typesaucer\MenuTabber\Menu;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class MenuTabberServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Blade::directive('menu', function(){
            return "<?= app('Typesaucer/MenuTabber/Menu')->build('";
        });
        Blade::directive('endmenu', function(){
            return "');?>";
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Typesaucer/MenuTabber/Menu', function()
        {
            return new Menu;
        });
    }
}
