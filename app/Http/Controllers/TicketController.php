<?php

namespace App\Http\Controllers;


use App\Master;
use Faker\Provider\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    //

    public function create(Request $request)
    {
        $this->validate($request, [
            'use_date' => 'required|date|after:today',
            'user' => 'required',
            'user_email' => 'required|email|unique:tickets,user_email'
        ]);

        $tiket_data = $request->only('use_date', 'user', 'user_email');

        $tiket_data['issued_password'] = str_random();

        if ($shop = session('shop')) {

            DB::beginTransaction();
            $new_ticket = $shop->tickets()->create($tiket_data);
            $new_ticket->issued_id = $new_ticket->id;
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
            return back()->with(compact('new_ticket', 'new_happy'));
        }

        return 'shop is not valid';
    }

    public function stop(Request $request)
    {
        $ticket = Master::user()->tickets()->where('tickets.id', $request->ticket_id)->first();

        if ($ticket) {
            $ticket->is_expired = !$ticket->is_expired;
            $saved = $ticket->save();
        }
        $is_expired = $ticket->is_expired;

        return compact('saved', 'is_expired', 'ticket');

    }
}
