<?php

namespace App\Http\Controllers\Admin;

use App\Functions\DateFormatter;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::query()->with('user')->filter(request()->all()) ;
        $users    = User::all();

        return view('admin.invoices.index')
            ->with(['users'    => $users])
            ->with(['invoices' => $invoices]);
    }
    public function edit(Invoice $invoice)
    {
        $products= Product::all();
        return view('admin.invoices.edit')
            ->with(['invoice' => $invoice])
            ->with(['products' => $products]);
    }

    public function update(Invoice $invoice, Request $request)
    {
        $this->validate($request , [
            'price'                 => ['required'],
            'paid_by'               => ['required','in:card,gateway'],
            'account_number'        => ['nullable','numeric'],
            'gateway_tracking_code' => ['nullable','numeric'],
            'description'           => ['nullable'],
            'products'              => ['required' , 'array'],
            'products.*'            => ['required' , 'numeric'],
            'status'                => ['required' , 'in:sent,approved,rejected'],
            'paid_at_date'          => ['required' , 'min:10' , 'max:10'],
            'paid_at_time'          => ['required'],
        ]);

        $invoice->update([
            'price'                 => str_replace(',' , '' , $request->price),
            'paid_by'               => $request->paid_by,
            'account_number'        => $request->account_number,
            'gateway_tracking_code' => $request->gateway_tracking_code,
            'description'           => $request->description,
            'status'                => $request->status,
            'paid_at'               => DateFormatter::format($request->paid_at_date , $request->paid_at_time),
        ]);

        if(isset($request->products) && is_array($request->products) && count($request->products) > 0)
        {
            $invoice->products()->sync($request->products);
        }

        Session::flash('message', 'رسید   با موفقیت ویرایش شد.');
        return redirect()->route('admin.invoice.index');
    }

    public function destroy(User $agent, Invoice $invoice)
    {
        $invoice->delete();
        Session::flash('message', 'رسید   با موفقیت حذف شد.');
        return redirect()->route('admin.invoice.index');
    }

    public function status(Invoice $invoice, Request $request)
    {
        $this->validate($request, [
            'status' => ['required' , 'in:approved,rejected,sent']
        ]);

        $invoice->status = $request->status;
        $invoice->save();
        return redirect()->back();
    }
}
