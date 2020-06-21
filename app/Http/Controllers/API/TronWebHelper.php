<?php


namespace App\Http\Controllers\API;

use IEXBase\TronAPI\Exception\TronException;
use IEXBase\TronAPI\Tron;

class TronWebHelper
{
    private const HOST = 'https://api.trongrid.io';


    /**
     * @return Tron
     * @throws TronException
     */
    public function makeTronInstance() {

        $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider(self::HOST);
        $solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider(self::HOST);
        $eventServer = new \IEXBase\TronAPI\Provider\HttpProvider(self::HOST);

        try {
            $tron = new Tron($fullNode, $solidityNode, $eventServer);
        } catch (TronException $e) {
            exit($e->getMessage());
        }

        return $tron;
    }
}
