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
    const URL_MASTER_SHOPS = '/master/shops';
    const VIEW_MASTER_SHOP_DETAIL = 'master.shops.detail';

    /**
     * MasterController constructor.
     */
    public function __construct()
    {
        $this->middleware(MasterLogin::class)->except('showLoginForm', 'login', 'logout', 'create');
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
            MasterLogin::saveSessionMasterAndShareView();
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
//        $shops = Master::user()->shops()->latest()->get();
        return view('master.shops');//->with(compact('shops', 'headers', 'headers_trans'));
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

        $newShop = Master::user()->shops()->create($shop_data);
        if ($newShop) {
            return view('master.shops.register')->with(['shop' => $newShop]);
        }
        return back()->withInput()->withErrors(['register' => false]);
    }

    public function shopDetail($shop_id)
    {
        if ($shop = Shop::id($shop_id)) {
            // save for next save \App\Ticket by Shop
//            session(['shop' => $shop]);
            return view(self::VIEW_MASTER_SHOP_DETAIL)->with(compact('shop'));
        }
        return redirect(self::URL_MASTER_SHOPS);
    }

    public function updateShopDetail(Request $request, $shop_id)
    {
        $shop = Shop::fromSessionOrRequest();
        if (!$shop) return ['err' => true, 'err_message' => 'shop not found'];
        if ($shop->reg_name != $request->reg_name)
            $this->validate($request,
                [
                    'reg_name' => 'required|unique:shops,reg_name',
                ], ['reg_name.unique' => '登録名が登録されています。']
            );
        if ($shop->email != $request->email)
            $this->validate($request,
                [
                    'email' => 'required|email|unique:shops,email'
                ], ['email.unique' => 'メールが登録されています。']
            );

        $update_success = $shop->safeUpdate($request->all());
        //$shop->update($update_data);
        return back()->with(compact('update_success'));
    }
}

