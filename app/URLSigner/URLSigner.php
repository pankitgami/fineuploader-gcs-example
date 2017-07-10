<?php
/**
 * Created by PhpStorm.
 * User: poisonous
 * Date: 8/7/17
 * Time: 4:31 PM
 */

namespace App\URLSigner;

use App\URLSigner\Contracts\URLSigner as URLSignerContract;

class URLSigner
{
    protected $client;

    /**
     * URLSigner constructor.
     * @param $client
     */
    public function __construct(URLSignerContract $client)
    {
        $this->client = $client;
    }


    public function signPolicy($url)
    {
        return $this->client->signPolicy($url);
    }

    public function signRestRequest($url)
    {
        return $this->client->signRestRequest($url);
    }
}