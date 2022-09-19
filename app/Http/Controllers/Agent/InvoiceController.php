<?php

namespace App\Http\Controllers\Agent;

use App\Functions\DateFormatter;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = auth()->user()->invoice()->latest()->paginate(Invoice::PAGINATION_LIMIT);
        return  view('agent.invoices.index')->with(['invoices' => $invoices]);
    }

    public function create()
    {
        $products= Product::all();
        return view('agent.invoices.create')
                ->with(['products' => $products]);
    }

    public function store(Request $request)
    {
        $this->validate($request , [
            'price'          => ['required'],
            'account_number' => ['required','numeric'],
            'description'    => ['nullable'],
            'products'       => ['required' , 'array'],
            'products.*'     => ['required' , 'numeric'],
            'paid_at_date'   => ['required' , 'min:10' , 'max:10'],
            'paid_at_time'   => ['required'],
        ]);
        $invoice = auth()->user()->invoice()->create([
            'price'          => str_replace(',' , '' , $request->price),
            'account_number' => $request->account_number,
            'description'    => $request->description,
            'paid_at'        => DateFormatter::format($request->paid_at_date , $request->paid_at_time),
        ]);

        if(isset($request->products) && is_array($request->products) && count($request->products) > 0)
        {
            $invoice->products()->attach($request->products);
        }

        Session::flash('message', 'رسید   با موفقیت ایجاد شد.');
        return redirect()->route('agent.invoice.index');
    }

    public function edit(Invoice $invoice)
    {
        if($invoice->status != 'sent')
            return redirect()->back();

        $products= Product::all();
        return view('agent.invoices.edit')
            ->with(['invoice'  => $invoice])
            ->with(['products' => $products]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $this->validate($request , [
            'price'          => ['required'],
            'account_number' => ['required','numeric'],
            'description'    => ['nullable'],
            'products'       => ['required' , 'array'],
            'products.*'     => ['required' , 'numeric'],
            'paid_at_date'   => ['required' , 'min:10' , 'max:10'],
            'paid_at_time'   => ['required'],
        ]);

        $invoice->update([
            'price'          => str_replace(',' , '' , $request->price),
            'account_number' => $request->account_number,
            'description'    => $request->description,
            'paid_at'        => DateFormatter::format($request->paid_at_date , $request->paid_at_time),
        ]);

        if(isset($request->products) && is_array($request->products) && count($request->products) > 0)
        {
            $invoice->products()->sync($request->products);
        }
        Session::flash('message', 'رسید   با موفقیت ویرایش شد.');
        return redirect()->route('agent.invoice.index');
    }


    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        Session::flash('message', 'رسید   با موفقیت حذف شد.');
        return redirect()->route('agent.invoice.index');
    }

}
