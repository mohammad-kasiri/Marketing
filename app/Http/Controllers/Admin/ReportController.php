<?php

namespace App\Http\Controllers\Admin;

use App\Functions\DateFormatter;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function userBaseReport()
    {
        $users = User::query()->orderBy('is_active','desc')->get();
        $products= Product::all();
        if (!request()->has('user') || !request()->has('to_date') || !request()->has('from_date'))
        {
            return view('admin.report.user_base_report')
                ->with(['users' => $users , 'products' => $products]);
        }
        if (is_null(request()->user)  || is_null(request()->to_date) || is_null(request()->from_date))
        {
            return view('admin.report.user_base_report')
                ->with(['users' => $users , 'products' => $products]);
        }

        $to_date   = DateFormatter::format(request()->input('to_date') , '00:00');
        $from_date = DateFormatter::format(request()->input('from_date') , '00:00');


        $agent = User::query()->where('id' , '=' , request()->input('user'))->first();

        if (!$agent)
            return redirect()->back();

        $invoices = Invoice::query();
        if (request()->has('product_id') && !is_null(request()->input('product_id'))) {
            $invoices = $invoices
                ->leftJoin('invoice_product', 'invoices.id', '=', 'invoice_product.invoice_id')
                ->where('invoice_product.product_id', '=',request()->input('product_id') );
        }
        $invoices= $invoices->where('user_id' , request()->input('user'))
            ->where('status' , '=' , 'approved')
            ->where('paid_at' , '>=' , $from_date)
            ->where('paid_at' , '<=' , $to_date)
            ->get();


        $total_amount = Invoice::query();
        if (request()->has('product_id') && !is_null(request()->input('product_id'))) {
            $total_amount = $total_amount
                ->leftJoin('invoice_product', 'invoices.id', '=', 'invoice_product.invoice_id')
                ->where('invoice_product.product_id', '=',request()->input('product_id') );
        }
        $total_amount= $total_amount->where('user_id' , request()->input('user'))
            ->where('status' , '=' , 'approved')
            ->where('paid_at' , '>=' , $from_date)
            ->where('paid_at' , '<=' , $to_date)
            ->sum('price');

        return  view('admin.report.user_base_report')
            ->with(['agent' => $agent])
            ->with(['invoices' => $invoices])
            ->with(['users' => $users])
            ->with(['products' => $products])
            ->with(['total_amount' => $total_amount]);
    }
    public function generalReport()
    {
        $products= Product::all();
        if (!request()->has('to_date') || !request()->has('from_date'))
        {
            return view('admin.report.general_report')
                ->with(['products' => $products]);
        }
        if (is_null(request()->to_date) || is_null(request()->from_date))
        {
            return view('admin.report.general_report')
                ->with(['products' => $products]);
        }

        $to_date   = DateFormatter::format(request()->input('to_date') , '00:00');
        $from_date = DateFormatter::format(request()->input('from_date') , '00:00');


        $invoices = Invoice::query();
        if (request()->has('product_id') && !is_null(request()->input('product_id'))) {
            $invoices = $invoices
                ->leftJoin('invoice_product', 'invoices.id', '=', 'invoice_product.invoice_id')
                ->where('invoice_product.product_id', '=',request()->input('product_id') );
        }
        $invoices= $invoices->where('status' , '=' , 'approved')
            ->where('paid_at' , '>=' , $from_date)
            ->where('paid_at' , '<=' , $to_date)
            ->get();


        $total_amount = Invoice::query();
        if (request()->has('product_id') && !is_null(request()->input('product_id'))) {
            $total_amount = $total_amount
                ->leftJoin('invoice_product', 'invoices.id', '=', 'invoice_product.invoice_id')
                ->where('invoice_product.product_id', '=',request()->input('product_id') );
        }
        $total_amount= $total_amount->where('status' , '=' , 'approved')
            ->where('paid_at' , '>=' , $from_date)
            ->where('paid_at' , '<=' , $to_date)
            ->sum('price');

        $total_amount_without_admin = Invoice::query();
        if (request()->has('product_id') && !is_null(request()->input('product_id'))) {
            $total_amount_without_admin = $total_amount
                ->leftJoin('invoice_product', 'invoices.id', '=', 'invoice_product.invoice_id')
                ->where('invoice_product.product_id', '=',request()->input('product_id') );
        }
        $total_amount_without_admin= $total_amount_without_admin->where('status' , '=' , 'approved')
            ->where('paid_at' , '>=' , $from_date)
            ->where('paid_at' , '<=' , $to_date)
            ->whereHas('user', function ($query){
                return $query->agents();
            })
            ->sum('price');

        return  view('admin.report.general_report')
            ->with(['invoices' => $invoices])
            ->with(['products' => $products])
            ->with(['total_amount_without_admin' => $total_amount_without_admin])
            ->with(['total_amount' => $total_amount]);
    }
}
