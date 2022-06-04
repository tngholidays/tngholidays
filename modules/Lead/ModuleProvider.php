<?php
/**
 * Created by PhpStorm.
 * User: h2 gaming
 * Date: 7/3/2019
 * Time: 9:27 PM
 */
namespace Modules\Lead;

use Illuminate\Support\ServiceProvider;
use Modules\ModuleServiceProvider;
use Modules\Lead\Providers\RouterServiceProvider;

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
    //         'Lead'=>[
    //             "position"=>20,
    //             'url'   => 'admin/module/Lead',
    //             'title' => __("Lead"),
    //             'icon'  => 'icon ion-ios-bookmarks',
    //             'permission'=>0
    //         ],
    //     ];
    // }
}