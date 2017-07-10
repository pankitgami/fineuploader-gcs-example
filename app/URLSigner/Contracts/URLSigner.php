<?php
/**
 * Created by PhpStorm.
 * User: poisonous
 * Date: 8/7/17
 * Time: 3:59 PM
 */

namespace App\URLSigner\Contracts;


interface URLSigner
{
    public function signPolicy($policy);
    public function signRestRequest($url);
}