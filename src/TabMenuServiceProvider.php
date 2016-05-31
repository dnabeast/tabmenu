<?php

namespace DNABeast\TabMenu;

use DNABeast\TabMenu\Menu;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class TabMenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Blade::directive('menu', function(){
            return "<?= app('DNABeast/TabMenu/TabMenu')->build('";
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
        $this->app->singleton('DNABeast/TabMenu/TabMenu', function()
        {
            return new Menu;
        });
    }
}
