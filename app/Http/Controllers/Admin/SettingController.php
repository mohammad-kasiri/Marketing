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
        $ranking      = Cache::has('Setting_Ranking') ? Cache::get('Setting_Ranking') : false;
        $splitCount = Cache::has('Setting_SplitCount') ? Cache::get('Setting_SplitCount') : 0;
        return view('admin.setting.index')
            ->with(['splitCount' => $splitCount])
            ->with(['ranking' => $ranking]);
    }

    public function update(Request $request)
    {
        $this->validate($request , [
           'ranking'    => ['required' , 'boolean'],
           'splitCount' => ['required' , 'numeric' , 'min:0' , 'max:250']
        ]);

        Cache::forever('Setting_Ranking' , $request->ranking);
        Cache::forever('Setting_SplitCount' , $request->splitCount);

        Session::flash('message', 'تنظیمات با موفقیت ویرایش شد.');
        return redirect()->route('admin.setting.index');

    }
}
