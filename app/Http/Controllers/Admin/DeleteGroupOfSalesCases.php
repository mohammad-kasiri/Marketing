<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class DeleteGroupOfSalesCases extends Controller
{
    public function index()
    {
        return view('admin.setting.delete_sales_cases.index');
    }

    public function destroy(Request $request)
    {
        $count= SalesCase::query()->where('group_tag' , $request->group_tag)->count();

        if ($count < 0){
            throw ValidationException::withMessages([
                'group_tag' => "پرونده ای با این کد ایجاد نشده است"
            ]);
        }
        SalesCase::query()->where('group_tag' , $request->group_tag)->delete();

        Session::flash('message', 'عملیات با موفقیت ایجاد شد');
        return redirect()->back();
    }
}
