<?php
/**
 * Created by PhpStorm.
 * User: poisonous
 * Date: 8/7/17
 * Time: 4:35 PM
 */

namespace App\URLSigner\Facades;


use Illuminate\Support\Facades\Facade;

class URLSigner extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'URLSigner';
    }

}