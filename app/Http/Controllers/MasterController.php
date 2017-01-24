<?php

namespace App\Http\Controllers;

use App\Http\Middleware\MasterLogin;
use App\Master;
use App\Shop;
use Illuminate\Http\Request;
use Faker;
use Illuminate\Support\Facades\Auth;

/**
 * Class MasterController
 * @package App\Http\Controllers
 */
class MasterController extends Controller
{

    /**
     * MasterController constructor.
     */
    public function __construct()
    {
        $this->middleware(MasterLogin::class)->except('showLoginForm', 'login', 'logout');
    }

    public function master()
    {
        return Auth::guard('master')->user();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     *
     */

    public function showLoginForm()
    {
        // if logined then redirect to /master/control
        if (Auth::guard('master')->check()) {
            return redirect('/master/control');
        }
        return view('master.login');
    }

    /**
     * @param Request $request
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'master_id' => 'exists:masters,uuid',
            'password' => 'required'
        ]);

        $credentials = $request->only('uuid', 'password');

        $login_succ = Auth::guard('master')->attempt($credentials, true, true);

        if ($login_succ) {
            return redirect('/master/control');
        }
        return back()->withInput()->withErrors([
            'master_login_failed' => 'ID or Password is invalid'
        ]);

    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::guard('master')->logout();
        return redirect('/master');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function control()
    {
        return view('master.control');
    }

    /**
     * @param Faker\Generator $faker
     * @return Master new Master
     */
    public function create(Faker\Generator $faker)
    {
        $password = $faker->password;
        return Master::create([
            'name' => $faker->userName,
            'email' => $faker->email,
            'uuid' => $faker->uuid,
            'password' => bcrypt($password),
            'raw_password' => $password
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function shops()
    {
        $shops = $this->master()->shops;
        $headers = ['id', 'raw_password', 'reg_name', 'created_at_dateonly'];
        $headers_trans = ['ID', 'PASS', '登録名 ( 契約店舗)', '登録日'];
        foreach ($shops as $s) {
            $s->created_at_dateonly = $s->created_at->format('Y/m/d');
        }
        return view('master.shops')->with(compact('shops', 'headers', 'headers_trans'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function users()
    {
        return view('master.users');

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function showShopRegisterForm()
    {
        return view('master.shops.register');

    }

    /**
     * @param Request $request
     */
    public function shopRegister(Request $request)
    {
        $this->validate($request, [
            'reg_name' => 'unique:shops,reg_name',
            'email' => 'unique:shops,email'
        ]);
        $shop_data = array_except($request->all(), ['_token']);
        $shop_data['raw_password'] = str_random();
        $shop_data['password'] = bcrypt($shop_data['raw_password']);

        $newShop = $this->master()->shops()->create($shop_data);
        if ($newShop) {
            return view('master.shops.register')->with(['shop' => $newShop]);
        }
        return back()->withInput()->withErrors(['register' => false]);
    }

    public function shopDetail($shop_id)
    {
        $shop = $this->master()->shops()->find($shop_id);
        if (!$shop) {
            return back();
        }

        return view('master.shops.detail')->with(compact('shop'));
    }
}

