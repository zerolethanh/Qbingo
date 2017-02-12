<?php

namespace App\Http\Controllers;


use App\Master;
use App\Shop;
use App\Ticket;
use Faker\Provider\Uuid;
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
    const NVIEW_DEFAULT_ISSUED_ID = 9999;
    public $table_view = self::TICKET_TABLE_VIEW;

    public function create(Request $request)
    {
        $this->validate($request, [
            'use_date' => 'required|date|after:today',
            'user' => 'required',
            'user_email' => 'required|email|unique:tickets,user_email'
        ]);

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

        return $this->buildTicketTableView(compact('shop'));

    }

    public function stop(Request $request)
    {
        list($ticket, $table_view) = $this->getTicketAndTableViewFromRequest($request);
        if ($ticket) {
            $ticket->is_expired = !$ticket->is_expired;
            $saved = $ticket->save();
            return updateView($this->table_view, get_defined_vars(), static::TICKET_TABLE_HTML_ID);
        } else {
            //get mas
            return response([
                'err' => true,
                'err_message' => 'チケットが不正です',
                'data' => get_defined_vars()
            ], 404);
        }
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

        }
        return updateView($this->table_view, null, static::TICKET_TABLE_HTML_ID);
    }

    public function getTicketAndTableViewFromRequest(Request $request)
    {
        if ($request->has('from_master')) {
            $this->table_view = self::MASTER_TICKET_TABLE_VIEW;
            $ticket = Master::user()->tickets()->find($request->ticket_id);
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

}
