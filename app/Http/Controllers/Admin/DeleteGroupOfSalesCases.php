<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesCase;
use App\Models\SalesCaseTag;
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
        $tag= SalesCaseTag::query()->where('tag', $request->group_tag)->firstOrFail();
        $count= SalesCase::query()->where('tag_id' , $tag->id)->count();

        if ($count < 0){
            throw ValidationException::withMessages([
                'group_tag' => "پرونده ای با این کد ایجاد نشده است"
            ]);
        }
        SalesCase::query()->where('tag_id' , $tag->id)->delete();

        Session::flash('message', 'عملیات با موفقیت انجام شد');
        return redirect()->back();
    }
}
