<?php

namespace App\DataSource\External;

use Illuminate\Support\Facades\Http;

class CoinLoreDataSource
{
    /**
     * @param $coinId
     * @return string
     */
    public function findUsdPriceByCoinId($coinId): string
    {
        $response = Http::get('https://api.coinlore.net/api/ticker/?id=' . $coinId);
        return json_decode($response->body())[0]->price_usd;
    }
}