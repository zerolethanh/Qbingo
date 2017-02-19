<?php

namespace App\Http\Controllers;


use App\Master;
use App\Shop;
use App\Ticket;
use Faker\Provider\Uuid;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    //
    const TICKET_TABLE = 'ticket_table';

    const TICKET_TABLE_VIEW = 'master.shops.detail_components.ticket_table';
    const MASTER_TICKET_TABLE_VIEW = 'master.users_component.master_tickets_table';
    const TICKET_TABLE_HTML_ID = 'ticket_table';
    const MASTER_TICKET_TABLE_HTML_ID = 'master_tickets_table';
    const NVIEW_DEFAULT_ISSUED_ID = 9999;
    public $table_view = self::TICKET_TABLE_VIEW;
    const URL_TICKET_SEARCH = '/ticket/search';
    const SESSION_TICKETS_KEY = 'tickets';
    const CACHE_TICKETS_KEY = 'tickets';

    public function create(Request $request)
    {
        $this->validate($request, [
            'use_date' => 'required|date|after:today',
            'user' => 'required',
            'user_email' => 'required|email|unique:tickets,user_email'
        ], [
                'user_email.unique' => 'メール ' . $request->user_email . 'がすでに登録されています'
            ]
        );

        list($ticket, $table_view) = $this->getTicketAndTableViewFromRequest($request);

        DB::beginTransaction();

        if ($request->has('by_master')) {
            //ticket created by 9-view master
        } else {
            // ticket created by shop
            try {
                $err = response([
                    'err' => true,
                    'err_message' => '店舗が見つかりません。'
                ], 404);
                $shop_id = decrypt($request->header('SHOP-ID'));
                $shop = Shop::find($shop_id);
                if (!$shop) {
                    return $err;
                }
            } catch (DecryptException $e) {
                //
                return $err;
            }
        }

        $tiket_data = $request->only('use_date', 'user', 'user_email');
        $tiket_data['issued_password'] = str_random();
        if (isset($shop)) {
            //by shop
            $new_ticket = $shop->tickets()->create($tiket_data);
            if ($new_ticket->id >= self::NVIEW_DEFAULT_ISSUED_ID) {
                /// NVIEW_DEFAULT_ISSUED_ID 被らないように設定
                $new_ticket->issued_id = $new_ticket->id + 1;
            } else {
                //
                $new_ticket->issued_id = $new_ticket->id;
            }
            $this->table_view = self::TICKET_TABLE_VIEW;
        } else {
            //by master
            $new_ticket = new Ticket($tiket_data);
            $new_ticket->issued_id = self::NVIEW_DEFAULT_ISSUED_ID;
            $this->table_view = self::MASTER_TICKET_TABLE_VIEW;
        }

        $new_ticket->save();
        //create new happy
        $happy_id = $new_ticket->user;
        $new_happy = $new_ticket->happy()->create([
            'happy_uuid' => Uuid::uuid(),//リレーション用
            'happy_id' => $happy_id,//login 用のid
            'happy_code' => bcrypt($happy_id),//招待リンクに含まれている。
            'password' => bcrypt($new_ticket->issued_password),
            'is_random' => 0
        ]);

        DB::commit();

        session()->flash('new_ticket', $new_ticket);
        return $new_ticket;

//        return updateView($this->table_view, compact('shop'));
//        return $this->buildTicketTableView(compact('shop'));

    }

    public function stop(Request $request)
    {
        list($ticket, $table_view) = $this->getTicketAndTableViewFromRequest($request);
        if ($ticket) {
            $ticket->is_expired = !$ticket->is_expired;
            $saved = $ticket->save();
            return updateView($this->table_view, get_defined_vars());
        }

        //get mas
        return response([
            'err' => true,
            'err_message' => 'チケットが不正です',
            'data' => get_defined_vars()
        ], 404);
    }

    public function delete(Request $request)
    {
        list($ticket, $table_view) = $this->getTicketAndTableViewFromRequest($request);
        if ($ticket) {
            DB::beginTransaction();
            $deleted = $ticket->delete();
            try {
                $ticket->happy->delete();
            } catch (\Exception $e) {

            }
            DB::commit();
            //return
            session()->flash('deleted_ticket', $ticket);
            return $ticket;
        }
//        return updateView($this->table_view, null, static::TICKET_TABLE_HTML_ID);
    }

    public function getTicketAndTableViewFromRequest(Request $request)
    {
        if ($request->has('by_master')) {
            $this->table_view = self::MASTER_TICKET_TABLE_VIEW;
            $ticket = Ticket::find($request->ticket_id);
        } else {
            $this->table_view = self::TICKET_TABLE_VIEW;
            $shop = Shop::fromSessionOrRequest();
            $ticket = $shop ? $shop->tickets()->find($request->ticket_id) : null;
        }

        return [$ticket, $this->table_view];
    }

    public function buildTicketTableView($shop = null)
    {
        return updateView($this->table_view, $shop, static::TICKET_TABLE_HTML_ID);
    }

    public function search(Request $request)
    {
        $ticket_keyword = $request->ticket_keyword;
        $ticket_created_date = $request->ticket_created_date;
        $ticket_id = $request->ticket_id;
        $ticket_use_date_from = $request->ticket_use_date_from;
        $ticket_use_date_to = $request->ticket_use_date_to;
        $tickets = [];

        if ($ticket_id) {
            $tickets = Ticket::where('issued_id', $ticket_id)->with('shop')->get();
            //return 1
//            if ($tickets) return $tickets;
        }
        if ($ticket_created_date) {
            $result = Ticket::whereDate('created_at', $ticket_created_date)->with('shop')->get();
            $tickets = collect($tickets)->merge($result);
            //return 2
//            if ($tickets) return $tickets;
        }
        if ($ticket_use_date_from) {
            $where = Ticket::whereDate('use_date', '>=', $ticket_use_date_from)->with('shop');
            if ($ticket_use_date_to) {
                // to $ticket_use_date_to
                $result = $where->whereDate('use_date', '<=', $ticket_use_date_to)->get();
            } else {
                //to today
//                $result = $where->whereDate('use_date', '<=', date('Y-m-d'))->get();
                $result = $where->get();
            }
            $tickets = collect($tickets)->merge($result);
        } elseif ($ticket_use_date_to) {
            $result = Ticket::whereDate('use_date', '<=', $ticket_use_date_to)->with('shop')->get();
            $tickets = collect($tickets)->merge($result);
        }

        //save tickets in session
        cache(compact(self::CACHE_TICKETS_KEY), 10);

        //update view
        return updateView(self::MASTER_TICKET_TABLE_VIEW, $tickets);

//        return $this->errorsResponse();
    }

    function errorsResponse($err = '該当なデータが見つかりませ 。', $code = 404)
    {
        $request_data = request()->all();
        return response(
            array_merge(
                compact('request_data'),
                [
                    'err' => 1,
                    'err_message' => $err
                ]
            ),
            $code);
    }

    function clear_tickets_cache()
    {
        $cache_deleted = cache()->forget(self::CACHE_TICKETS_KEY);
        return compact('cache_deleted');
    }

}