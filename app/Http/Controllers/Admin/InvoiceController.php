<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InvoiceController extends Controller
{
    public function index(User $agent)
    {
        $invoices = $agent->invoice()->latest()->paginate(Invoice::PAGINATION_LIMIT);

        return view('admin.users.agents.Invoices.index')
               ->with(['invoices' => $invoices])
               ->with(['agent'    => $agent]);
    }

    public function edit(User $agent, Invoice $invoice)
    {
        $products= Product::all();
        return view('admin.users.agents.Invoices.edit')
            ->with(['invoice' => $invoice])
            ->with(['products' => $products])
            ->with(['agent'    => $agent]);
    }

    public function update(User $agent, Invoice $invoice, Request $request)
    {
        $this->validate($request , [
            'price'          => ['required','numeric'],
            'account_number' => ['required','numeric'],
            'description'    => ['nullable'],
            'products'       => ['required' , 'array'],
            'products.*'     => ['required' , 'numeric'],
            'status'         => ['required' , 'in:sent,approved,rejected'],
        ]);

        $invoice->update([
            'price'          => $request->price,
            'account_number' => $request->account_number,
            'description'    => $request->description,
            'status'         => $request->status
        ]);

        if(isset($request->products) && is_array($request->products) && count($request->products) > 0)
        {
            $invoice->products()->sync($request->products);
        }

        Session::flash('message', 'فاکتور با موفقیت ویرایش شد.');
        return redirect()->route('admin.agent.invoice.index', ['agent' => $agent->id]);
    }

    public function destroy(User $agent, Invoice $invoice)
    {
        $invoice->delete();
        Session::flash('message', 'فاکتور با موفقیت حذف شد.');
        return redirect()->route('admin.agent.invoice.index' , ['agent' => $agent->id]);
    }
}
