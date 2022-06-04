<?php
/**
 * Created by PhpStorm.
 * User: h2 gaming
 * Date: 7/3/2019
 * Time: 9:27 PM
 */
namespace Modules\Forex;

use Illuminate\Support\ServiceProvider;
use Modules\ModuleServiceProvider;
use Modules\Forex\Providers\RouterServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(){


    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
    }

    // public static function getAdminMenu()
    // {
    //     return [
    //         'forex'=>[
    //             "position"=>120,
    //             'url'   => 'admin/module/forex',
    //             'title' => __("Forex"),
    //             'icon'  => 'icon ion-ios-bookmarks',
    //             'permission'=>0
    //         ],
    //     ];
    // }
}