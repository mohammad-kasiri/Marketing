<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function index()
    {
        $ranking = Cache::has('Setting_Ranking') ? Cache::get('Setting_Ranking') : false;
        return view('admin.setting.index')
            ->with(['ranking' => $ranking]);
    }

    public function update(Request $request)
    {
        $this->validate($request , [
           'ranking' => ['required' , 'boolean']
        ]);

        Cache::forever('Setting_Ranking' , $request->ranking);

        Session::flash('message', 'تنظیمات با موفقیت ویرایش شد.');
        return redirect()->route('admin.setting.index');

    }
}
