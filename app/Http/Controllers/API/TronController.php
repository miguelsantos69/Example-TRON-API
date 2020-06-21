<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Wallet;

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
     */
    public function createWallet()
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
     */
    public function getWalletBalance()
    {
        //
    }

}
