<?php

namespace App\Http\Controllers;

use App\Master;
use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    function showLoginForm()
    {
        if ($shop = Shop::user()) {
            view()->share(compact('shop'));
            session(compact('shop'));
            return view('shop.index');
        }
        return view('shop.login');
    }

    function index()
    {
        return view('shop.index');
    }

    function login(Request $request)
    {
        $credentials = $request->only('id', 'pass');
        $shopLoggedIn = Auth::guard('shop')->attempt(
            [
                'email' => $credentials['id'],
                'password' => $credentials['pass']
            ],
            true//remember
        );
        if ($shopLoggedIn) {
            $shop = Auth::guard('shop')->user();
            session(compact('shop'));
            view()->share(compact('shop'));
            return view('shop.index', compact('shop'));
        }
        return back()
            ->withErrors('IDまたはパスワードが間違っています。')
            ->withInput();
    }

    public function update(Request $request)
    {
        if (!$loggedin_shop = Shop::user()) {
            return;
        }
        if ($request->reg_name != $loggedin_shop->reg_name) {
            $this->validate($request, [
                'reg_name' => 'required|unique:shops,reg_name'
            ]);
        }
        $updated = Shop::user()->safeUpdate($request->all());
        if ($updated) {
            $message = '情報をアップデートしました。';
            session()->flash('update_success', '情報をアップデートしました');
        } else {
            $message = '情報がアップデート出来ませんでした。';
        }
        return compact('updated', 'message');
    }

    public function logout()
    {
        Auth::guard('shop')->logout();
        return redirect('/shop');
    }

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

        //ticket use date fileter
        if ($ticket_use_date_from) {
            dbStartLog();
            $shops = Shop::whereHas('tickets', function ($tickets) use ($ticket_use_date_from, $ticket_use_date_to) {
                $tickets = $tickets->whereDate('use_date', '>=', $ticket_use_date_from);
                if ($ticket_use_date_to) {
                    $tickets->whereDate('use_date', '<=', $ticket_use_date_to);
                }
            })->get();
            foreach ($shops as $shop) {
                $tickets = $shop->tickets()->whereDate('use_date', '>=', $ticket_use_date_from);
                if ($ticket_use_date_to) {
                    $tickets->whereDate('use_date', '<=', $ticket_use_date_to);
                }
                //get from db
                $tickets = $tickets->get();
                //assign to shop
                $shop->filted_tickets = $tickets;
                // html
                $filted_tickets_html = '';
                foreach ($shop->filted_tickets as $ticket) {
                    $filted_tickets_html .= $ticket->use_date . '&nbsp;' . $ticket->user . PHP_EOL;
                }
                $shop->filted_tickets_html = $filted_tickets_html;
//                info($shop->filted_tickets);
            }
            dbEndLog();

            if (count($shops)) {
                $found_shops = array_merge($found_shops, collect($shops)->all());
            }
        } elseif ($ticket_use_date_to) {
            dbStartLog();
            $shops = Shop::whereHas('tickets', function ($tickets) use ($ticket_use_date_to) {
                $tickets->whereDate('use_date', '<=', $ticket_use_date_to);
            })->get();
            dbEndLog();

            foreach ($shops as $shop) {
                $tickets = $shop->tickets()->whereDate('use_date', '<=', $ticket_use_date_to)->get();
                $shop->filted_tickets = $tickets;
                // html
                $filted_tickets_html = '';
                foreach ($shop->filted_tickets as $ticket) {
                    $filted_tickets_html .= $ticket->use_date . '&nbsp;' . $ticket->user . PHP_EOL;
                }
                $shop->filted_tickets_html = $filted_tickets_html;
            }

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
