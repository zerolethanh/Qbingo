<?php

namespace App\Http\Controllers;

use App\Happy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.index');
    }

    public function makeRandom(Request $request)
    {
        $happy_id = date('YmdHis') . uniqid();
        $password = bcrypt(csrf_token());
        $happy_code = bcrypt($happy_id);
        $happy_uuid = \Faker\Provider\Uuid::uuid();

        $is_random = true;

        $new_happy = compact('happy_id', 'password', 'is_random', 'happy_code', 'happy_uuid');

        $happy = Happy::create($new_happy);
        return view('admin.make_random_success')->with($new_happy);
    }

    public function makeHappier(Request $request)
    {
        $this->validate($request, [
            'happy_id' => 'required|unique:happies',
            'password' => 'required'
        ]);
        $happy_id = $request->happy_id;
        $password = bcrypt($request->password);
        $happy_code = bcrypt($happy_id);
        $happy_uuid = \Faker\Provider\Uuid::uuid();
        $is_random = false;

        $new_happy = compact('happy_id', 'password', 'is_random', 'happy_code', 'happy_uuid');
        Happy::create($new_happy);
        return view('admin.make_success')->with([
            'happy_id' => $happy_id,
            'password' => request('password')
        ]);

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
