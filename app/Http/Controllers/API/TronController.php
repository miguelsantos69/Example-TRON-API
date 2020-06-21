<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Wallet;
use IEXBase\TronAPI\Exception\TronException;
use Illuminate\Http\JsonResponse;
use function Sodium\add;

class TronController extends Controller
{

    /**
     * @var TronWebHelper
     */
    private $tron;

    public function __construct(TronWebHelper $tron)
    {
        $this->tron = $tron;
    }


    /**
     * Function to create a new wallet with it address and secret
     *
     * @return JsonResponse
     * @throws TronException
     */
    public function createWallet(): JsonResponse
    {
        $account = $this->tron->makeTronInstance()->generateAddress();

        if ($account) {

            $wallet = new Wallet();
            $wallet->address = $account['address'];
            $wallet->secret = $account['privateKey'];
            $wallet->save();

            return response()->json([
                'success' => true,
                'message' => 'Wallet successful created!',
                'data' => $account
            ]);

        } else {

            return response()->json([
                'status' => 'fail',
                'message' => 'Creating a wallet failed!'
            ]);
        }

    }


    /**
     * Function to show balance of specific wallet
     *
     * @param string $address
     * @return JsonResponse
     * @throws TronException
     */
    public function getWalletBalance(string $address): JsonResponse
    {
        $balance = $this->tron->makeTronInstance()->getBalance($address);

        if (isset($balance)) {

            return response()->json([
                'success' => true,
                'message' => 'Retrieving wallet balance successfully!',
                'balance' => $balance
            ]);

        } else {

            return response()->json([
                'status' => 'fail',
                'message' => 'Retrieving wallet balance failed!'
            ]);
        }
    }
}
