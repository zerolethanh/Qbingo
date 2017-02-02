<?php

namespace App\Http\Controllers;

use App\Master;
use App\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    //
    function stop(Request $request)
    {
        $shops = Master::user()->shops()->latest()->get();
        if ($shop = $shops->find($request->shop_id)) {
            $shop->is_stopping = !$shop->is_stopping;
            $shop->save();
        }
        return updateView('master.shops_table', compact('shops'));
    }

    function delete(Request $request)
    {
        if ($shop = Shop::id($request->shop_id)) {
            $shop->delete();
        }
        $shops = Master::user()->shops()->latest()->get();
        return updateView('master.shops_table', compact('shops'));
    }
}
