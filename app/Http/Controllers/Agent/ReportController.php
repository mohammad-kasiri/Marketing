<?php

namespace App\Http\Controllers\Agent;

use App\Functions\DateFormatter;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {

        if (!request()->has('to_date') || !request()->has('from_date'))
        {
            return view('agent.report.index');
        }

        $to_date   = DateFormatter::format(request()->input('to_date') , '00:00');
        $from_date = DateFormatter::format(request()->input('from_date') , '00:00');


        $invoices = Invoice::query()
            ->where('user_id' , auth()->id())
            ->where('status' , '=' , 'approved')
            ->where('paid_at' , '>=' , $from_date)
            ->where('paid_at' , '<=' , $to_date)
            ->get();


        $total_amount = Invoice::query()
            ->where('user_id' , auth()->id())
            ->where('status' , '=' , 'approved')
            ->where('paid_at' , '>=' , $from_date)
            ->where('paid_at' , '<=' , $to_date)
            ->sum('price');

        return  view('agent.report.index')
            ->with(['invoices' => $invoices])
            ->with(['total_amount' => $total_amount]);
    }
}
