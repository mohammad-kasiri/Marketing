<?php

namespace App\Http\Controllers\Admin;

use App\Functions\DateFormatter;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $users = User::all();
        if (!request()->has('user') || !request()->has('to_date') || !request()->has('from_date'))
        {
            return view('admin.report.index')
                ->with(['users' => $users]);
        }
        if (is_null(request()->user)  || is_null(request()->to_date) || is_null(request()->from_date))
        {
            return view('admin.report.index')
                ->with(['users' => $users]);
        }

        $to_date   = DateFormatter::format(request()->input('to_date') , '00:00');
        $from_date = DateFormatter::format(request()->input('from_date') , '00:00');


        $agent = User::query()->where('id' , '=' , request()->input('user'))->first();

        if (!$agent)
            return redirect()->back();

        $invoices = Invoice::query()
            ->where('user_id' , request()->input('user'))
            ->where('status' , '=' , 'approved')
            ->where('paid_at' , '>=' , $from_date)
            ->where('paid_at' , '<=' , $to_date)
            ->get();


        $total_amount = Invoice::query()
            ->where('user_id' , request()->input('user'))
            ->where('status' , '=' , 'approved')
            ->where('paid_at' , '>=' , $from_date)
            ->where('paid_at' , '<=' , $to_date)
            ->sum('price');

        return  view('admin.report.index')
            ->with(['agent' => $agent])
            ->with(['invoices' => $invoices])
            ->with(['users' => $users])
            ->with(['total_amount' => $total_amount]);
    }
}
