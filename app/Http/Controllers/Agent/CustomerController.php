<?php

namespace App\Http\Controllers\Agent;

use App\Functions\Date;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Province;
use App\Models\SalesCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function show(Customer $customer)
    {
        $salesCases= SalesCase::query()
            ->where('customer_id', $customer->id)
            ->with('agent')
            ->with('customer')
            ->with('status')
            ->with('products')
            ->latest()->paginate(30);

        return view('agent.customers.show')
            ->with(['salesCases' => $salesCases])
            ->with(['customer' => $customer]);
    }
    public function edit(Customer $customer)
    {
        $cities= Province::query()->cities()->get();
        return view('agent.customers.edit')
            ->with(['cities'   => $cities])
            ->with(['customer' => $customer]);
    }

    public function update(Customer $customer, Request $request)
    {
        $this->validate($request, [
            "fullname"   => ['required', 'max:60'],
            "email"      => ['nullable', 'max:60', 'email'],
            "gender"     => ['required', 'in:male,female'],
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
        return redirect()->route('agent.customer.edit', ['customer' => $customer->id]);
    }
}
