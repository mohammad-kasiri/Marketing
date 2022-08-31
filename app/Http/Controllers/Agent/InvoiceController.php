<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = auth()->user()->invoice()->paginate(Invoice::PAGINATION_LIMIT);
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
            'price'          => ['required','numeric'],
            'account_number' => ['required','numeric'],
            'description'    => ['nullable'],
            'products'       => ['required' , 'array'],
            'products.*'     => ['required' , 'numeric'],
        ]);
        $invoice = auth()->user()->invoice()->create([
            'price'          => $request->price,
            'account_number' => $request->account_number,
            'description'    => $request->description
        ]);

        if(isset($request->products) && is_array($request->products) && count($request->products) > 0)
        {
            $invoice->products()->attach($request->products);
        }

        Session::flash('message', 'فاکتور با موفقیت ایجاد شد.');
        return redirect()->route('agent.invoice.index');
    }

    public function edit(Invoice $invoice)
    {
        $products= Product::all();
        return view('agent.invoices.edit')
            ->with(['invoice'  => $invoice])
            ->with(['products' => $products]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $this->validate($request , [
            'price'          => ['required','numeric'],
            'account_number' => ['required','numeric'],
            'description'    => ['nullable'],
            'products'       => ['required' , 'array'],
            'products.*'     => ['required' , 'numeric'],
        ]);

        $invoice->update([
            'price'          => $request->price,
            'account_number' => $request->account_number,
            'description'    => $request->description
        ]);

        if(isset($request->products) && is_array($request->products) && count($request->products) > 0)
        {
            $invoice->products()->sync($request->products);
        }
        Session::flash('message', 'فاکتور با موفقیت ویرایش شد.');
        return redirect()->route('agent.invoice.index');
    }


    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        Session::flash('message', 'فاکتور با موفقیت حذف شد.');
        return redirect()->route('agent.invoice.index');
    }

}
