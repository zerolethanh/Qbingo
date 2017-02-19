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

        if ($shop = Shop::id($request->shop_id)) {
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
        if ($shop = Shop::id($request->shop_id)) {
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
        $search_fields = [self::SHOP_SEARCH_ID, self::SHOP_SEARCH_REG_DATE, self::SHOP_SEARCH_KEYWORD];
        // if no data to search , return  all shops;
        if (empty(array_filter($request->only($search_fields)))) {
            return $this->stop_search();
        }
//        search via ID
        if ($shop_id = $request->{self::SHOP_SEARCH_ID}) {
            $shop = Shop::id($shop_id);
            if (isset($shop)) {
                $shops = [$shop];
//                return 1
                return $this->buildShops($shops);
            }
        }
//        search via keyword
        if ($keyword = $request->{self::SHOP_SEARCH_KEYWORD}) {
            $search_fields = ['reg_name', 'tel', 'email'];

            foreach ($search_fields as $idx => $field) {
                if ($idx == 0) {
                    $wheres = Shop::where($field, $keyword);
                } else {
                    if (isset($wheres)) {
                        $wheres = $wheres->orWhere($field, $keyword);
                    }
                }
            }
            //query
            if (isset($wheres)) {
                $shops = $wheres->latest()->get();
            }

            if (isset($shops)) {
//                return 2
                return $this->buildShops($shops);
            }

        }
        //        search via date
        if ($reg_date = $request->{self::SHOP_SEARCH_REG_DATE}) {
            $shops = Shop::whereDate('created_at', $reg_date)->latest()->get();
            if (count($shops)) {
//                return 3
                return $this->buildShops($shops);
            }
        }
        return [
            'err' => true,
            'err_message' => '該当データはありません。'
        ];
//        return all shops if no shops found
//        return $this->buildShops(null);
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
