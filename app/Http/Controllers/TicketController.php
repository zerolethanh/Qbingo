<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

            $new_ticket = $shop->tickets()->create($tiket_data);
            $new_ticket->issued_id = $new_ticket->id;
            $new_ticket->save();

            return back()->with(compact('new_ticket'));
        }

        return 'shop is not valid';
    }
}
