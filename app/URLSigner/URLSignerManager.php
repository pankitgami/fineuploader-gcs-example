<?php
/**
 * Created by PhpStorm.
 * User: poisonous
 * Date: 8/7/17
 * Time: 4:46 PM
 */

namespace App\URLSigner;


use App\URLSigner\Clients\GCSURLSigner;
use Illuminate\Support\Manager;

class URLSignerManager extends Manager
{

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return 'gcs';
    }

    public function createGcsDriver(){
        $config = $this->app->make('config')->get('urlsigner.gcs');

        return new GCSURLSigner($config);
    }
}