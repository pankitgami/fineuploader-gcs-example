<?php
/**
 * Created by PhpStorm.
 * User: poisonous
 * Date: 8/7/17
 * Time: 4:36 PM
 */

namespace App\URLSigner;


use Illuminate\Support\ServiceProvider;

class URLSignerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('URLSigner', function ($app) {
            $driver = $app->make('config')->get('urlsigner.driver');
            $manager = new URLSignerManager($app);
            return $manager->driver($driver);
        });
    }
}