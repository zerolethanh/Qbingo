<?php

namespace App\Http\Controllers;

use App\Master;
use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
//    shop table constants
    const SHOP_TABLE_HTML_ID = 'shops_table';
    const SHOP_TABLE_VIEW = 'master.shops_table';

//    shop search keys
    const SHOP_SEARCH_KEYWORD = 'shop_search_keyword';
    const SHOP_SEARCH_REG_DATE = 'shop_search_reg_date';
    const SHOP_SEARCH_ID = 'shop_search_id';
    const URL_SHOP_SEARCH_ACTION = '/shop/search';
    const SESSION_SHOP_SEARCH_FOUND_KEY = 'SHOP_SEARCH_FOUND';

    function stop(Request $request)
    {

        if ($shop = Shop::findId($request->shop_id)) {
            $shop->is_stopping = !$shop->is_stopping;
            $shop->tickets()->update([
                'is_expired' => $shop->is_stopping
            ]);
            $shop->save();
        }
        if ($found = session(self::SESSION_SHOP_SEARCH_FOUND_KEY)) {
            $shop_ids = collect($found)->pluck('id');
            $shops = Shop::whereIn('id', $shop_ids)->latest()->get();
            return $this->buildShops($shops);
        }
//        return back();
        return updateView(self::SHOP_TABLE_VIEW);
    }

    function delete(Request $request)
    {
        DB::beginTransaction();
        if ($shop = Shop::findId($request->shop_id)) {
            $shop->tickets()->delete();
            $shop->delete();
        }
        if ($found = session(self::SESSION_SHOP_SEARCH_FOUND_KEY)) {
            $shop_ids = collect($found)->pluck('id');
            $shops = Shop::whereIn('id', $shop_ids)->latest()->get();
            session([self::SESSION_SHOP_SEARCH_FOUND_KEY => $shops]);
        }
        DB::commit();

        return updateView(self::SHOP_TABLE_VIEW);
    }

    function search(Request $request)
    {
        $search_fields = [
            self::SHOP_SEARCH_ID,
            self::SHOP_SEARCH_REG_DATE,
            self::SHOP_SEARCH_KEYWORD,
            'ticket_use_date_from',
            'ticket_use_date_to'
        ];
        $ticket_use_date_from = $request->ticket_use_date_from;
        $ticket_use_date_to = $request->ticket_use_date_to;

        // if no data to search , return  all shops;
        if (empty(array_filter($request->only($search_fields)))) {
            return $this->stop_search();
        }
//        search via ID
        $found_shops = [];

        if ($shop_id = $request->{self::SHOP_SEARCH_ID}) {
            $shop = Shop::findId($shop_id);
            if (isset($shop)) {
                $found_shops[] = $shop;

            }
        }
//        search via keyword
        if ($keyword = $request->{self::SHOP_SEARCH_KEYWORD}) {
            $search_fields = ['reg_name', 'tel', 'email'];
            $shops = Shop::where('reg_name', $keyword)
                ->orWhere('tel', $keyword)
                ->orWhere('email', $keyword)
                ->latest()->get();
            if (count($shops)) {
                $found_shops = array_merge($found_shops, collect($shops)->all());
            }
        }
        //        search via date
        if ($reg_date = $request->{self::SHOP_SEARCH_REG_DATE}) {
            $shops = Shop::whereDate('created_at', $reg_date)->latest()->get();
            if (count($shops)) {
                $found_shops = array_merge($found_shops, collect($shops)->all());
            }
        }
        //
        if ($ticket_use_date_from) {
            dbStartLog();
            $shops = Shop::whereHas('happies', function ($happies) use ($ticket_use_date_from, $ticket_use_date_to) {
                $happies->whereHas('activities', function ($a) use ($ticket_use_date_from, $ticket_use_date_to) {
                    $a->whereDate('last', '>=', $ticket_use_date_from);
                    if ($ticket_use_date_to) {
                        $a->whereDate('last', '<=', $ticket_use_date_to);
                    }
                });
            })->get();

            foreach ($shops as $shop) {
                $happies = $shop->happies()->whereHas('activities', function ($a) use ($ticket_use_date_from,$ticket_use_date_to) {
                    $a->whereDate('last', '>=', $ticket_use_date_from);
                    if($ticket_use_date_to){
                        $a->whereDate('last', '<=', $ticket_use_date_to);
                    }
                })->get();
                $shop->found_use_date_from_happies = $happies;
            }

            dbEndLog();

            if (count($shops)) {
                $found_shops = array_merge($found_shops, collect($shops)->all());
            }
        }

        //build view
        if (count($found_shops)) {
            return $this->buildShops($found_shops);
        }
        return [
            'err' => true,
            'err_message' => '該当データはありません。'
        ];
//        return all shops if no shops found
//        return $this->buildShops(null);
    }

    function show_activity_users(Request $request)
    {
        $SHOP_SEARCH_FOUND = session('SHOP_SEARCH_FOUND');
        if ($SHOP_SEARCH_FOUND) {
            $shop = collect($SHOP_SEARCH_FOUND)->first(function ($shop) use ($request) {
                return $shop->id == $request->shop_id;
            });
            $found_use_date_from_happies = $shop->found_use_date_from_happies;
            return compact('found_use_date_from_happies');
        }
    }

    function buildShops($shops)
    {
        session([self::SESSION_SHOP_SEARCH_FOUND_KEY => $shops]);
        return updateView(self::SHOP_TABLE_VIEW, $shops);
    }

    function stop_search()
    {
        session()->forget(self::SESSION_SHOP_SEARCH_FOUND_KEY);
        return updateView(self::SHOP_TABLE_VIEW);
    }
}
