<?php

namespace App\Http\Controllers\Admin;

use App\Functions\Date;
use App\Http\Controllers\Controller;
use App\Imports\CustomerImport;
use App\Models\CallLog;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Province;
use App\Models\SalesCase;
use App\Models\SalesCaseStatus;
use App\Models\SalesCaseTag;
use App\Models\SMSLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index()
    {
        $customers= Customer::query()->filter(request()->all());
        $customersCount= Customer::query()->count();
        return view('admin.customers.index')
            ->with(['customersCount' => $customersCount])
            ->with(['customers'     => $customers]);
    }

    public function show(Customer $customer)
    {
        $salesCases= SalesCase::query()
            ->where('customer_id', $customer->id)
            ->with('agent')
            ->with('customer')
            ->with('status')
            ->with('products')
            ->latest()->paginate(30);

        return view('admin.customers.show')
            ->with(['salesCases' => $salesCases])
            ->with(['customer' => $customer]);
    }

    public function createExcel()
    {
        $products = Product::query()->latest()->get();
        return view('admin.customers.create_excel')->with(['products' => $products]);
    }

    public function storeExcel(Request $request)
    {
        $this->validate($request, [
           'file'      => ['required','max:2048', 'mimes:xlsx,xls'],
           'products'  => ['required' , 'array'],
           'products.*'=> ['required' , 'numeric'],
           'source'    =>['required'],
        ]);

        if (!is_null($request->products) && count($request->products) != 1)
        {
            return redirect()->back()->withErrors(['products' => 'تنها یک کالا باید انتخاب شود']);
        }


        $firstStatus= SalesCaseStatus::query()->where('is_first_step', true)->first();
        if (!$firstStatus)
            return redirect()->back()->withErrors(['file' => 'هنوز هیچ وضعیت اولیه ای در سیستم تعریف نشده است.']);


        $tag= SalesCase::makeUniqueGroupTag();
        $tag= SalesCaseTag::query()->create([
            'tag' => $tag,
            'title'=> $request->source,
        ]);

        Excel::import(new CustomerImport($request->products, $tag->id),  $request->file("file"));
        Session::flash('message', 'فایل با موفقیت بارگذاری شد.');
        return redirect()->back();
    }

    public function edit(Customer $customer)
    {
        $cities= Province::query()->cities()->get();
        return view('admin.customers.edit')
            ->with(['cities'   => $cities])
            ->with(['customer' => $customer]);
    }

    public function update(Customer $customer, Request $request)
    {
        $this->validate($request, [
            "fullname"   => ['required', 'max:60'],
            "email"      => ['nullable', 'max:60', 'email'],
            "gender"     => ['in:male,female'],
            "birth_date" => ['nullable', 'min:10' , 'max:10'],
            "city_id"    => ['nullable', 'numeric', 'min:'.Province::FIRST_CITY_ID , 'max:'.Province::LAST_CITY_ID],
            "description"=> ['nullable', 'max:2000'],
        ]);

        $customer->update([
            "fullname"   => $request->fullname,
            "email"      => $request->email,
            "gender"     => $request->gender,
            "birth_date" => Date::format($request->birth_date),
            "city_id"    => $request->city_id,
            "description"=> $request->description,
        ]);

        Session::flash('message', 'مشتری با موفقیت ویرایش شد.');
        return redirect()->route('admin.customer.edit', ['customer' => $customer->id]);
    }

    public function smslog(Customer $customer)
    {
        $smslogs= SMSLog::query()->where('customer_id', $customer->id)->with('agent')->get();
        return view('admin.customers.smslog.index')
            ->with(['customer' => $customer])
            ->with(['smslogs' => $smslogs]);
    }

    public function calllog(Customer$customer)
    {
        $callLogs= CallLog::query()->where('from',$customer->mobile)->orWhere('to', $customer->mobile)->get();
        return view('admin.customers.calllog.index')
            ->with(['customer' => $customer])
            ->with(['callLogs' => $callLogs]);
    }
}
