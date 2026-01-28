<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function token($symbol)
    {
        $symbol = strtoupper($symbol);
        $tokens = [
            'BTC' => ['name' => 'Bitcoin', 'price' => '88,000.00', 'color' => 'text-yellow-600'],
            'ETH' => ['name' => 'Ethereum', 'price' => '3,450.00', 'color' => 'text-blue-600'],
            'SOL' => ['name' => 'Solana', 'price' => '125.50', 'color' => 'text-purple-600'],
        ];

        $data = $tokens[$symbol] ?? ['name' => 'Unknown Token', 'price' => '0.00', 'color' => 'text-gray-600'];

        return view('token', [
            'symbol' => $symbol,
            'tokenData' => $data
        ]);
    }

    public function transaction(Request $request)
    {
        $txHash = $request->input('hash', '-');
                $status = strlen($txHash) > 10 ? 'Success' : 'Not Found';

        return view('transaction', [
            'hash' => $txHash,
            'status' => $status
        ]);
    }
}