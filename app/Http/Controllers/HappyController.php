<?php

namespace App\Http\Controllers;

//use App\Happy;
use App\Happy;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class HappyController extends Controller
{

    public function index()
    {
        // check if logged in
        if (Auth::check()) {
            return view('bingo.control');
        }
        return view('happy.index');
    }

    /**
     * @param Request $request
     * $table = happies
     * request->happy_id == happy_uuid | happy_id
     * @return mixed
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'happy_id' => 'required',
            'password' => 'required'
        ]);

        $user = Happy::where('happy_uuid', $request->happy_id)
            ->orWhere('happy_id', $request->happy_id)->first();
        if (!$user) {
            // get ticket via email
            $email = $request->happy_id;
            $ticket = Ticket::where('user_email', $email)->first();
            if ($ticket) {
                $user = $ticket->happy;
            }
        }

        if ($user) {
            //ticket
            if (!isset($ticket))
                $ticket = $user->ticket;
            //check is expired ?
            if ($ticket->is_expired) {
                //期限切れているユーザー
                return view('happy.index')->withErrors([
                    ['msg' => 'このユーザーの使用が停止されています。']
                ]);
            }
            //success, check password
            if (Hash::check($request->password, $user->password)) {
                // login and save session
                Auth::loginUsingId($user->id, true, true);
                return view('bingo.control');
            }
        }
        //login failed
        return view('happy.index')->withErrors([
            ['msg' => 'IDまたはPASSが間違っています。']
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
