<?php
/**
 * Created by PhpStorm.
 * User: poisonous
 * Date: 8/7/17
 * Time: 3:13 PM
 */

namespace App\URLSigner\Clients;

use App\URLSigner\Contracts\URLSigner as URLSignerContracts;
use Illuminate\Support\Facades\Storage;

class GCSURLSigner implements URLSignerContracts
{
    protected $key;

    protected $bucket;

    protected $clientPrivateKey;

    protected $clientAccessKey;

    /**
     * GCSURLSigner constructor.
     */
    public function __construct(array $config)
    {
        $keyName = 'gcskey.json';

        if (!isset($config['bucket'])){
            throw new \InvalidArgumentException('Bucket name is not specified in config file.');
        }

        if (!isset($config['private_key'])){
            throw new \InvalidArgumentException('Private key is not specified in config file.');
        }

        $this->bucket = $config['bucket'];

        if (isset($config['private_key']) && $config['private_key']){
            $this->clientPrivateKey = $config['private_key'];
        }

        if (isset($config['access_key']) && $config['access_key']){
            $this->clientAccessKey = $config['access_key'];
        }

        /*if (isset($config['file_path']) && $config['file_path'])
        {
            $keyPath = $config['file_path'] . DIRECTORY_SEPARATOR . $this->keyName;
        } else {
            $keyPath = base_path();
        }*/

//        $this->parseKey($keyName, $keyPath);
    }

    private function sign($stringToSign)
    {
        return base64_encode(hash_hmac(
            'sha1',
            $stringToSign,
            $this->clientPrivateKey,
            true
        ));
    }

    private function parseKey($keyName, $keyPath)
    {
        $jsonKey = file_get_contents($keyPath . DIRECTORY_SEPARATOR . $keyName);

        $this->key = json_decode($jsonKey, true);
    }

    public function signPolicy($policyStr){

        $encodedPolicy = base64_encode($policyStr);

        return ['policy' => $encodedPolicy, 'signature' => $this->sign($encodedPolicy)];
    }

    public function signRestRequest($request){

    }
}